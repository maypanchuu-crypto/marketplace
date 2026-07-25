<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-xl">
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Change Wallet Password</h2>

            <!-- Success Alert -->
            @if (session('status'))
                <div class="p-3 mb-4 bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('wallet.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Current Wallet Password</label>
                    <input type="password" name="current_password" required
                        class="w-full border border-gray-300 p-2.5 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                    @error('current_password')
                        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">New Wallet Password</label>
                    <input type="password" name="new_password" required
                        class="w-full border border-gray-300 p-2.5 rounded-xl text-sm focus:outline-none focus:border-emerald-500"
                        placeholder="အနည်းဆုံး ၆ လုံးဖြည့်ပါ">
                    @error('new_password')
                        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" required
                        class="w-full border border-gray-300 p-2.5 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition shadow-md">
                    Update Wallet Password
                </button>
            </form>
        </div>
    </div>
</x-app-layout>