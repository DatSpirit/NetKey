{{-- thankyou.blade.php - REFACTORED với METADATA làm CORE + NETKEY DESIGN OVERRIDES --}}

@push('styles')
<style>
/* ── THANK YOU PAGE — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements & Specific Meta Cards */
.bg-indigo-50.dark\:bg-indigo-900\/20,
.bg-blue-50.dark\:bg-blue-900\/20,
.bg-purple-50.dark\:bg-purple-900\/20,
.bg-emerald-50.dark\:bg-emerald-900\/20,
.bg-orange-50.dark\:bg-orange-900\/20 {
    background: var(--bg-elevated) !important;
    border-color: var(--border) !important;
}

/* Data blocks */
.bg-white.dark\:bg-gray-700, .bg-gray-100.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border-color: var(--border) !important;
}

/* Highlights & Buttons */
.text-indigo-600, .dark\:text-indigo-400,
.text-indigo-700,
.text-blue-700, .dark\:text-blue-400,
.text-blue-600 { color: #2563eb !important; }

.bg-indigo-600, .bg-blue-600 { background-color: #2563eb !important; }
.hover\:bg-indigo-700:hover, .hover\:bg-blue-700:hover { background-color: #1d4ed8 !important; }

/* Status Text Colors */
.text-green-600, .text-emerald-600, .text-emerald-700 { color: #10b981 !important; }
.text-yellow-600, .text-orange-600, .text-orange-700 { color: #f59e0b !important; }
.text-red-600 { color: #ef4444 !important; }

/* Dashboard Button */
a.bg-gray-600.hover\:bg-gray-700 {
    background: var(--bg-elevated) !important;
    color: var(--text-color) !important;
    border: 1px solid var(--border) !important;
}
a.bg-gray-600.hover\:bg-gray-700:hover {
    background: var(--border) !important;
}
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                @if($transaction->status === 'success')
                    <svg class="w-8 h-8 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif($transaction->status === 'pending')
                    <svg class="w-8 h-8 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="w-8 h-8 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
                {{ __('Transaction Status') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS CARD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl mb-6 border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-center relative overflow-hidden">
                    {{-- Decorative background logic based on status --}}
                    @if($transaction->status === 'success')
                        <div class="absolute inset-0 bg-green-50 dark:bg-green-900/10 opacity-50 z-0 pointer-events-none"></div>
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-green-400 dark:bg-green-600 rounded-full blur-3xl opacity-20 pointer-events-none z-0"></div>
                        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-emerald-400 dark:bg-emerald-600 rounded-full blur-3xl opacity-20 pointer-events-none z-0"></div>
                    @elseif($transaction->status === 'pending')
                        <div class="absolute inset-0 bg-yellow-50 dark:bg-yellow-900/10 opacity-50 z-0 pointer-events-none"></div>
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-yellow-400 dark:bg-yellow-600 rounded-full blur-3xl opacity-20 pointer-events-none z-0"></div>
                        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-orange-400 dark:bg-orange-600 rounded-full blur-3xl opacity-20 pointer-events-none z-0"></div>
                    @else
                        <div class="absolute inset-0 bg-red-50 dark:bg-red-900/10 opacity-50 z-0 pointer-events-none"></div>
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-red-400 dark:bg-red-600 rounded-full blur-3xl opacity-20 pointer-events-none z-0"></div>
                        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-pink-400 dark:bg-pink-600 rounded-full blur-3xl opacity-20 pointer-events-none z-0"></div>
                    @endif

                    <div class="relative z-10 flex flex-col items-center justify-center">
                        @if($transaction->status === 'success')
                            <div class="w-24 h-24 mb-6 bg-green-100 dark:bg-green-800 border-4 border-white dark:border-gray-700 rounded-full flex items-center justify-center shadow-lg transform transition-all hover:scale-110">
                                <svg class="w-12 h-12 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">
                                {{ __('Payment Successful!') }}
                            </h2>
                        @elseif($transaction->status === 'pending')
                            <div class="w-24 h-24 mb-6 bg-yellow-100 dark:bg-yellow-800 border-4 border-white dark:border-gray-700 rounded-full flex items-center justify-center shadow-lg transform transition-all hover:scale-110">
                                <svg class="w-12 h-12 text-yellow-500 dark:text-yellow-300 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">
                                {{ __('Processing Payment...') }}
                            </h2>
                        @else
                            <div class="w-24 h-24 mb-6 bg-red-100 dark:bg-red-800 border-4 border-white dark:border-gray-700 rounded-full flex items-center justify-center shadow-lg transform transition-all hover:scale-110">
                                <svg class="w-12 h-12 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">
                                {{ __('Payment Failed') }}
                            </h2>
                        @endif

                        <p class="text-gray-600 dark:text-gray-400 mt-2 text-lg">
                            {{ __('Order Code') }}: <span class="px-3 py-1 font-mono text-xl font-bold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700/50 rounded-lg ml-2 border border-gray-200 dark:border-gray-600">{{ $transaction->order_code }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- TRANSACTION DETAILS --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl mb-6 border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        {{ __('Transaction Info') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-xl border border-gray-100 dark:border-gray-600 flex flex-col justify-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Amount') }}</span>
                            <span class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                                {{ number_format($transaction->amount) }}
                                <span class="text-base font-bold text-gray-500">{{ $transaction->currency === 'COINKEY' ? 'Coin' : 'VND' }}</span>
                            </span>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-xl border border-gray-100 dark:border-gray-600 flex flex-col justify-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Status') }}</span>
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold border border-gray-200 dark:border-gray-600 {{ $transaction->status === 'success' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 border-green-200 dark:border-green-800' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 border-red-200 dark:border-red-800') }}">
                                    @if($transaction->status == 'success')
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @elseif($transaction->status == 'pending')
                                    <svg class="w-4 h-4 mr-1.5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    @else
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-5 rounded-xl border border-gray-100 dark:border-gray-600 flex flex-col justify-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('Time') }}</span>
                            <span class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENT BY TYPE (sử dụng METADATA) --}}

            {{-- 1️⃣ CUSTOM EXTENSION --}}
            @if($is_custom_extension)
                <div
                    class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 shadow-lg rounded-2xl p-8 mb-8 relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 opacity-10 pointer-events-none">
                        <span class="text-[12rem] leading-none">🎯</span>
                    </div>

                    <div class="flex items-start gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow border border-indigo-200 dark:border-indigo-700">
                            <span class="text-3xl">🎯</span>
                        </div>
                        <div class="mt-1">
                            <h3 class="text-2xl font-bold text-indigo-700 dark:text-indigo-400 tracking-tight">
                                {{ __('Custom Extension Success') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">
                                {{ __('Key has been extended') }} <span class="font-bold text-gray-900 dark:text-white">{{ $days_added ?? 0 }} {{ __('days') }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl p-6 border border-indigo-100 dark:border-indigo-800/50 mb-6 relative z-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 text-base">
                            @if($key_code)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Key Code:</span>
                                    <code class="inline-block bg-white dark:bg-gray-800 px-4 py-2 rounded-lg font-mono font-bold text-lg text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 shadow-sm">
                                        {{ $key_code }}
                                    </code>
                                </div>
                            @endif

                            @if($package_name)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Gói gia hạn:</span>
                                    <span class="inline-block font-bold text-lg text-indigo-700 dark:text-indigo-400">{{ $package_name }}</span>
                                </div>
                            @endif

                            @if($days_added)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Thời gian cộng:</span>
                                    <span class="inline-flex items-center font-bold text-lg text-green-600 dark:text-green-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        {{ $days_added }} ngày
                                    </span>
                                </div>
                            @endif

                            @if($key && $key->expires_at)
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Hết hạn mới:</span>
                                    <span class="inline-block font-semibold text-lg text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-md border border-red-100 dark:border-red-900/50">
                                        {{ $key->expires_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($key)
                        <div class="relative z-10 mt-2">
                            <a href="{{ route('keys.keydetails', $key->id) }}"
                                class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                {{ __('View Key Details') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- 2️⃣ STANDARD EXTENSION --}}
            @elseif($is_key_extension && !$is_custom_extension)
                <div
                    class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 shadow-lg rounded-2xl p-8 mb-8 relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 opacity-10 pointer-events-none">
                        <span class="text-[12rem] leading-none">⏱️</span>
                    </div>

                    <div class="flex items-start gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 bg-orange-100 dark:bg-orange-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow border border-orange-200 dark:border-orange-700">
                            <span class="text-3xl">⏱️</span>
                        </div>
                        <div class="mt-1">
                            <h3 class="text-2xl font-bold text-orange-700 dark:text-orange-400 tracking-tight">
                                {{ __('Key Extension Success') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">
                                {{ __('Key has been extended') }} <span class="font-bold text-gray-900 dark:text-white">{{ number_format($duration_minutes ?? 0) }} {{ __('minutes') }}</span>
                            </p>
                        </div>
                    </div>

                    @if($key)
                        <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl p-6 border border-orange-100 dark:border-orange-800/50 mb-6 relative z-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 text-base">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Key Code:</span>
                                    <code class="inline-block bg-white dark:bg-gray-800 px-4 py-2 rounded-lg font-mono font-bold text-lg text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 shadow-sm">
                                        {{ $key->key_code }}
                                    </code>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Hết hạn mới:</span>
                                    <span class="inline-block font-semibold text-lg text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-md border border-red-100 dark:border-red-900/50">
                                        {{ $key->expires_at ? $key->expires_at->format('d/m/Y H:i') : 'Vĩnh viễn' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 mt-2">
                            <a href="{{ route('keys.keydetails', $key->id) }}"
                                class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                {{ __('View Key Details') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- 3️⃣ CUSTOM KEY PURCHASE --}}
            @elseif($is_custom_key_purchase)
                <div
                    class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 shadow-lg rounded-2xl p-8 mb-8 relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 opacity-10 pointer-events-none">
                        <span class="text-[12rem] leading-none">🎨</span>
                    </div>

                    <div class="flex items-start gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 bg-purple-100 dark:bg-purple-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow border border-purple-200 dark:border-purple-700">
                            <span class="text-3xl">🎨</span>
                        </div>
                        <div class="mt-1">
                            <h3 class="text-2xl font-bold text-purple-700 dark:text-purple-400 tracking-tight">
                                {{ __('Custom Key Created') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">
                                {{ __('Your custom key is ready') }}
                            </p>
                        </div>
                    </div>

                    @if($key)
                        <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl p-6 border border-purple-100 dark:border-purple-800/50 mb-6 relative z-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-6 text-base">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Key Code (Custom):</span>
                                    <code class="inline-block bg-purple-100 dark:bg-purple-900/50 px-3 py-2 rounded-lg font-mono font-bold text-lg text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800 shadow-sm">
                                        {{ $key->key_code }}
                                    </code>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">{{ __('Duration') }}:</span>
                                    <span class="inline-flex items-center font-bold text-lg text-purple-700 dark:text-purple-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ number_format($duration_minutes ?? 0) }} {{ __('minutes') }}
                                    </span>
                                </div>
                                @if($key->expires_at)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Hết hạn:</span>
                                        <span class="inline-block font-semibold text-lg text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-md border border-red-100 dark:border-red-900/50">
                                            {{ $key->expires_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="relative z-10 mt-2">
                            <a href="{{ route('keys.keydetails', $key->id) }}"
                                class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                {{ __('View Key Details') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- 4️⃣ PACKAGE PURCHASE --}}
            @elseif($is_package_purchase)
                @if($key)
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 shadow-lg rounded-2xl p-8 mb-8 relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 opacity-10 pointer-events-none">
                            <span class="text-[12rem] leading-none">🔑</span>
                        </div>

                        <div class="flex items-start gap-4 mb-6 relative z-10">
                            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow border border-blue-200 dark:border-blue-700">
                                <span class="text-3xl">🔑</span>
                            </div>
                            <div class="mt-1">
                                <h3 class="text-2xl font-bold text-blue-700 dark:text-blue-400 tracking-tight">
                                    {{ __('New Key Created') }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 font-medium">
                                    {{ $product?->name ?? 'Package' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl p-6 border border-blue-100 dark:border-blue-800/50 mb-6 relative z-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-6 text-base">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Key Code:</span>
                                    <code class="inline-block bg-white dark:bg-gray-800 px-4 py-2 rounded-lg font-mono font-bold text-lg text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 shadow-sm">
                                        {{ $key->key_code }}
                                    </code>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Thời hạn:</span>
                                    <span class="inline-flex items-center font-bold text-lg text-blue-700 dark:text-blue-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ number_format($key->duration_minutes) }} phút
                                    </span>
                                </div>
                                @if($key->expires_at)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Hết hạn:</span>
                                        <span class="inline-block font-semibold text-lg text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-md border border-red-100 dark:border-red-900/50">
                                            {{ $key->expires_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="relative z-10 mt-2">
                            <a href="{{ route('keys.keydetails', $key->id) }}"
                                class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                {{ __('View Key Details') }}
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Direct Account Extension (No Key) --}}
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 shadow-lg rounded-2xl p-8 mb-8 relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 opacity-10 pointer-events-none">
                            <span class="text-[12rem] leading-none">🎉</span>
                        </div>

                        <div class="flex items-start gap-4 mb-6 relative z-10">
                            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow border border-blue-200 dark:border-blue-700">
                                <span class="text-3xl">🎉</span>
                            </div>
                            <div class="mt-1">
                                <h3 class="text-2xl font-bold text-blue-700 dark:text-blue-400 tracking-tight">
                                    {{ __('Account Extension Success') }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 font-medium">
                                    {{ __('Account usage extended') }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl p-6 border border-blue-100 dark:border-blue-800/50 relative z-10">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-6 text-base">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Gói gia hạn:</span>
                                    <span class="inline-block font-bold text-lg text-gray-800 dark:text-white">
                                        {{ $product?->name ?? 'Service Package' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Thời gian cộng thêm:</span>
                                    <span class="inline-flex items-center font-bold text-lg text-green-600 dark:text-green-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        +{{ number_format($duration_minutes) }} phút
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 block mb-1">Hết hạn mới:</span>
                                    <span class="inline-block font-semibold text-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-md border border-blue-100 dark:border-blue-900/50">
                                        {{ auth()->user()->expires_at ? auth()->user()->expires_at->format('d/m/Y H:i') : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 5️⃣ COINKEY DEPOSIT --}}
            @elseif($is_coinkey_deposit)
                <div
                    class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 shadow-lg rounded-2xl p-8 mb-8 relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 opacity-10 pointer-events-none">
                        <span class="text-[12rem] leading-none">💰</span>
                    </div>

                    <div class="flex items-start gap-4 mb-6 relative z-10">
                        <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-800 rounded-xl flex items-center justify-center flex-shrink-0 shadow border border-emerald-200 dark:border-emerald-700">
                            <span class="text-3xl">💰</span>
                        </div>
                        <div class="mt-1">
                            <h3 class="text-2xl font-bold text-emerald-700 dark:text-emerald-400 tracking-tight">
                                {{ __('Coinkey Deposit Success') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">
                                {{ __('Balance Updated') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-center bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl p-8 border border-emerald-100 dark:border-emerald-800/50 relative z-10">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">{{ __('Amount Added') }}</p>
                        <p class="text-5xl font-black text-emerald-600 dark:text-emerald-400 mb-6 drop-shadow-sm">
                            +{{ number_format($product?->coinkey_amount ?? 0) }} <span class="text-2xl text-emerald-500 dark:text-emerald-500/80 tracking-normal">Coin</span>
                        </p>
                        <a href="{{ route('wallet.index') }}"
                            class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            {{ __('View My Wallet') }}
                        </a>
                    </div>
                </div>
            @endif

            {{-- ACTIONS --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <a href="{{ route('dashboard') }}"
                    class="flex-1 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 hover:border-gray-300 dark:hover:border-gray-600 font-bold text-center py-4 rounded-xl shadow-sm hover:shadow-md transition-all flex items-center justify-center group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('Go to Dashboard') }}
                </a>
                <a href="{{ route('keys.index') }}"
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-center font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center group">
                    {{ __('View My Keys') }}
                    <svg class="w-5 h-5 ml-3 opacity-70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>