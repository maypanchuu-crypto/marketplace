<?php

use App\Models\ChatRoom;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, listen};


state([
    'activeRoomId' => null,
    'newMessageText' => '',
    'rooms' => fn() => ChatRoom::where('user_one_id', Auth::id())->orWhere('user_two_id', Auth::id())->get(),
    'messages' => fn() => $this->activeRoomId ? Message::where('chat_room_id', $this->activeRoomId)->oldest()->get() : []
]);


listen("echo:chat.{activeRoomId},MessageSent", function () {
    
});


$selectRoom = function ($roomId) {
    $this->activeRoomId = $roomId;
    $this->newMessageText = '';
};


$sendMessage = function () {
    if (trim($this->newMessageText) == '') return;

    $message = Message::create([
        'chat_room_id' => $this->activeRoomId,
        'sender_id' => Auth::id(),
        'message' => $this->newMessageText,
    ]);

    
    broadcast(new MessageSent($message))->toOthers();

    $this->newMessageText = '';
};
?>


<div class="flex h-[80vh] bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
    
   
    <div class="w-1/3 border-r border-gray-200 dark:border-gray-700 flex flex-col bg-white dark:bg-gray-800">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 font-bold text-gray-900 dark:text-white">
            Inbox 
        </div>
        <div class="flex-grow overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700/50">
            @forelse($rooms as $room)
                @php
                    $otherUser = $room->user_one_id === Auth::id() ? App\Models\User::find($room->user_two_id) : App\Models\User::find($room->user_one_id);
                @endphp
                <button wire:click="selectRoom({{ $room->id }})" 
                    class="w-full text-left p-4 flex items-center gap-3 transition-colors {{ $activeRoomId == $room->id ? 'bg-blue-50 dark:bg-blue-950/30' : 'hover:bg-gray-50 dark:hover:bg-gray-700/30' }}">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($otherUser->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-grow">
                        <p class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $otherUser->name }}</p>
                        <p class="text-xs text-gray-400">({{ ucfirst($otherUser->role) }})</p>
                    </div>
                </button>
            @empty
                <div class="p-8 text-center text-xs text-gray-400">No conversations yet.</div>
            @endforelse
        </div>
    </div>

    <!-- 💬 Messages Stream -->
    <div class="w-2/3 flex flex-col bg-gray-50/50 dark:bg-gray-900/10">
        @if($activeRoomId)
            <!-- Messages Display -->
            <div class="flex-grow p-4 overflow-y-auto space-y-3 flex flex-col" x-data x-init="$el.scrollTop = $el.scrollHeight" @refreshChat.window="setTimeout(() => $el.scrollTop = $el.scrollHeight, 50)">
                @foreach($messages as $msg)
                    <div class="max-w-[70%] rounded-2xl px-4 py-2 text-sm shadow-sm {{ $msg->sender_id === Auth::id() ? 'bg-blue-600 text-white self-end rounded-tr-none' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white self-start rounded-tl-none border dark:border-gray-700' }}">
                        <p class="leading-relaxed">{{ $msg->message }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Message Input Area -->
            <form wire:submit.prevent="sendMessage" class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex gap-2">
                <input type="text" wire:model="newMessageText" placeholder="Type a message..." 
                    class="flex-grow text-sm bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition">
                    Send
                </button>
            </form>
        @else
            <!-- Default Empty Screen -->
            <div class="flex-grow flex flex-col items-center justify-center text-gray-400 gap-2 text-sm">
                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>Select a conversation to start Real-time Chat!</span>
            </div>
        @endif
    </div>
</div>