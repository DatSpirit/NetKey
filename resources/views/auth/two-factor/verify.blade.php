<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-700 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">Xác minh 2FA</h2>
        </div>
    </x-slot>

    <div class="py-12 px-4 flex items-center justify-center min-h-[70vh]">
        <div class="w-full max-w-sm">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-2xl">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-indigo-900 to-blue-900 px-6 py-6 text-center">
                    <div class="text-4xl mb-2">🔒</div>
                    <h1 class="text-white text-xl font-bold">Xác minh 2FA</h1>
                    <p class="text-blue-200 text-sm mt-1">Nhập mã OTP từ ứng dụng Authenticator</p>
                </div>

                <div class="p-6">
                    @if(session('error'))
                    <div class="bg-red-50 dark:bg-red-500/20 border border-red-200 dark:border-red-500/50 text-red-600 dark:text-red-400 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('two-factor.verify.post') }}">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-gray-500 dark:text-gray-400 text-sm mb-2 text-center">Mã OTP 6 chữ số:</label>
                            <input type="text" name="otp" inputmode="numeric" pattern="\d{6}" maxlength="6"
                                placeholder="000000"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-center text-3xl tracking-widest font-mono rounded-xl px-4 py-4 border @error('otp') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                                autofocus required>
                            @error('otp')
                                <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white rounded-xl font-semibold transition duration-150">
                            Xác nhận
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-gray-400 text-xs">Mã OTP thay đổi mỗi 30 giây.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
