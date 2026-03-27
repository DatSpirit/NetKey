<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">Cài đặt 2FA</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 flex items-start justify-center min-h-[70vh]">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-2xl">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-blue-900 to-indigo-900 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl">🔐</div>
                        <div>
                            <h1 class="text-white text-xl font-bold">Cài đặt 2FA</h1>
                            <p class="text-blue-200 text-sm">Xác thực hai yếu tố cho tài khoản Admin</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <ol class="text-sm text-gray-500 dark:text-gray-400 space-y-2 mb-6">
                        <li class="flex gap-2"><span class="text-blue-500 font-bold">1.</span> Tải app <strong class="text-gray-800 dark:text-white">Google Authenticator</strong> hoặc <strong class="text-gray-800 dark:text-white">Authy</strong> trên điện thoại.</li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold">2.</span> Trong app, chọn <strong class="text-gray-800 dark:text-white">Thêm tài khoản</strong> → Quét mã QR bên dưới.</li>
                        <li class="flex gap-2"><span class="text-blue-500 font-bold">3.</span> Nhập mã 6 số hiện trong app để xác nhận.</li>
                    </ol>

                    {{-- QR Code - SVG generate trực tiếp từ server, không cần internet --}}
                    <div class="flex justify-center mb-6">
                        <div class="bg-white p-6 rounded-2xl inline-block shadow-inner border border-gray-100">
                            <div class="w-48 h-48 flex items-center justify-center">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>
                    </div>

                    {{-- Secret Key hiển thị text --}}
                    <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-3 text-center mb-6">
                        <p class="text-gray-500 text-xs mb-1">Hoặc nhập thủ công mã Secret vào app:</p>
                        <code class="text-green-600 dark:text-green-400 font-mono text-sm tracking-widest">{{ $secret }}</code>
                    </div>

                    @if(session('error'))
                    <div class="bg-red-50 dark:bg-red-500/20 border border-red-200 dark:border-red-500/50 text-red-600 dark:text-red-400 rounded-lg px-4 py-3 mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Confirm Form --}}
                    <form method="POST" action="{{ route('two-factor.confirm') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-500 dark:text-gray-400 text-sm mb-2">Mã OTP 6 số từ app:</label>
                            <input type="text" name="otp" inputmode="numeric" pattern="\d{6}" maxlength="6"
                                placeholder="000000"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-center text-2xl tracking-widest font-mono rounded-lg px-4 py-3 border @error('otp') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror focus:outline-none focus:ring-2 focus:ring-blue-500"
                                autofocus required>
                            @error('otp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                            ✅ Kích hoạt 2FA
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
