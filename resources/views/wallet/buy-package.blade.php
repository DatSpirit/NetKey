<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white">{{ __('VIP Store') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Upgrade VIP to unlock exclusive offers') }}
                </p>
            </div>

            <!-- VIP Badge -->
            <div
                class="flex items-center gap-4 bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="text-right">
                    <p class="text-xs text-gray-500 font-bold uppercase">{{ __('Current Level') }}</p>
                    <p class="text-xl font-black text-yellow-500">VIP {{ $vipLevel }}</p>
                </div>
                <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
                <div>
                    <p class="text-xs text-gray-500">{{ __('Total deposited') }}: <span
                            class="font-bold text-green-600">{{ number_format($wallet->total_deposited) }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('wallet.index') }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-all duration-200">
                ← {{ __('Back') }}
            </a>

        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 min-h-screen">
        <!-- SECTION 1: EXTENSION PACKAGES (Gói Gia Hạn & Key) -->
        <div class="mb-12">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="p-2 bg-green-100 text-green-600 rounded-lg">⏳</span>
                {{ __('Extension & Key Packages') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                        class="relative group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div
                            class="absolute top-0 right-0 bg-green-600 text-white text-[10px] font-bold px-2 py-1 rounded-bl-xl z-10">
                            EXTENSION
                        </div>

                        <div class="p-6">
                            <div
                                class="w-14 h-14 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center mb-4 text-2xl shadow-inner">
                                🔑
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $pkg->name }}</h4>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $pkg->description }}</p>

                            <!-- Pricing -->
                            <div class="flex items-center gap-2 mb-6">
                                <span
                                    class="text-2xl font-black text-green-600 dark:text-green-400">{{ number_format($item['final_price']) }}
                                    Coin</span>
                            </div>

                            <!-- Action -->
                            <form action="{{ route('order.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $pkg->id }}">
                                <input type="hidden" name="payment_method" value="wallet">
                                <button type="submit"
                                    class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-xl font-bold transition-all">
                                    {{ __('Buy Now') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">{{ __('No extension packages yet') }}</div>
                @endforelse
            </div>
        </div>

        <!-- SECTION 2: VIP PACKAGES (Gói VIP) -->
        <div>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">👑</span>
                {{ __('VIP Packages (Exclusive Offers)') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                        class="relative group bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 {{ $isLocked ? 'opacity-70 grayscale' : 'hover:-translate-y-1 hover:shadow-2xl' }}">

                        <!-- Locked Overlay -->
                        @if ($isLocked)
                            <div
                                class="absolute inset-0 bg-black/50 z-20 flex flex-col items-center justify-center text-white backdrop-blur-[2px]">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="font-bold text-lg">{{ __('Requires VIP') }} {{ $requiredVip }}</span>
                                <span class="text-sm opacity-80">{{ __('Top up more to unlock') }}</span>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div
                            class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-br-xl z-10">
                            {{ __('Discount') }} {{ $discountPercent }}%
                        </div>
                        <div
                            class="absolute top-0 right-0 bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded-bl-xl z-10">
                            VIP PACKAGE
                        </div>

                        <div class="p-6">
                            <div
                                class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-4 text-2xl shadow-inner">
                                🎁
                            </div>

                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $pkg->name }}</h4>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $pkg->description }}</p>

                            <!-- Duration Info -->
                            @if ($pkg->duration_minutes)
                                <div class="flex items-center gap-2 mb-3 text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ round($pkg->duration_minutes / 1440) }} {{ __('days') }}</span>
                                </div>
                            @endif


                            <!-- Pricing -->
                            <div class="flex items-center gap-2 mb-6">
                                <span
                                    class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($finalPrice) }}
                                    <svg class="w-6 h-6 inline-block text-yellow-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg></span>
                                <span
                                    class="text-sm text-gray-400 line-through">{{ number_format($pkg->coinkey_amount) }}</span>
                            </div>

                            <!-- Action -->
                            <form action="{{ route('order.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $pkg->id }}">
                                <input type="hidden" name="payment_method" value="wallet">
                                @if ($isLocked)
                                    <button type="button" disabled
                                        class="w-full py-2.5 bg-gray-300 dark:bg-gray-700 text-gray-500 rounded-xl font-bold cursor-not-allowed">{{ __('Locked') }}</button>
                                @elseif(!$canBuy)
                                    <button type="button" disabled
                                        class="w-full py-2.5 bg-gray-300 dark:bg-gray-700 text-gray-500 rounded-xl font-bold cursor-not-allowed">{{ __('Out of purchases') }}</button>
                                @else
                                    <button type="submit"
                                        class="w-full py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:shadow-indigo-500/50 transition-all">{{ __('Buy Now') }}</button>
                                @endif
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">{{ __('No VIP packages yet') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>