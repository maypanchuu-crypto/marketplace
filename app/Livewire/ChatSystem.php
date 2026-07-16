<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatSystem extends Component
{
    public $activeRoomId = null;
    public $newMessageText = '';

   protected $listeners = ['refreshChat' => '$refresh'];

    public function refreshChat()
    {
        
    }

    public function render()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->role === 'admin') {
            // 😎 Admin ဖြစ်ခဲ့ရင်: သူ့ဆီ စာလာပို့ထားသမျှ Chat Rooms အားလုံးကို ပြမယ်
            $rooms = ChatRoom::where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId)
                ->get();
        } else {
            // 👥 Customer သို့မဟုတ် Vendor ဖြစ်ခဲ့ရင်: Admin နဲ့ စကားပြောဖို့ တစ်ခန်းပဲ ရှိရမယ်
            // အရင်ဆုံး Database ထဲမှာ Admin အသုံးပြုသူကို ရှာမယ်
            $admin = \App\Models\User::where('role', 'admin')->first();

            if ($admin) {
                // Admin နဲ့ ရှိပြီးသား Chat Room ကို ရှာမယ်၊ မရှိရင် အသစ်တစ်ခု ဆောက်ပေးမယ် (FirstOrCreate)
                $room = ChatRoom::firstOrCreate(
                    [
                        'user_one_id' => min($userId, $admin->id),
                        'user_two_id' => max($userId, $admin->id),
                    ],
                    [
                        'type' => 'customer_admin', // သို့မဟုတ် 'vendor_admin'
                    ]
                );

                // Customer/Vendor ရဲ့ Inbox ထဲမှာ Admin နဲ့ ခန်း တစ်ခန်းပဲ မြင်ရအောင် Array ထဲ ထည့်ပေးမယ်
                $rooms = collect([$room]);

                // စာမျက်နှာ စဖွင့်ချင်းမှာပဲ Admin နဲ့ Chat Room ကို အလိုအလျောက် ရွေးပေးထားမယ်
                if (is_null($this->activeRoomId)) {
                    $this->activeRoomId = $room->id;
                }
            } else {
                $rooms = collect([]);
            }
        }

        // ဖွင့်ထားတဲ့ Chat Room ထဲက စာတွေကို ဆွဲထုတ်မယ်
        $messages = [];
        if ($this->activeRoomId) {
            $messages = Message::where('chat_room_id', $this->activeRoomId)->oldest()->get();
        }

        return view('livewire.chat-system', [
            'rooms' => $rooms,
            'messages' => $messages
        ]);
    }

    public function selectRoom($roomId)
    {
        $this->activeRoomId = $roomId;
    }

    public function sendMessage()
    {
        if (trim($this->newMessageText) == '')
            return;

        $message = Message::create([
            'chat_room_id' => $this->activeRoomId,
            'sender_id' => Auth::id(),
            'message' => $this->newMessageText,
        ]);

        // 🚀 ဒီနေရာမှာ Pusher ရဲ့ Real-time Event ကို အလုပ်ပေးလိုက်တာပါ!
        broadcast(new MessageSent($message))->toOthers();

        $this->newMessageText = '';
        $this->dispatch('refreshChat');
    }
}
