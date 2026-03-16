@push('styles')
<style>
/* ── ANALYTICS DASHBOARD — NETKEY DESIGN OVERRIDES ── */

/* Cards & Containers */
.bg-white.dark\:bg-gray-800 {
    background: var(--bg-card) !important;
    border-color: var(--border) !important;
}

/* Interior elements */
.bg-gray-50.dark\:bg-gray-700,
.bg-gray-100.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border-color: var(--border) !important;
}

/* Inputs / Selects */
select.bg-white.dark\:bg-gray-700 {
    background: var(--bg-layer) !important;
    border: 1px solid var(--border) !important;
    color: var(--text-color) !important;
}

select:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 1px #2563eb !important;
}

/* Actions */
.bg-indigo-600 { background-color: #2563eb !important; }
.hover\:bg-indigo-700:hover { background-color: #1d4ed8 !important; }

/* Status Accents */
.text-indigo-600.dark\:text-indigo-400,
.text-indigo-600 { color: #2563eb !important; }
.bg-indigo-50.dark\:bg-indigo-900\/30 { background: rgba(37, 99, 235, 0.1) !important; color: #2563eb !important; }

.text-blue-600.dark\:text-blue-400 { color: #3b82f6 !important; }
.bg-blue-50.dark\:bg-blue-900\/30 { background: rgba(59, 130, 246, 0.1) !important; color: #3b82f6 !important; }
.bg-blue-600 { background-color: #3b82f6 !important; }

.text-green-600, .text-green-500 { color: #10b981 !important; }
.bg-green-50.dark\:bg-green-900\/30 { background: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; }
.bg-green-500 { background-color: #10b981 !important; }

</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    {{ __('My Activity') }}
                </h2>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2 tracking-wide uppercase">
                    {{ __('Track your personal spending and account usage') }}
                </p>
            </div>

            <div class="flex items-center space-x-4">
                <select id="time-range" onchange="changeRange(this.value)"
                    class="pl-4 pr-10 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-semibold shadow-sm focus:ring-4 focus:ring-indigo-500/20 transition-all cursor-pointer">
                    <option value="7" {{ $days == 7 ? 'selected' : '' }}>{{ __('Last 7 days') }}</option>
                    <option value="30" {{ $days == 30 ? 'selected' : '' }}>{{ __('Last 30 days') }}</option>
                    <option value="90" {{ $days == 90 ? 'selected' : '' }}>{{ __('Last 3 months') }}</option>
                    <option value="365" {{ $days == 365 ? 'selected' : '' }}>{{ __('Last year') }}</option>
                </select>

                <a href="{{ route('analytics.export') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-500/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Export') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 py-8">

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Total Spent (Split) --}}
            <div
                class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl shadow-lg p-6 text-white transform hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider mb-4">{{ __('Total Spending') }}</p>

                    <div class="flex items-baseline space-x-1.5 mb-2">
                        <span class="text-3xl font-black tracking-tight">{{ number_format($analytics['totalRevenueVND']) }}</span>
                        <span class="text-sm font-bold opacity-80">VND</span>
                    </div>
                    <div class="flex items-baseline space-x-1.5">
                        <span
                            class="text-2xl font-black text-green-300 tracking-tight">{{ number_format($analytics['totalRevenueCoin']) }}</span>
                        <span class="text-sm font-bold opacity-80">COIN</span>
                    </div>
                </div>
                {{-- Decorative Icon --}}
                <div class="absolute -right-4 -top-4 p-8 bg-white/10 rounded-full opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:scale-110 duration-500">
                    <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Transactions --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">{{ __('Transactions') }}</p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ $analytics['ordersTotal'] }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6 flex items-center">
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $analytics['successRate'] }}%">
                        </div>
                    </div>
                    <span
                        class="ml-3 text-sm font-bold text-blue-600 dark:text-blue-400">{{ $analytics['successRate'] }}%</span>
                </div>
            </div>

            {{-- Coin Activity (Deposit/Spend Ratio) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">{{ __('Coin Activity') }}</p>
                    <div class="p-2.5 bg-green-50 dark:bg-green-900/30 rounded-xl">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Deposited --}}
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-400 font-medium">{{ __('Deposited') }}</span>
                            <span
                                class="font-bold text-gray-900 dark:text-white">{{ number_format($analytics['walletDeposited']) }}</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gray-400 dark:bg-gray-500 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    {{-- Spent --}}
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-400 font-medium">{{ __('Spent') }}</span>
                            <span class="font-bold text-green-600">{{ number_format($analytics['walletSpent']) }}</span>
                        </div>
                        {{-- Calculate percentage of Deposited roughly --}}
                        @php
                            $spendPercent = $analytics['walletDeposited'] > 0 ? ($analytics['walletSpent'] / $analytics['walletDeposited']) * 100 : 0;
                        @endphp
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ min($spendPercent, 100) }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Current Balance --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">{{ __('Current Balance') }}</p>
                        <h3 class="text-3xl font-black text-indigo-600 dark:text-indigo-400 mt-2">
                            {{ number_format($analytics['walletBalance']) }} <span
                                class="text-sm font-bold text-gray-400 ml-1">COIN</span>
                        </h3>
                    </div>
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl">
                        <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6 flex items-center space-x-2 bg-green-50 dark:bg-green-900/20 px-3 py-2 rounded-lg w-max">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <p class="text-xs text-green-700 dark:text-green-400 font-bold uppercase tracking-wider">{{ __('Available for use') }}</p>
                </div>
            </div>
        </div>

        {{-- MAIN CHARTS ROW --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Spending Trend (Line) --}}
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 relative overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 dark:bg-indigo-900/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none z-0"></div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 relative z-10 flex items-center">
                    <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                    {{ __('Spending History') }}
                </h3>
                <div class="h-[300px] w-full relative z-10">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Daily Habits (Bar) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                    {{ __('Activity by Day') }}
                </h3>
                <div class="h-[300px] w-full">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- SECONDARY ACTIVITY ROW --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Currency Distribution --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                        {{ __('Wallet Usage') }}
                    </h3>
                    <span
                        class="text-xs font-bold px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-500 uppercase tracking-widest">Volume</span>
                </div>
                <div class="h-[200px] flex justify-center relative">
                    <canvas id="currencyChart"></canvas>
                    {{-- Center Text Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="text-center">
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total</div>
                            <div class="text-3xl font-black text-gray-900 dark:text-white">{{ count($trend) }}</div>
                            <div class="text-xs font-medium text-gray-500">Trans</div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-2xl">
                        <p class="text-xs font-bold text-gray-400 mb-1">COINKEY</p>
                        <p class="text-xl font-black text-green-500">{{ $currencyStats['COINKEY']['count'] }}</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-2xl">
                        <p class="text-xs font-bold text-gray-400 mb-1">VND</p>
                        <p class="text-xl font-black text-blue-500">{{ $currencyStats['VND']['count'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Top Products --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 overflow-hidden">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                    {{ __('Top Purchases') }}
                </h3>
                <div class="space-y-5">
                    @forelse($topProducts as $index => $p)
                        <div class="flex items-center group">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm font-black mr-4 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate mb-1.5">
                                    {{ $p->product_name }}
                                </p>
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full"
                                        style="width: {{ min(($p->orders / ($analytics['ordersSuccess'] ?: 1)) * 100, 100) }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <p class="text-base font-black text-gray-900 dark:text-white">{{ $p->orders }}</p>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('qty') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center space-y-3 opacity-70">
                            <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">No purchases yet in this period.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Time Heatmap (Simple CSS Grid) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                    {{ __('Peak Activity Hours') }}
                </h3>
                <div class="grid grid-cols-6 gap-2">
                    @foreach($hourly as $h => $count)
                        <div class="flex flex-col items-center group relative cursor-pointer">
                            <div
                                class="w-full pt-[100%] relative rounded-xl transition-all duration-300 transform group-hover:scale-110 {{ $count == 0 ? 'bg-gray-100 dark:bg-gray-700' : ($count < 3 ? 'bg-indigo-200 dark:bg-indigo-800' : ($count < 6 ? 'bg-indigo-400 dark:bg-indigo-500' : 'bg-indigo-600 shadow-lg shadow-indigo-500/50')) }}">
                                <span
                                    class="absolute inset-0 flex items-center justify-center text-[11px] font-bold {{ $count > 3 ? 'text-white' : 'text-gray-400 dark:text-gray-300' }}">
                                    {{ $h }}h
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 flex items-center justify-between px-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-gray-100 dark:bg-gray-700 rounded shadow-sm"></div> <span>None</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-indigo-200 dark:bg-indigo-800 rounded shadow-sm"></div> <span>Low</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-indigo-400 dark:bg-indigo-500 rounded shadow-sm"></div> <span>Med</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 bg-indigo-600 rounded shadow-sm"></div> <span>High</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Transactions Timeline --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center border-b border-gray-100 dark:border-gray-700 pb-4">
                <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                {{ __('Recent Activity Timeline') }}
            </h3>
            <div class="relative border-l-4 border-gray-100 dark:border-gray-700 ml-4 space-y-10 py-2">
                @forelse($transactions->take(10) as $t)
                    <div class="relative pl-8 sm:pl-10">
                        {{-- Timeline Dot --}}
                        <div
                            class="absolute -left-[10px] top-1 w-4 h-4 rounded-full shadow-sm {{ $t->status == 'success' ? 'bg-green-500 ring-[6px] ring-green-50 dark:ring-green-900/40' : 'bg-red-500 ring-[6px] ring-red-50 dark:ring-red-900/40' }}">
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors border border-gray-100/50 dark:border-gray-600/30">
                            <div>
                                <h4 class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ $t->product->name ?? 'Wallet Topup' }}
                                </h4>
                                <div class="flex items-center space-x-2 mt-1.5 text-sm font-medium text-gray-500">
                                    <span class="bg-white dark:bg-gray-800 px-2 py-0.5 rounded shadow-sm text-xs border border-gray-200 dark:border-gray-600">
                                        {{ $t->created_at->format('h:i A') }} • {{ $t->created_at->format('M d') }}
                                    </span>
                                    <span>#{{ substr($t->order_code, -8) }}</span>
                                </div>
                            </div>
                            <div class="sm:text-right flex flex-row sm:flex-col items-center justify-between sm:items-end">
                                <span
                                    class="block text-lg font-black tracking-tight {{ $t->status == 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $t->status == 'success' ? '-' : '' }}{{ number_format($t->amount) }}
                                    <span class="text-xs ml-0.5">{{ $t->currency }}</span>
                                </span>
                                <span class="text-xs font-bold uppercase tracking-wider {{ $t->status == 'success' ? 'text-green-500' : 'text-red-500' }} mt-1 bg-white dark:bg-gray-800 px-2 py-0.5 rounded shadow-sm border border-gray-200 dark:border-gray-600">{{ $t->status }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="pl-8 text-gray-500 text-sm font-medium italic">No recent transactions in this period.</div>
                @endforelse
            </div>
            <div class="mt-8 text-center bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-4">
                <button onclick="window.location.href='{{ route('analytics.export') }}'"
                    class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold uppercase tracking-wider inline-flex items-center transition-colors">
                    View detailed history in Exports
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>

    </div>

    {{-- CHART.JS SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Common Options
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.weight = '600';
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.scale.grid.color = 'rgba(156, 163, 175, 0.1)';

        // ================================
        // SPENDING TREND (Line)
        // ================================
        const trendLabels = @json($trend->pluck('date'));
        const trendData = @json($trend->pluck('total'));

        new Chart(document.getElementById("revenueChart"), {
            type: "line",
            data: {
                labels: trendLabels,
                datasets: [{
                    label: "Spending",
                    data: trendData,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: (ctx) => {
                        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, "rgba(99, 102, 241, 0.3)"); // Indigo
                        gradient.addColorStop(1, "rgba(99, 102, 241, 0.0)");
                        return gradient;
                    },
                    borderColor: "#6366F1",
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#6366F1",
                    pointBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false }, 
                    tooltip: { 
                        mode: 'index', 
                        intersect: false,
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    } 
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        border: { dash: [4, 4], display: false }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // ================================
        // DAILY HABITS (Bar)
        // ================================
        const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const dailyData = @json($spendingByDay);

        new Chart(document.getElementById("dailyChart"), {
            type: "bar",
            data: {
                labels: days,
                datasets: [{
                    label: "Spending",
                    data: dailyData,
                    borderRadius: 6,
                    backgroundColor: [
                        "rgba(209, 213, 219, 0.3)", // Sun
                        "#6366F1", // Mon
                        "#6366F1", // Tue
                        "#6366F1", // Wed
                        "#6366F1", // Thu
                        "#6366F1", // Fri
                        "rgba(209, 213, 219, 0.3)", // Sat
                    ],
                    hoverBackgroundColor: "#4F46E5",
                    borderSkipped: false,
                    barThickness: 'flex',
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: { display: false }
                }
            }
        });

        // ================================
        // WALLET CURRENCY (Doughnut)
        // ================================
        new Chart(document.getElementById("currencyChart"), {
            type: "doughnut",
            data: {
                labels: ["COINKEY", "VND"],
                datasets: [{
                    data: [{{ $currencyStats['COINKEY']['volume'] }}, {{ $currencyStats['VND']['volume'] }}],
                    backgroundColor: ["#10B981", "#3B82F6"], // Emerald, Blue
                    borderWidth: 4,
                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--bg-card') || '#fff',
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: "80%",
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return label + ': ' + new Intl.NumberFormat().format(value);
                            }
                        }
                    }
                }
            }
        });

        function changeRange(days) {
            window.location.href = "?days=" + days;
        }
    </script>
</x-app-layout>