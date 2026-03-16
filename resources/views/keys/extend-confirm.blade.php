@push('styles')
<style>
/* ── EXTEND CONFIRM — NETKEY DESIGN OVERRIDES ── */

/* Container & Cards */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Gradient block inside card */
.bg-gradient-to-r.from-green-600.to-teal-600 {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%) !important; /* Navy to Blue */
}

/* Sub-card details */
.bg-gray-50.dark\:bg-gray-900 {
    background: var(--bg-elevated) !important;
    border-color: var(--border) !important;
}

/* Text Highlights */
.text-indigo-600, .dark\:text-indigo-400 {
    color: #2563eb !important; /* Blue-600 */
}

/* Payment Method Cards */
.peer-checked\:border-yellow-500:checked ~ div { border-color: #f59e0b !important; }
.peer-checked\:bg-yellow-50:checked ~ div { background: rgba(245, 158, 11, 0.05) !important; }
.dark .peer-checked\:bg-yellow-900\/20:checked ~ div { background: rgba(245, 158, 11, 0.1) !important; }

.peer-checked\:border-green-500:checked ~ div { border-color: #10b981 !important; }
.peer-checked\:bg-green-50:checked ~ div { background: rgba(16, 185, 129, 0.05) !important; }
.dark .peer-checked\:bg-green-900\/20:checked ~ div { background: rgba(16, 185, 129, 0.1) !important; }

.hover\:border-yellow-500:hover { border-color: rgba(245, 158, 11, 0.5) !important; }
.hover\:border-green-500:hover { border-color: rgba(16, 185, 129, 0.5) !important; }

/* Action Buttons */
button.bg-gradient-to-r.from-indigo-600.to-purple-600 {
    background: #2563eb !important; /* Primary blue */
}
button.hover\:from-indigo-700.hover\:to-purple-700:hover {
    background: #1d4ed8 !important; /* Darker blue */
}
a.bg-gray-200.hover\:bg-gray-300 {
    background: var(--bg-elevated) !important;
    color: var(--text-color) !important;
}
a.bg-gray-200.hover\:bg-gray-300:hover {
    background: var(--border) !important;
}
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('keys.index') }}" 
               class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                {{ __('Confirm Key Extension') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 p-6 text-white text-center">
                <h3 class="text-xl font-bold uppercase tracking-wider">{{ __('Extend Service Package') }}</h3>
                <p class="opacity-90 mt-1">{{ __('Extending for Key') }}: <span class="font-mono font-bold bg-white/20 px-2 py-0.5 rounded">{{ $key->key_code }}</span></p>
            </div>

            <div class="p-8">
                <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-900 p-4 rounded-xl mb-8 border border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Original Product Package') }}</p>
                        <h4 class="text-xl font-bold text-gray-800 dark:text-white">{{ $key->product->name }}</h4>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Time to Add') }}</p>
                        <h4 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">+ {{ number_format($key->product->duration_minutes) }} {{ __('minutes') }}</h4>
                    </div>
                </div>

                <form action="{{ route('keys.process-extension', $key->id) }}" method="POST" id="extendForm">
                    @csrf

                    <h4 class="font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Select Payment Method') }}:</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="wallet" class="peer sr-only" checked>
                            <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-yellow-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/20 transition-all h-full">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">💰</div>
                                    <span class="font-bold text-gray-800 dark:text-white">{{ __('Coinkey Wallet') }}</span>
                                </div>
                                <div class="text-2xl font-bold text-yellow-600">{{ number_format($key->product->coinkey_amount) }} Coin</div>
                                <div class="text-xs text-gray-500 mt-1">{{ __('Balance') }}: {{ number_format($wallet->balance) }} Coin</div>
                                @if ($wallet->balance < $key->product->coinkey_amount)
                                    <p class="text-red-500 text-xs font-bold mt-2">⚠️ {{ __('Insufficient Balance') }}</p>
                                @endif
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-green-500 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all h-full">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 bg-green-100 text-green-600 rounded-lg">🏦</div>
                                    <span class="font-bold text-gray-800 dark:text-white">{{ __('Bank Transfer / QR') }}</span>
                                </div>
                                <div class="text-2xl font-bold text-green-600">{{ number_format($key->product->price) }} VND</div>
                                <div class="text-xs text-gray-500 mt-1">{{ __('Pay via PayOS') }}</div>
                            </div>
                        </label>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('keys.index') }}" class="w-1/3 py-3 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="w-2/3 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                            {{ __('Confirm Extension') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
