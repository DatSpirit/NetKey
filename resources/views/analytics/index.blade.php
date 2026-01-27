<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    {{ __('My Activity') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ __('Track your personal spending and account usage') }}
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <select id="time-range" onchange="changeRange(this.value)"
                    class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                    <option value="7" {{ $days == 7 ? 'selected' : '' }}>{{ __('Last 7 days') }}</option>
                    <option value="30" {{ $days == 30 ? 'selected' : '' }}>{{ __('Last 30 days') }}</option>
                    <option value="90" {{ $days == 90 ? 'selected' : '' }}>{{ __('Last 3 months') }}</option>
                    <option value="365" {{ $days == 365 ? 'selected' : '' }}>{{ __('Last year') }}</option>
                </select>

                <a href="{{ route('analytics.export') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium shadow-md transition-all hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Export') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Total Spent (Split) --}}
            <div
                class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 transition-transform duration-300 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-indigo-100 text-sm font-medium mb-3">{{ __('Total Spending') }}</p>

                    <div class="flex items-baseline space-x-1 mb-1">
                        <span class="text-2xl font-bold">{{ number_format($analytics['totalRevenueVND']) }}</span>
                        <span class="text-xs font-normal opacity-80">VND</span>
                    </div>
                    <div class="flex items-baseline space-x-1">
                        <span
                            class="text-xl font-bold text-green-300">{{ number_format($analytics['totalRevenueCoin']) }}</span>
                        <span class="text-xs font-normal opacity-80">COIN</span>
                    </div>
                </div>
                {{-- Decorative Icon --}}
                <div class="absolute right-0 top-0 p-4 opacity-10">
                    <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Transactions --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ __('Transactions') }}</p>
                        <h3 class="text-2xl font-bold mt-1 dark:text-white">{{ $analytics['ordersTotal'] }}</h3>
                    </div>
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $analytics['successRate'] }}%">
                        </div>
                    </div>
                    <span
                        class="ml-2 text-xs font-medium text-blue-600 dark:text-blue-400">{{ $analytics['successRate'] }}%
                        {{ __('success') }}</span>
                </div>
            </div>

            {{-- Coin Activity (Deposit/Spend Ratio) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-5">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ __('Coin Activity') }}</p>
                    <div class="p-1.5 bg-green-50 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-3">
                    {{-- Deposited --}}
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500">{{ __('Deposited') }}</span>
                            <span
                                class="font-bold text-gray-900 dark:text-white">{{ number_format($analytics['walletDeposited']) }}</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                            <div class="bg-gray-400 h-1.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    {{-- Spent --}}
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-500">{{ __('Spent') }}</span>
                            <span class="font-bold text-green-600">{{ number_format($analytics['walletSpent']) }}</span>
                        </div>
                        {{-- Calculate percentage of Deposited roughly --}}
                        @php
                            $spendPercent = $analytics['walletDeposited'] > 0 ? ($analytics['walletSpent'] / $analytics['walletDeposited']) * 100 : 0;
                        @endphp
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ min($spendPercent, 100) }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Current Balance --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ __('Current Balance') }}</p>
                        <h3 class="text-2xl font-bold mt-1 text-indigo-600 dark:text-indigo-400">
                            {{ number_format($analytics['walletBalance']) }} <span
                                class="text-xs text-gray-400 font-normal">COIN</span>
                        </h3>
                    </div>
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-green-600 font-medium">{{ __('Available for use') }}</p>
            </div>
        </div>

        {{-- MAIN CHARTS ROW --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Spending Trend (Line) --}}
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Spending History') }}</h3>
                <div class="h-72 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Daily Habits (Bar) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Activity by Day') }}</h3>
                <div class="h-72 w-full">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- SECONDARY ACTIVITY ROW --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Currency Distribution --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Wallet Usage') }}</h3>
                    <span
                        class="text-xs font-semibold px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md text-gray-500">Volume</span>
                </div>
                <div class="h-64 flex justify-center relative">
                    <canvas id="currencyChart"></canvas>
                    {{-- Center Text Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="text-center">
                            <div class="text-xs text-gray-400">Total</div>
                            <div class="text-lg font-bold dark:text-white">{{ count($trend) }} <span
                                    class="text-xs font-normal">Trans</span></div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">COINKEY</p>
                        <p class="font-bold text-green-500">{{ $currencyStats['COINKEY']['count'] }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-500">VND</p>
                        <p class="font-bold text-blue-500">{{ $currencyStats['VND']['count'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Top Products --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Top Purchases') }}</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $index => $p)
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs font-bold mr-3">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $p->product_name }}
                                </p>
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 mt-1.5">
                                    <div class="bg-indigo-500 h-1.5 rounded-full"
                                        style="width: {{ min(($p->orders / ($analytics['ordersSuccess'] ?: 1)) * 100, 100) }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $p->orders }}</p>
                                <p class="text-xs text-gray-500">{{ __('times') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">No purchases yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Time Heatmap (Simple CSS Grid) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Peak Activity Hours') }}</h3>
                <div class="grid grid-cols-6 gap-2">
                    @foreach($hourly as $h => $count)
                        <div class="flex flex-col items-center">
                            <div
                                class="w-full pt-[100%] relative rounded-md {{ $count == 0 ? 'bg-gray-100 dark:bg-gray-700' : ($count < 3 ? 'bg-indigo-200 dark:bg-indigo-800' : ($count < 6 ? 'bg-indigo-400 dark:bg-indigo-600' : 'bg-indigo-600 dark:bg-indigo-500')) }}">
                                <span
                                    class="absolute inset-0 flex items-center justify-center text-[10px] {{ $count > 3 ? 'text-white' : 'text-gray-500 dark:text-gray-300' }}">
                                    {{ $h }}h
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-gray-100 dark:bg-gray-700 rounded mr-1"></div> None
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-indigo-200 dark:bg-indigo-800 rounded mr-1"></div> Low
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-indigo-400 dark:bg-indigo-600 rounded mr-1"></div> Med
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-indigo-600 dark:bg-indigo-500 rounded mr-1"></div> High
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Transactions Timeline --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Recent Activity Timeline') }}</h3>
            <div class="relative border-l-2 border-gray-200 dark:border-gray-700 ml-3 space-y-8">
                @forelse($transactions->take(10) as $t)
                    <div class="relative pl-8">
                        {{-- Timeline Dot --}}
                        <div
                            class="absolute -left-[9px] top-0 w-4 h-4 rounded-full {{ $t->status == 'success' ? 'bg-green-500 ring-4 ring-green-100 dark:ring-green-900/30' : 'bg-red-500 ring-4 ring-red-100 dark:ring-red-900/30' }}">
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $t->product->name ?? 'Wallet Topup' }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $t->created_at->format('M d, Y • h:i A') }} • Order #{{ substr($t->order_code, -8) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span
                                    class="block text-sm font-bold {{ $t->status == 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $t->status == 'success' ? '-' : '' }}{{ number_format($t->amount) }}
                                    {{ $t->currency }}
                                </span>
                                <span class="text-xs text-gray-400 capitalize">{{ $t->status }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="pl-8 text-gray-500 text-sm">No recent transactions.</div>
                @endforelse
            </div>
            <div class="mt-6 text-center">
                <button onclick="window.location.href='{{ route('analytics.export') }}'"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View detailed history in
                    Exports</button>
            </div>
        </div>

    </div>

    {{-- CHART.JS SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Common Options
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#9CA3AF';

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
                        gradient.addColorStop(0, "rgba(99, 102, 241, 0.2)"); // Indigo
                        gradient.addColorStop(1, "rgba(99, 102, 241, 0)");
                        return gradient;
                    },
                    borderColor: "#6366F1",
                    borderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#6366F1",
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        border: { dash: [4, 4] },
                        grid: { color: "rgba(156, 163, 175, 0.1)" }
                    }
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
                        "rgba(209, 213, 219, 0.5)", // Sun
                        "#6366F1", // Mon
                        "#6366F1", // Tue
                        "#6366F1", // Wed
                        "#6366F1", // Thu
                        "#6366F1", // Fri
                        "rgba(209, 213, 219, 0.5)", // Sat
                    ],
                    barThickness: 24
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
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
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                cutout: "75%",
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
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