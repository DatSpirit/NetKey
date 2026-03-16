@push('styles')
<style>
/* ── CANCEL PAGE — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-red-50.dark\:bg-red-900\/20 {
    background: rgba(239, 68, 68, 0.1) !important;
}

/* Highlights & Buttons */
.text-indigo-600, .dark\:text-indigo-400 { color: #2563eb !important; }
.bg-indigo-600 { background-color: #2563eb !important; }
.hover\:bg-indigo-700:hover { background-color: #1d4ed8 !important; }

/* Status Colors Adjustments */
.text-red-600.dark\:text-red-400 { color: #ef4444 !important; }
.bg-red-100.dark\:bg-red-900\/30 { background: rgba(239, 68, 68, 0.15) !important; }
.border-red-200.dark\:border-red-800\/50 { border-color: rgba(239, 68, 68, 0.3) !important; }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center">
            <svg class="w-7 h-7 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ __('Payment Cancelled') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-center min-h-[calc(100vh-16rem)]">
        <div class="max-w-xl w-full bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden relative">
            
            {{-- Decorative Background element --}}
            <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b from-red-50 to-transparent dark:from-red-900/20 pointer-events-none"></div>

            <div class="p-10 text-center relative z-10">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 mb-6 shadow-sm">
                    <svg class="h-12 w-12 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                
                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2 tracking-tight" id="modal-title">
                    {{ __('Transaction Cancelled') }}
                </h3>
                
                <div class="mt-4">
                    <p class="text-lg text-gray-500 dark:text-gray-400">
                        {{ __('Your payment process was interrupted or cancelled.') }}
                    </p>
                </div>

                @if(isset($orderCode))
                <div class="mt-8 bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-100 dark:border-gray-600 inline-block min-w-[50%]">
                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">{{ __('Order Code') }}</span>
                    <span class="block text-xl font-mono font-bold text-gray-900 dark:text-white">{{ $orderCode }}</span>
                </div>
                @endif
                
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products') }}"
                        class="inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        {{ __('Back to Products') }}
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex justify-center items-center px-6 py-3.5 border border-gray-300 dark:border-gray-600 text-base font-bold rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        {{ __('Go to Dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>