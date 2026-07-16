<div
    class="w-full max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 overflow-hidden shadow-sm h-[80vh] flex">

    <!-- ==================== 👥 ADMIN VIEW (၂ ခြမ်းစတိုင် - Responsive) ==================== -->
    @if(Auth::user()->role === 'admin')
        <!-- 👥 Chat Rooms (ဘယ်ဘက်စာရင်း - Mobile မှာ ကွယ်ထားပြီး MD Screen ကျမှ ပြမယ်) -->
        <div
            class="{{ $activeRoomId ? 'hidden md:flex' : 'flex' }} w-full md:w-1/3 border-r dark:border-gray-700 flex-col bg-white dark:bg-gray-800">
            <div class="p-4 border-b dark:border-gray-700 font-bold text-gray-900 dark:text-white">Inbox</div>
            <div class="flex-grow overflow-y-auto">
                @foreach($rooms as $room)
                    @php
                        $otherUser = $room->user_one_id === Auth::id() ? App\Models\User::find($room->user_two_id) : App\Models\User::find($room->user_one_id);
                    @endphp
                    @if($otherUser)
                        <button wire:click="selectRoom({{ $room->id }})"
                            class="w-full text-left p-4 flex items-center gap-3 border-b dark:border-gray-700 {{ $activeRoomId == $room->id ? 'bg-blue-50 dark:bg-blue-900/30' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                                {{ strtoupper(substr($otherUser->name, 0, 2)) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $otherUser->name }}</p>
                                <p class="text-xs text-gray-400">({{ ucfirst($otherUser->role) }})</p>
                            </div>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- 💬 Messages Screen (ညာဘက် စကားပြောခန်း - Mobile မှာ Room ရွေးမှ ပြမယ်) -->
        <div
            class="{{ $activeRoomId ? 'flex' : 'hidden md:flex' }} w-full md:w-2/3 flex-col bg-gray-50 dark:bg-gray-900/30">
            @if($activeRoomId)
                <!-- Mobile Back Button -->
                <div class="p-3 bg-white dark:bg-gray-800 border-b dark:border-gray-700 flex items-center md:hidden">
                    <button wire:click="$set('activeRoomId', null)"
                        class="text-blue-600 font-medium text-sm flex items-center gap-1">
                        ← Back to Inbox
                    </button>
                </div>

                <!-- Messages List -->
                <div class="flex-grow p-4 overflow-y-auto space-y-3 flex flex-col" id="chat-box" x-data
                    x-init="$el.scrollTop = $el.scrollHeight"
                    @refreshChat.window="setTimeout(() => $el.scrollTop = $el.scrollHeight, 50)">
                    @foreach($messages as $msg)
                        <div
                            class="max-w-[75%] rounded-2xl px-4 py-2 text-sm shadow-sm {{ $msg->sender_id === Auth::id() ? 'bg-blue-600 text-white self-end' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white self-start border dark:border-gray-700' }}">
                            <p class="break-words">{{ $msg->message }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Message Input -->
                <form wire:submit.prevent="sendMessage"
                    class="p-4 bg-white dark:bg-gray-800 border-t dark:border-gray-700 flex gap-2">
                    <input type="text" wire:model="newMessageText" placeholder="Type a message..."
                        class="flex-grow text-sm bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl px-4 py-2 text-gray-900 dark:text-white focus:outline-none focus:border-blue-500">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-bold transition">Send</button>
                </form>
            @else
                <div class="flex-grow flex items-center justify-center text-gray-400 text-sm">
                    Select a conversation to start Real-time Chat!
                </div>
            @endif
        </div>

        <!-- ==================== 👥 CUSTOMER / VENDOR VIEW (၁ ခြမ်းတည်း - Responsive) ==================== -->
    @else
        <div class="w-full flex flex-col bg-gray-50 dark:bg-gray-900/30">
            <!-- Header Text -->
            <div class="p-6 bg-white dark:bg-gray-800 border-b dark:border-gray-700 text-center">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">What can we help you?</h2>
                <p class="text-xs text-gray-400 mt-1">Our support team will reply as soon as possible.</p>
            </div>

            <!-- Messages List -->
            <div class="flex-grow p-4 overflow-y-auto space-y-3 flex flex-col" id="chat-box" x-data
                x-init="$el.scrollTop = $el.scrollHeight"
                @refreshChat.window="setTimeout(() => $el.scrollTop = $el.scrollHeight, 50)">

                @forelse($messages as $msg)
                    <div
                        class="max-w-[75%] rounded-2xl px-4 py-2 text-sm shadow-sm {{ $msg->sender_id === Auth::id() ? 'bg-blue-600 text-white self-end' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white self-start border dark:border-gray-700' }}">
                        <p class="break-words">{{ $msg->message }}</p>
                    </div>
                @empty
                    <div class="flex-grow flex items-center justify-center text-gray-400 text-sm h-full">
                        No messages yet. Start the conversation below!
                    </div>
                @endforelse
            </div>

            <!-- Message Input Bar -->
            <form wire:submit.prevent="sendMessage"
                class="p-4 bg-white dark:bg-gray-800 border-t dark:border-gray-700 flex gap-2 items-center">
                <!-- wire:model ပြောင်းထားပြီး စာသားအရောင်ကို text-gray-900 ထည့်ထားလို့ စာရိုက်ရင် မြင်ရပါပြီ -->
                <input type="text" wire:model="newMessageText" placeholder="Type your message here..."
                    class="flex-grow text-sm bg-gray-50 dark:bg-gray-700 border dark:border-gray-600 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:outline-none focus:border-blue-500">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-sm transition">
                    Send
                </button>
            </form>
        </div>
    @endif

</div>