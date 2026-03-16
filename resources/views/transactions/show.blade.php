@push('styles')
<style>
/* ── TRANSACTION DETAILS — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-gray-50.dark\:bg-gray-700 {
    background: var(--bg-elevated) !important;
    border-color: var(--border) !important;
}

/* Highlights & Buttons */
.text-indigo-600, .dark\:text-indigo-400 { color: #2563eb !important; }
.bg-indigo-600 { background-color: #2563eb !important; }
.hover\:bg-indigo-700:hover { background-color: #1d4ed8 !important; }
.from-indigo-500.to-purple-600 { background: #2563eb !important; }
.bg-indigo-100.dark\:bg-indigo-900\/30 { background: rgba(37,99,235,0.1) !important; }

/* Status Colors Adjustments */
.from-green-500.to-emerald-600 { background: linear-gradient(to right, #10b981, #059669) !important; }
.from-yellow-500.to-orange-600 { background: linear-gradient(to right, #f59e0b, #ea580c) !important; }
.from-red-500.to-pink-600 { background: linear-gradient(to right, #ef4444, #db2777) !important; }
.from-gray-500.to-gray-600 { background: linear-gradient(to right, #6b7280, #4b5563) !important; }

/* Borders */
.border-b.border-gray-200.dark\:border-gray-700 {
    border-color: var(--border) !important;
}
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('transactions.index') }}"
                    class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('Transaction Details') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Order') }}
                        #{{ $transaction->order_code }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @if($transaction->status === 'success')
                    <button onclick="printInvoice()"
                        class="hidden sm:flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        {{ __('Print Invoice') }}
                    </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Status Banner --}}
        <div class="
            @if($transaction->status === 'success') bg-gradient-to-r from-green-500 to-emerald-600
            @elseif($transaction->status === 'pending') bg-gradient-to-r from-yellow-500 to-orange-600
            @elseif($transaction->status === 'failed') bg-gradient-to-r from-gray-500 to-gray-600
            @else bg-gradient-to-r from-red-500 to-pink-600
            @endif
            rounded-2xl shadow-xl p-8 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <div class="flex items-center justify-center md:justify-start space-x-3 mb-3">
                        <div
                            class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                            @if($transaction->status === 'success')
                                <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($transaction->status === 'pending')
                                <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">
                                @if($transaction->status === 'success') {{ __('Payment Successful') }}
                                @elseif($transaction->status === 'pending') {{ __('Payment Pending') }}
                                @elseif($transaction->status === 'failed') {{ __('Payment Failed') }}
                                @else {{ __('Payment Cancelled') }}
                                @endif
                            </h3>
                            <p class="text-sm opacity-90">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <p class="text-white/90 max-w-xl">
                        @if($transaction->status === 'success')
                            {{ __('Your payment has been processed successfully.') }}
                        @elseif($transaction->status === 'pending')
                            {{ __('Your payment is being processed. Please wait for confirmation.') }}
                        @elseif($transaction->status === 'failed')
                            {{ __('Your payment could not be processed. Please try again.') }}
                        @else
                            {{ __('This transaction has been cancelled.') }}
                        @endif
                    </p>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <p class="text-sm opacity-90 mb-2 font-medium uppercase tracking-wider">{{ __('Transaction Amount') }}</p>
                    <p class="text-4xl font-bold tracking-tight">{{ number_format($transaction->amount) }}</p>
                    <p class="text-sm opacity-75 mt-1 font-semibold">VND</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Transaction Info --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Product Details --}}
                @if($transaction->product)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 overflow-hidden relative">
                        {{-- Decorative background blob --}}
                        <div class="absolute -right-10 -top-10 bg-indigo-50 dark:bg-indigo-900/10 w-40 h-40 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center relative z-10">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </span>
                            {{ __('Product Information') }}
                        </h3>

                        <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-5 p-5 bg-gray-50 dark:bg-gray-700/50 rounded-xl relative z-10 border border-gray-100 dark:border-gray-600">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $transaction->product->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ $transaction->product->description ?? __('No description available') }}</p>
                                <div class="flex flex-wrap items-center gap-3 text-sm">
                                    <span
                                        class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg font-bold border border-indigo-200 dark:border-indigo-800">
                                        {{ number_format($transaction->product->price ?? $transaction->amount) }} VND
                                    </span>
                                    @if($transaction->product->category)
                                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium flex items-center gap-1 border border-gray-200 dark:border-gray-500">
                                            <span>📦</span> {{ $transaction->product->category }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Transaction Details --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        {{ __('Transaction Details') }}
                    </h3>

                    <div class="space-y-4">
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-gray-100 dark:border-gray-700 gap-1">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Order Code') }}</span>
                            <span
                                class="text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-1 rounded border border-gray-200 dark:border-gray-600 inline-block">#{{ $transaction->order_code }}</span>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-gray-100 dark:border-gray-700 gap-1">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Transaction ID') }}</span>
                            <span class="text-sm font-mono text-gray-700 dark:text-gray-300">{{ $transaction->id }}</span>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-gray-100 dark:border-gray-700 gap-1">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</span>
                            @php
                                $statusConfig = [
                                    'success' => ['bg' => 'bg-green-100 dark:bg-green-900/50', 'text' => 'text-green-800 dark:text-green-300', 'border' => 'border-green-200 dark:border-green-800', 'label' => __('Success')],
                                    'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/50', 'text' => 'text-yellow-800 dark:text-yellow-300', 'border' => 'border-yellow-200 dark:border-yellow-800', 'label' => __('Pending')],
                                    'failed' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-300', 'border' => 'border-gray-300 dark:border-gray-600', 'label' => __('Failed')],
                                    'cancelled' => ['bg' => 'bg-red-100 dark:bg-red-900/50', 'text' => 'text-red-800 dark:text-red-300', 'border' => 'border-red-200 dark:border-red-800', 'label' => __('Cancelled')],
                                ];
                                $config = $statusConfig[$transaction->status] ?? $statusConfig['pending'];
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                {{ $config['label'] }}
                            </span>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-gray-100 dark:border-gray-700 gap-1">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Payment Method') }}</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                {{ $transaction->payment_method ?? __('Credit Card') }}
                            </span>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-gray-100 dark:border-gray-700 gap-1">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created At') }}</span>
                            <span
                                class="text-sm text-gray-900 dark:text-white">{{ $transaction->created_at->format('d M Y, H:i:s') }}</span>
                        </div>

                        @if($transaction->updated_at != $transaction->created_at)
                            <div
                                class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-gray-100 dark:border-gray-700 gap-1">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Last Updated') }}</span>
                                <span
                                    class="text-sm text-gray-900 dark:text-white">{{ $transaction->updated_at->format('d M Y, H:i:s') }}</span>
                            </div>
                        @endif

                        @if($transaction->description)
                            <div class="pt-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Description') }}</p>
                                <p class="text-sm text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600 leading-relaxed">
                                    {{ $transaction->description }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Amount Breakdown --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-br from-gray-100 to-transparent dark:from-gray-700/50 dark:to-transparent rounded-bl-full pointer-events-none"></div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 relative z-10">{{ __('Payment Summary') }}</h3>

                    <div class="space-y-4 relative z-10">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Subtotal') }}</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($transaction->amount) }}
                                VND</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Tax') }} (0%)</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">0 VND</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Discount') }}</span>
                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">- 0 VND</span>
                        </div>

                        <div
                            class="pt-5 mt-2 border-t-2 border-dashed border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-wide">{{ __('Total') }}</span>
                            <span
                                class="text-3xl font-black text-indigo-600 dark:text-indigo-400 tracking-tight">{{ number_format($transaction->amount) }} <span class="text-xl font-bold text-gray-500 dark:text-gray-400 ml-1">VND</span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- User Info --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5 flex items-center">
                        <span class="p-1.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        {{ __('Customer Information') }}
                    </h3>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-100 dark:border-gray-600">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-inner flex-shrink-0">
                                <span
                                    class="text-white font-bold text-lg">{{ strtoupper(substr($transaction->user->name, 0, 2)) }}</span>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-base font-bold text-gray-900 dark:text-white truncate" title="{{ $transaction->user->name }}">
                                    {{ $transaction->user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate mt-0.5" title="{{ $transaction->user->email }}">{{ $transaction->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5">{{ __('Quick Actions') }}</h3>

                    <div class="space-y-3">
                        @if($transaction->status === 'pending')
                            <button
                                class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-all flex items-center justify-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5 relative overflow-hidden group">
                                <span class="absolute w-0 h-0 transition-all duration-300 ease-out bg-white rounded-full group-hover:w-32 group-hover:h-32 opacity-10"></span>
                                <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="relative z-10">{{ __('Complete Payment') }}</span>
                            </button>
                            <button
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-red-100 dark:border-red-900/50 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl font-bold transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Cancel Transaction') }}
                            </button>
                        @elseif($transaction->status === 'success')
                            <button onclick="printInvoice()"
                                class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center transform hover:-translate-y-0.5 relative overflow-hidden group">
                                <span class="absolute w-0 h-0 transition-all duration-300 ease-out bg-white rounded-full group-hover:w-32 group-hover:h-32 opacity-10"></span>
                                <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span class="relative z-10">{{ __('Download Invoice') }}</span>
                            </button>
                            <button
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                                {{ __('Request Refund') }}
                            </button>
                        @elseif($transaction->status === 'failed')
                            <button
                                class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center transform hover:-translate-y-0.5 relative overflow-hidden group">
                                <span class="absolute w-0 h-0 transition-all duration-300 ease-out bg-white rounded-full group-hover:w-32 group-hover:h-32 opacity-10"></span>
                                <svg class="w-5 h-5 mr-2 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span class="relative z-10">{{ __('Retry Payment') }}</span>
                            </button>
                        @endif

                        <button
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-transparent hover:border-gray-200 dark:hover:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl font-medium transition-all flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            {{ __('Get Support') }}
                        </button>
                    </div>
                </div>

                {{-- Timeline --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 relative">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center relative z-10">
                        <span class="p-1.5 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        {{ __('Activity Timeline') }}
                    </h3>

                    <div class="space-y-6 relative ml-3">
                        {{-- Timeline line connecting items --}}
                        <div class="absolute w-0.5 bg-gray-200 dark:bg-gray-700 h-full top-2 left-3.5 -z-10 rounded-full"></div>

                        <div class="flex items-start space-x-4 relative">
                            <div
                                class="w-8 h-8 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center flex-shrink-0 border-2 border-indigo-500 z-10 shadow-sm mt-0.5">
                                <div class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ __('Transaction Created') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($transaction->status === 'success')
                            <div class="flex items-start space-x-4 relative">
                                <div
                                    class="w-8 h-8 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center flex-shrink-0 border-2 border-green-500 z-10 shadow-sm mt-0.5">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ __('Payment Completed') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $transaction->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @elseif($transaction->status === 'failed')
                            <div class="flex items-start space-x-4 relative">
                                <div
                                    class="w-8 h-8 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center flex-shrink-0 border-2 border-red-500 z-10 shadow-sm mt-0.5">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ __('Payment Failed') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $transaction->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function printInvoice() {
                window.print();
            }
        </script>
    @endpush
</x-app-layout>