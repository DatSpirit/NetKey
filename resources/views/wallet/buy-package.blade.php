@push('styles')
<style>
/* ── VIP STORE — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Base Backgrounds */
.bg-gray-100.dark\:bg-gray-700,
.bg-gray-200.dark\:bg-gray-700 {
    background: var(--bg-elevated) !important;
    border-color: var(--border) !important;
}

/* VIP Badge Container */
.flex.items-center.gap-4.bg-white.dark\:bg-gray-800.p-3.rounded-xl {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Highlights & Buttons */
.text-indigo-600, .dark\:text-indigo-400 { color: #2563eb !important; }

/* Status Text Colors */
.text-green-600, .dark\:text-green-400 { color: #10b981 !important; }
.text-yellow-600, .dark\:text-yellow-500, .text-yellow-500 { color: #f59e0b !important; }

/* Gradients */
.from-indigo-600.to-purple-600 {
    background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%) !important; 
}
.hover\:shadow-indigo-500\/50:hover {
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.5) !important;
}

/* Package Types Badge */
.bg-green-600 { background-color: #10b981 !important; }
.bg-indigo-600 { background-color: #2563eb !important; }

/* VIP Packages Icon Box */
.bg-indigo-100.dark\:bg-indigo-900\/50 {
    background: rgba(37, 99, 235, 0.15) !important;
}

/* Ext Packages Icon Box */
.bg-green-100.dark\:bg-green-900\/50 {
    background: rgba(16, 185, 129, 0.15) !important;
}

</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('wallet.index') }}"
                    class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-3xl text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        {{ __('VIP Store') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Upgrade VIP to unlock exclusive offers') }}</p>
                </div>
            </div>

            <!-- VIP Badge -->
            <div
                class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="text-right flex flex-col justify-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-0.5">{{ __('Current Level') }}</p>
                    <div class="flex items-center justify-end gap-1.5">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <p class="text-xl font-black text-yellow-500 leading-none">VIP {{ $vipLevel }}</p>
                    </div>
                </div>
                <div class="w-px h-10 bg-gray-200 dark:bg-gray-700"></div>
                <div class="flex flex-col justify-center">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-0.5">{{ __('Total deposited') }}</p>
                    <p class="text-lg font-bold text-green-600 dark:text-green-400 leading-none">{{ number_format($wallet->total_deposited) }} <span class="text-xs uppercase">VND</span></p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-12rem)]">
        <!-- SECTION 1: EXTENSION PACKAGES (Gói Gia Hạn & Key) -->
        <div class="mb-12">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <span class="p-2 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                {{ __('Extension & Key Packages') }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($extensionPackages as $item)
                    @php
                        $pkg = $item['product'];
                        $requiredVip = $item['required_vip'];
                        $discountPercent = $item['discount_percent'];
                        $finalPrice = $item['final_price'];
                        $maxBuy = $item['max_buy'];
                        $boughtCount = $item['bought_count'];
                        $canBuy = $item['can_buy'];
                        $isLocked = $item['is_locked'];
                    @endphp
                    <div
                        class="relative group bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                        <div
                            class="absolute top-0 right-0 bg-green-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-bl-2xl z-10 uppercase tracking-widest shadow-sm">
                            Extension
                        </div>

                        <div class="p-6">
                            <div
                                class="w-16 h-16 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/50 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center mb-5 text-2xl shadow-sm">
                                🔑
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 leading-tight">{{ $pkg->name }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-2 min-h-[2.5rem]">{{ $pkg->description }}</p>

                            <!-- Pricing -->
                            <div class="flex items-end gap-2 mb-6">
                                <span class="text-3xl font-black text-gray-900 dark:text-white leading-none">{{ number_format($item['final_price']) }}</span>
                                <span class="text-base font-bold text-yellow-500 mb-0.5">Coin</span>
                            </div>

                            <!-- Action -->
                            <form action="{{ route('order.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $pkg->id }}">
                                <input type="hidden" name="payment_method" value="wallet">
                                <button type="submit"
                                    class="w-full py-3 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-xl font-bold transition-all flex items-center justify-center group-hover:bg-green-50 dark:group-hover:bg-green-900/30 group-hover:border-green-200 dark:group-hover:border-green-700 group-hover:text-green-700 dark:group-hover:text-green-400">
                                    {{ __('Buy Now') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-gray-500 font-medium">{{ __('No extension packages yet') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SECTION 2: VIP PACKAGES (Gói VIP) -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <span class="p-2 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </span>
                {{ __('VIP Packages (Exclusive Offers)') }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($vipPackages as $item)
                    @php
                        $pkg = $item['product'];
                        $requiredVip = $item['required_vip'];
                        $discountPercent = $item['discount_percent'];
                        $finalPrice = $item['final_price'];
                        $maxBuy = $item['max_buy'];
                        $boughtCount = $item['bought_count'];
                        $canBuy = $item['can_buy'];
                        $isLocked = $item['is_locked'];
                    @endphp

                    <div
                        class="relative group bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 {{ $isLocked ? 'opacity-75' : 'transform hover:-translate-y-1 hover:shadow-xl border-indigo-100 dark:border-indigo-900' }}">

                        <!-- Locked Overlay -->
                        @if ($isLocked)
                            <div
                                class="absolute inset-0 bg-gray-900/60 z-20 flex flex-col items-center justify-center text-white backdrop-blur-[2px]">
                                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mb-4 border border-white/20 backdrop-blur-md">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <span class="font-black text-xl mb-1 tracking-tight">{{ __('Requires VIP') }} {{ $requiredVip }}</span>
                                <span class="text-sm font-medium text-white/80 bg-black/40 px-3 py-1 rounded-full">{{ __('Top up more to unlock') }}</span>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div
                            class="absolute top-0 left-0 bg-red-500 text-white text-[10px] font-bold px-3 py-1.5 rounded-br-2xl z-10 uppercase tracking-wider shadow-sm flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            {{ __('Discount') }} {{ $discountPercent }}%
                        </div>
                        <div
                            class="absolute top-0 right-0 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-bl-2xl z-10 uppercase tracking-widest shadow-sm">
                            VIP PACKAGE
                        </div>

                        <div class="p-6 pt-10">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 border border-indigo-100 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-5 text-3xl shadow-sm">
                                🎁
                            </div>

                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 leading-tight">{{ $pkg->name }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2 min-h-[2.5rem]">{{ $pkg->description }}</p>

                            <!-- Duration Info -->
                            @if ($pkg->duration_minutes)
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 text-xs font-semibold border border-indigo-100 dark:border-indigo-800">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ round($pkg->duration_minutes / 1440) }} {{ __('days') }}
                                    </span>
                                </div>
                            @endif


                            <!-- Pricing -->
                            <div class="flex flex-col mb-6">
                                <div class="flex items-end gap-2">
                                    <span class="text-3xl font-black text-gray-900 dark:text-white leading-none">{{ number_format($finalPrice) }}</span>
                                    <span class="text-base font-bold text-yellow-500 mb-0.5">Coin</span>
                                </div>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-400 line-through">{{ number_format($pkg->coinkey_amount) }} Coin</span>
                                </div>
                            </div>

                            <!-- Action -->
                            <form action="{{ route('order.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $pkg->id }}">
                                <input type="hidden" name="payment_method" value="wallet">
                                @if ($isLocked)
                                    <button type="button" disabled
                                        class="w-full py-3 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-400 rounded-xl font-bold cursor-not-allowed flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        {{ __('Locked') }}
                                    </button>
                                @elseif(!$canBuy)
                                    <button type="button" disabled
                                        class="w-full py-3 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-400 rounded-xl font-bold cursor-not-allowed">
                                        {{ __('Out of purchases') }}
                                    </button>
                                @else
                                    <button type="submit"
                                        class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold shadow-md hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        {{ __('Buy Now') }}
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-gray-500 font-medium">{{ __('No VIP packages yet') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>