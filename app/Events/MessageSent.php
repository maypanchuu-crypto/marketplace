<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // ဘယ် Channel ကနေ လွှင့်မလဲ (ဥပမာ- chat.1 , chat.2 စသဖြင့် Room အလိုက်ခွဲလွှင့်မယ်)
    public function broadcastOn(): array
    {
        return [
            new Channel('chat.' . $this->message->chat_room_id),
        ];
    }
}