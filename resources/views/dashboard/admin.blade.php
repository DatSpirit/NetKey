@push('styles')
<style>
/* ── ADMIN DASHBOARD — NETKEY DESIGN OVERRIDES ── */

/* Stat card gradient text → blue */
.bg-white.rounded-2xl p.text-2xl.font-bold {
    background: linear-gradient(90deg, #2563eb, #60a5fa) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    background-clip: text !important;
}

/* List headers (Top Buyers, Spenders etc.) — indigo→purple to navy+blue */
.bg-gradient-to-r.from-indigo-600.to-purple-600 {
    background: linear-gradient(135deg, #0a0f1e 0%, #2563eb 100%) !important;
}

/* Top buyer/spender/keyholder avatars */
.bg-gradient-to-br.from-indigo-500.to-purple-500 { background: #2563eb !important; }
.bg-gradient-to-br.from-green-500.to-emerald-500 { background: #22c55e !important; }
.bg-gradient-to-br.from-purple-500.to-pink-500  { background: #7c3aed !important; }

/* Main page background override */
.bg-gradient-to-br.from-gray-50.via-white.to-gray-50 {
    background: var(--bg) !important;
}
.dark .bg-gradient-to-br.from-gray-900 {
    background: var(--bg) !important;
}

/* Revenue chart icon box */
.w-10.h-10.rounded-xl.bg-gradient-to-br.from-green-500.to-emerald-500 {
    background: #2563eb !important;
}

/* Coin product items: yellow → blue */
.bg-yellow-50 { background: rgba(37,99,235,0.04) !important; }
.dark .bg-yellow-900\/20 { background: rgba(37,99,235,0.08) !important; }
.border-yellow-200 { border-color: rgba(37,99,235,0.15) !important; }
.text-yellow-600 { color: #2563eb !important; }

/* Key product items: purple → navy */
.bg-purple-50 { background: rgba(30,58,138,0.05) !important; }
.text-purple-600 { color: #2563eb !important; }

/* Period selector card */
.bg-white.dark\:bg-gray-800.border.border-gray-200 .font-medium.text-gray-700 {
    color: var(--fg) !important;
}

/* Cards base */
.bg-white.dark\:bg-gray-800.rounded-2xl {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Admin icon "A" badge */
.bg-gradient-to-br.from-indigo-600.to-purple-600.rounded-xl {
    background: linear-gradient(135deg, #0a0f1e, #2563eb) !important;
}

/* Tab buttons */
#coinTab.bg-white { color: #2563eb !important; }
</style>
@endpush

<x-app-layout>
    <style>
        /* Only essential custom styles */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>

    <!-- Header -->
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    A
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Admin Dashboard') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('System overview') }}</p>
                </div>
            </div>

            <div
                class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 shadow-sm">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <select onchange="location.href='?period='+this.value"
                    class="bg-transparent border-0 focus:outline-none focus:ring-0 font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                    <option value="1" {{ $period == 1 ? 'selected' : '' }}>24 giờ qua</option>
                    <option value="7" {{ $period == 7 ? 'selected' : '' }}>7 ngày qua</option>
                    <option value="30" {{ $period == 30 ? 'selected' : '' }}>30 ngày qua</option>
                    <option value="90" {{ $period == 90 ? 'selected' : '' }}>90 ngày qua</option>
                </select>
            </div>
        </div>
    </x-slot>

    <div
        class="py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 min-h-screen">
        <div class="w-full mx-auto space-y-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 animate-slide-in">
                <!-- Card 1: Tổng Người Dùng -->
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('Total Users') }}</p>
                    <p
                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mt-2">
                        {{ number_format($totalUsers) }}</p>
                    <div class="flex items-center gap-2 mt-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $isGrowth ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                            {{ $isGrowth ? '↑' : '↓' }} {{ abs($growthPercentage) }}%
                        </span>
                        <span class="text-xs text-gray-500">{{ __('vs last month') }}</span>
                    </div>
                </div>

                <!-- Card 2: Tổng Tiền Mặt -->
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-500"></div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('Total Cash') }}</p>
                    <p
                        class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mt-2">
                        {{ number_format($totalCash) }}</p>
                    <p class="text-xs text-gray-800 dark:text-white mt-3">Coin :
                        <span class="font-bold text-gray-900 dark:text-white">{{ number_format($spentOnCoins) }}đ</span>
                    </p>
                    <p class="text-xs text-gray-800 dark:text-white mt-3">Key :
                        <span class="font-bold text-gray-900 dark:text-white">{{ number_format($spentOnKeys) }}đ</span>
                    </p>
                </div>

                <!-- Card 3: Tổng Coin -->
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-amber-500"></div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('Total Coin') }}</p>
                    <p
                        class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent mt-2">
                        {{ number_format($totalCoins) }}</p>
                    <p class="text-xs text-gray-500 mt-3">{{ __('Used') }}: <span
                            class="font-semibold">{{ number_format($totalspenCoin) }}</span></p>
                    <p class="text-xs text-gray-500 mt-3">{{ __('Remaining') }}: <span
                            class="font-semibold">{{ number_format($remainingCoins) }}</span></p>
                </div>

                <!-- Card 4: Tổng Đơn Hàng -->
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-pink-500"></div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('Total Orders') }}</p>
                    <p
                        class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mt-2">
                        {{ number_format($transactionStats['total']) }}</p>
                    <p class="text-xs text-gray-500 mt-3">{{ __('Successful') }}: <span
                            class="font-semibold text-green-600">{{ number_format($transactionStats['success']) }}</span>
                    </p>
                </div>

                <!-- Card 5: Chờ Xử Lý -->
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-red-500"></div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('Pending Processing') }}</p>
                    <p
                        class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mt-2">
                        {{ number_format($transactionStats['pending']) }}</p>
                    <p class="text-xs text-gray-500 mt-3">{{ __('Failed') }}: <span
                            class="font-semibold text-red-600">{{ number_format($transactionStats['failed']) }}</span>
                    </p>
                </div>

                <!-- Card 6: Tổng Tiêu -->
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-cyan-500"></div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ __('Total Spending') }}</p>
                    <p
                        class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent mt-2">
                        {{ number_format($totalAll) }}</p>
                    <p class="text-xs text-gray-500 mt-3">Tiền Mặt: <span
                            class="font-semibold text-indigo-600">{{ number_format($totalCash) }}</span></p>

                    <p class="text-xs text-gray-500 mt-3">Coin: <span
                            class="font-semibold text-indigo-600">{{ number_format($totalspenCoin) }}</span></p>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Chart 1: User Distribution -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-md">
                    <h3 class="text-lg font-bold mb-6 text-gray-900 dark:text-white">{{ __('User Classification') }}</h3>
                    <div class="flex flex-col lg:flex-row items-center gap-6">
                        <div class="w-48 h-48 flex-shrink-0">
                            <canvas id="userChart"></canvas>
                        </div>
                        <div class="space-y-3 w-full">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('New') }}</span>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($userDistribution['new']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Old') }}</span>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($userDistribution['existing']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Expired') }}</span>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($userDistribution['expired']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-gray-500"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Deleted') }}</span>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($userDistribution['deleted']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Activity Status -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-md">
                    <h3 class="text-lg font-bold mb-6 text-gray-900 dark:text-white">{{ __('Activity (365 days)') }}</h3>
                    <div class="flex flex-col lg:flex-row items-center gap-6">
                        <div class="w-48 h-48 flex-shrink-0">
                            <canvas id="activityChart"></canvas>
                        </div>
                        <div class="space-y-3 w-full text-xs">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                    <div>
                                        <div class="text-gray-700 dark:text-gray-300">Rất hoạt động</div>
                                        <div class="text-gray-500">> 20 giao dịch</div>
                                    </div>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($activityStatus['very_active']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-teal-500"></span>
                                    <div>
                                        <div class="text-gray-700 dark:text-gray-300">Hoạt động</div>
                                        <div class="text-gray-500">5-20 giao dịch</div>
                                    </div>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($activityStatus['active']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                    <div>
                                        <div class="text-gray-700 dark:text-gray-300">Ít hoạt động</div>
                                        <div class="text-gray-500">1-4 giao dịch</div>
                                    </div>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($activityStatus['inactive']) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                                    <span class="text-gray-700 dark:text-gray-300">Không hoạt động</span>
                                </div>
                                <span
                                    class="font-bold text-gray-900 dark:text-white">{{ number_format($activityStatus['dormant']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 3: Spend Distribution -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-md">
                    <h3 class="text-lg font-bold mb-6 text-gray-900 dark:text-white">{{ __('Expenditure Distribution') }}</h3>
                    <div class="flex flex-col lg:flex-row items-center gap-6">
                        <div class="w-48 h-48 flex-shrink-0">
                            <canvas id="spendChart"></canvas>
                        </div>
                        <div class="space-y-4 w-full">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                    <span class=" text-gray-700 dark:text-gray-300">{{ __('Buy Coin') }}</span>
                                </div>

                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Buy Key/Package') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combined Chart -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-md">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Revenue & New Users') }}
                        ({{ now()->year }})</h3>
                    <div class="flex gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-indigo-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Revenue') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('New users') }}</span>
                        </div>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>

            <!-- Top Lists -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- Top Buyers -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-md overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 font-semibold text-lg flex items-center justify-between">
                        <span>🛒 {{ __('Top Buyers') }}</span>
                        <span class="text-xs opacity-90">{{ __('10 users') }}</span>
                    </div>
                    <div class="max-h-96 overflow-y-auto custom-scrollbar">
                        @forelse($topBuyers as $item)
                            <div
                                class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md bg-gradient-to-br from-indigo-500 to-purple-500">
                                        {{ $item['user'] ? strtoupper(substr($item['user']->name, 0, 1)) : '?' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $item['user']->name ?? __('Deleted User') }}
                                            @if($item['user']?->trashed())
                                                <span class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded ml-1">{{ __('Deleted') }}</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ $item['user']->email ?? '#' }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="font-bold text-indigo-600">{{ number_format($item['purchase_count']) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ number_format($item['total_spent']) }}đ</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-12">{{ __('No data available') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top Spenders -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-md overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 font-semibold text-lg flex items-center justify-between">
                        <span>💰 {{ __('Top Spenders') }}</span>
                        <span class="text-xs opacity-90">{{ __('10 users') }}</span>
                    </div>
                    <div class="max-h-96 overflow-y-auto custom-scrollbar">
                        @forelse($topSpenders as $item)
                            <div
                                class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md bg-gradient-to-br from-green-500 to-emerald-500">
                                        {{ $item['user'] ? strtoupper(substr($item['user']->name, 0, 1)) : '?' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $item['user']->name ?? __('Deleted User') }}
                                            @if($item['user']?->trashed())
                                                <span class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded ml-1">{{ __('Deleted') }}</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ $item['user']->email ?? '#' }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="font-bold text-green-600">{{ number_format($item['total_spent']) }}đ</p>
                                    <p class="text-xs text-gray-500">{{ number_format($item['purchase_count']) }} {{ __('orders') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-12">{{ __('No data available') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top Key Holders -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-md overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 font-semibold text-lg flex items-center justify-between">
                        <span>🔑 {{ __('Top Key Holders') }}</span>
                        <span class="text-xs opacity-90">{{ __('10 users') }}</span>
                    </div>
                    <div class="max-h-96 overflow-y-auto custom-scrollbar">
                        @forelse($topKeyHolders as $item)
                            <div
                                class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div
                                        class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md bg-gradient-to-br from-purple-500 to-pink-500">
                                        {{ $item['user'] ? strtoupper(substr($item['user']->name, 0, 1)) : '?' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $item['user']->name ?? __('Deleted User') }}
                                            @if($item['user']?->trashed())
                                                <span class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded ml-1">{{ __('Deleted') }}</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ $item['user']->email ?? '#' }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="font-bold text-purple-600">{{ number_format($item['key_count']) }}</p>
                                    <p class="text-xs text-gray-500">keys</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-12">{{ __('No data available') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top Products -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-md overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 font-semibold text-lg flex items-center justify-between">
                        <span>📦 {{ __('Top Products') }}</span>
                        <span class="text-xs opacity-90">{{ __('10 products') }}</span>
                    </div>
                    <div class="max-h-96 overflow-y-auto custom-scrollbar">
                        @forelse($topProducts as $item)
                            <div
                                class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">
                                        {{ $item['product']->name ?? __('Unknown') }}</p>
                                    <p class="text-xs text-gray-500">{{ $item['product']->category ?? '' }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="font-bold text-teal-600">{{ number_format($item['sales_count']) }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($item['revenue']) }}đ</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-12">{{ __('No data available') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>



        // Chart.js Configurations
        const chartColors = {
            blue: '#3b82f6',
            green: '#10b981',
            red: '#ef4444',
            gray: '#6b7280',
            emerald: '#10b981',
            teal: '#14b8a6',
            amber: '#f59e0b',
            yellow: '#eab308',
            purple: '#a855f7',
            indigo: '#6366f1'
        };

        // User Distribution Chart
        new Chart(document.getElementById('userChart'), {
            type: 'doughnut',
            data: {
                labels: ['Mới', 'Cũ', 'Hết hạn', 'Đã xóa'],
                datasets: [{
                    data: [
                        {{ $userDistribution['new'] }},
                        {{ $userDistribution['existing'] }},
                        {{ $userDistribution['expired'] }},
                        {{ $userDistribution['deleted'] }}
                    ],
                    backgroundColor: [chartColors.blue, chartColors.green, chartColors.red, chartColors
                        .gray
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Activity Status Chart
        new Chart(document.getElementById('activityChart'), {
            type: 'doughnut',
            data: {
                labels: ['Rất hoạt động', 'Hoạt động', 'Ít hoạt động', 'Không hoạt động'],
                datasets: [{
                    data: [
                        {{ $activityStatus['very_active'] }},
                        {{ $activityStatus['active'] }},
                        {{ $activityStatus['inactive'] }},
                        {{ $activityStatus['dormant'] }}
                    ],
                    backgroundColor: [chartColors.emerald, chartColors.teal, chartColors.amber, chartColors
                        .gray
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Spend Distribution Chart
        new Chart(document.getElementById('spendChart'), {
            type: 'doughnut',
            data: {
                labels: ['Mua Coin', 'Mua Key/Package'],
                datasets: [{
                    data: [{{ $spentOnCoins }}, {{ $spentOnKeys }}],
                    backgroundColor: [chartColors.yellow, chartColors.purple],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Combined Chart
        new Chart(document.getElementById('combinedChart'), {
            data: {
                labels: @json(array_column($combinedChartData, 'month')),
                datasets: [{
                        type: 'bar',
                        label: 'Doanh thu',
                        data: @json(array_column($combinedChartData, 'revenue')),
                        backgroundColor: chartColors.indigo,
                        yAxisID: 'y',
                        borderRadius: 8
                    },
                    {
                        type: 'line',
                        label: 'Người dùng mới',
                        data: @json(array_column($combinedChartData, 'new_users')),
                        borderColor: chartColors.green,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        yAxisID: 'y1',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Doanh thu (đ)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Người dùng mới',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });



    </script>
</x-app-layout>
