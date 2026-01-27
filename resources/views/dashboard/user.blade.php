<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('Welcome Back!') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ __("Here's what's happening with your account today") }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Welcome Banner --}}
        <div
            class="relative overflow-hidden bg-gradient-to-r from-indigo-700 to-blue-600 rounded-3xl shadow-2xl p-6 sm:p-10 text-white">
            {{-- Decorative Background Circles --}}
            <div
                class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-blue-400 opacity-10 blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                {{-- Profile Info --}}
                <div class="text-center lg:text-left space-y-3">
                    <h3 class="text-3xl md:text-5xl font-extrabold tracking-tight">
                        {{ __('Welcome') }}, <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">{{ $user->name }}</span>

                    </h3>
                    <p class="text-blue-100 text-lg flex items-center justify-center lg:justify-start gap-3">
                        <span
                            class="flex items-center gap-1 bg-white/10 px-3 py-1 rounded-full text-sm backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ __('Join') }}: {{ $user->created_at->format('d/m/Y') }}
                        </span>
                        <span
                            class="flex items-center gap-1 bg-white/10 px-3 py-1 rounded-full text-sm backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            {{ __('Login') }}: {{ number_format($user->login_count ?? 0) }} {{ __('times') }}
                        </span>
                    </p>
                </div>

                {{-- Action & Timer --}}
                <div class="flex flex-col sm:flex-row items-center gap-2 w-full lg:w-auto">
                    @if ($user->expires_at)
                        <div
                            class="flex-1 w-full sm:w-auto bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-center min-w-[220px] shadow-lg">
                            <p
                                class="text-xs font-bold text-blue-200 uppercase tracking-wider mb-1 flex items-center justify-center gap-1">
                                <svg class="w-3 h-3 animate-pulse text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                {{ __('Expiry Date') }}
                            </p>
                            <p id="countdown" class="text-2xl font-mono font-bold text-white drop-shadow-md"
                                data-expires-at="{{ $user->expires_at->timestamp * 1000 }}">
                                Loading...
                            </p>
                        </div>
                    @endif

                    <a href="{{ route('profile.edit') }}"
                        class="group flex items-center gap-2 px-6 py-4 bg-white text-indigo-600 rounded-2xl font-bold shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all transform hover:-translate-y-1">
                        <span>{{ __('Settings') }}</span>
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Overview Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Total Spend Card --}}
            <div
                class="bg-gradient-to-br from-blue-600 to-blue-200 dark:from-blue-200 dark:to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 dark:bg-blue-200 backdrop-blur-sm rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-900 dark:text-white opacity-90 mb-2 uppercase tracking-wider">
                    {{ __('Total Spending') }}
                </p>
                <p class="text-3xl text-gray-900 dark:text-white font-bold">{{ number_format($stats['total_spend']) }}
                </p>
                <p class="text-xs text-gray-900 dark:text-white opacity-75 mt-2">VND ({{ __('Success') }})</p>
            </div>

            {{-- Success Transactions --}}
            <div
                class="bg-gradient-to-br from-green-200 to-green-600 dark:from-green-200 dark:to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-semibold text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-3 py-1.5 rounded-full">
                        {{ $stats['total_transactions'] > 0 ? round(($stats['success'] / $stats['total_transactions']) * 100, 1) : 0 }}%
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 font-medium">{{ __('Successful') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['success']) }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('Transaction') }}</p>
            </div>

            {{-- Pending Transactions --}}
            <div
                class="bg-gradient-to-br from-yellow-600 to-yellow-200 dark:from-yellow-200 dark:to-yellow-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900/30 px-3 py-1.5 rounded-full">
                        {{ $stats['total_transactions'] > 0 ? round(($stats['pending'] / $stats['total_transactions']) * 100, 1) : 0 }}%
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 font-medium">{{ __('Awaiting Payment') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['pending']) }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('Transaction') }}</p>
            </div>

            {{-- Failed/Cancelled --}}
            <div
                class="bg-gradient-to-br from-red-200 to-red-600 dark:from-red-200 dark:to-red-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30 px-3 py-1.5 rounded-full">
                        {{ $stats['total_transactions'] > 0 ? round(($stats['failed'] / $stats['total_transactions']) * 100, 1) : 0 }}%
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 font-medium">{{ __('Failed/Cancelled') }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['failed']) }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('Transaction') }}</p>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Pie Chart --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    {{ __('Order Statistics') }}
                </h3>
                <div class="relative h-64">
                    <canvas id="transactionPieChart"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    <div
                        class="flex items-center justify-between p-2 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Successful') }}</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $stats['success'] }}</span>
                    </div>
                    <div
                        class="flex items-center justify-between p-2 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Pending') }}</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $stats['pending'] }}</span>
                    </div>
                    <div
                        class="flex items-center justify-between p-2 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Failed') }}</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $stats['failed'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Bar Chart --}}
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">

                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        {{ __('Expenditure Trend') }}
                    </h3>

                    <!-- Controls -->
                    <div class="flex items-center gap-2">
                        <button id="toggleChartType"
                            class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm transition">
                            {{ __('Change chart') }}
                        </button>
                        <select id="chart-range-select"
                            class="px-3 py-1.5 border rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 text-sm">
                            <option value="7days" {{ $currentRange === '7days' ? 'selected' : '' }}>{{ __('Last 7 days') }}</option>
                            <option value="month" {{ $currentRange === 'month' ? 'selected' : '' }}>{{ __('Last 30 days') }}</option>
                            <option value="year" {{ $currentRange === 'year' ? 'selected' : '' }}>{{ __('Last year') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Chart Area -->
                <div class="h-80">
                    <canvas id="expenseBarChart"></canvas>
                </div>

                <!-- Footer -->
                <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-4">
                    {{ __('Statistics based on successful transactions') }}
                </p>
            </div>
        </div>

        {{-- Recent Activities & Products --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Recent Products --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                        🛒 {{ __('Products Purchased') }}
                    </h3>
                    <a href="{{ route('transactions.index') }}"
                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('View All') }} →
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($productsBought as $transaction)
                        <div
                            class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 border border-gray-100 dark:border-gray-700 group">
                            <div class="flex items-center space-x-4 flex-1 min-w-0">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $transaction->product->name ?? 'Unknown Product' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        #{{ $transaction->order_code }} •
                                        {{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-2">
                                <p class="text-sm font-bold text-green-600 dark:text-green-400">
                                    {{ number_format($transaction->amount) }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">VND</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div
                                class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium mb-3">{{ __('You have not purchased any products yet') }}
                            </p>
                            <a href="{{ route('products') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-all">
                                {{ __('Explore now') }} →
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Activity Timeline --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                            📋 {{ __('Activity History') }}
                    </h3>
                    <button class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('Refresh') }}
                    </button>
                </div>
                <div class="space-y-3">
                    @foreach ($activities as $activity)
                        <div
                            class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 border border-gray-100 dark:border-gray-700">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 bg-{{ $activity['color'] }}-100 dark:bg-{{ $activity['color'] }}-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-lg">{{ $activity['icon'] }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $activity['desc'] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                                    title="{{ $activity['real_time']->format('H:i:s d/m/Y') }}">
                                    {{ $activity['time'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Actions Banner --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h3 class="text-3xl font-bold mb-2">{{ __('Ready to explore?') }} 🚀</h3>
                    <p class="text-indigo-100 text-lg">{{ __('Discover amazing products and deals') }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('products') }}"
                        class="px-6 py-3 bg-white text-indigo-600 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-200 shadow-lg transform hover:scale-105 text-center">
                        🛍️ {{ __('View Products') }}
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-xl font-semibold hover:bg-white/30 transition-all duration-200 text-center">
                        ⚙️ {{ __('Settings') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @if ($user->expires_at)
            <script>
                // Lấy timestamp từ thuộc tính data-expires-at
                const countdownEl = document.getElementById('countdown');
                const expiresAt = parseInt(countdownEl.dataset.expiresAt); // Changed key update here

                // Cập nhật đồng hồ đếm ngược mỗi giây
                const countdownInterval = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = expiresAt - now;

                    // Tính toán thời gian
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Hiển thị kết quả
                    if (distance > 0) {
                        countdownEl.innerHTML = days + " ngày " + hours + " giờ " + minutes + " phút " + seconds + " giây";
                    } else {
                        clearInterval(countdownInterval);
                        countdownEl.innerHTML = "ĐÃ HẾT HẠN";

                    }
                }, 1000);
            </script>
        @endif


        {{-- Script cho biểu đồ --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // Gradient TAILWIND (Auto Dark)
                function createGradient(ctx, colorFrom, colorTo) {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                    gradient.addColorStop(0, colorFrom);
                    gradient.addColorStop(1, colorTo);
                    return gradient;
                }

                // Pie Chart
                const successCount = {{ $stats['success'] }};
                const pendingCount = {{ $stats['pending'] }};
                const failedCount = {{ $stats['failed'] }};
                // Tính tổng số giao dịch để phục vụ tính toán phần trăm
                const totalTransactions = successCount + pendingCount + failedCount;

                const pieCtx = document.getElementById('transactionPieChart')?.getContext('2d');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Thành công', 'Chờ xử lý', 'Thất bại'],
                            datasets: [{
                                data: [successCount, pendingCount, failedCount],
                                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                                borderWidth: 2,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    padding: 12,
                                    cornerRadius: 8,
                                    titleFont: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    bodyFont: {
                                        size: 13
                                    },
                                    callbacks: {
                                        label: function (context) {
                                            const count = context.parsed; // Số lượng giao dịch
                                            let percentage = 0;

                                            if (totalTransactions > 0) {
                                                // Tính tỉ lệ phần trăm và làm tròn 1 chữ số thập phân
                                                percentage = ((count / totalTransactions) * 100).toFixed(1);
                                            }
                                            return context.label + ': ' + count + ' GD (' + percentage +
                                                '%)';
                                        }
                                    }
                                }
                            },
                            cutout: '70%'
                        }
                    });
                }

                // Gradient TAILWIND 
                function createGradient(ctx, colorFrom, colorTo) {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                    gradient.addColorStop(0, colorFrom);
                    gradient.addColorStop(1, colorTo);
                    return gradient;
                }

                // ============================
                // Crosshair X + Y


                { { --Script cho biểu đồ-- } }
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
                        document.addEventListener('DOMContentLoaded', function () {

                            // Gradient TAILWIND (Auto Dark)
                            function createGradient(ctx, colorFrom, colorTo) {
                                const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                                gradient.addColorStop(0, colorFrom);
                                gradient.addColorStop(1, colorTo);
                                return gradient;
                            }

                                // Pie Chart
                                const successCount = {{ $stats['success'] }};
                        const pendingCount = {{ $stats['pending'] }};
                        const failedCount = {{ $stats['failed'] }};
                        // Tính tổng số giao dịch để phục vụ tính toán phần trăm
                        const totalTransactions = successCount + pendingCount + failedCount;

                        const pieCtx = document.getElementById('transactionPieChart')?.getContext('2d');
                        if (pieCtx) {
                            new Chart(pieCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['Thành công', 'Chờ xử lý', 'Thất bại'],
                                    datasets: [{
                                        data: [successCount, pendingCount, failedCount],
                                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                                        borderWidth: 2,
                                        hoverOffset: 8
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            padding: 12,
                                            cornerRadius: 8,
                                            titleFont: {
                                                size: 14,
                                                weight: 'bold'
                                            },
                                            bodyFont: {
                                                size: 13
                                            },
                                            callbacks: {
                                                label: function (context) {
                                                    const count = context.parsed; // Số lượng giao dịch
                                                    let percentage = 0;

                                                    if (totalTransactions > 0) {
                                                        // Tính tỉ lệ phần trăm và làm tròn 1 chữ số thập phân
                                                        percentage = ((count / totalTransactions) * 100).toFixed(1);
                                                    }
                                                    return context.label + ': ' + count + ' GD (' + percentage +
                                                        '%)';
                                                }
                                            }
                                        }
                                    },
                                    cutout: '70%'
                                }
                            });
                                }

                        // Gradient TAILWIND 
                        function createGradient(ctx, colorFrom, colorTo) {
                                    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                        gradient.addColorStop(0, colorFrom);
                        gradient.addColorStop(1, colorTo);
                        return gradient;
                                }

                        // ============================
                        // Crosshair X + Y
                        // ============================
                        const crosshairPlugin = {
                            id: 'crosshairPlugin',
                        afterDraw(chart) {
                                        if (!chart.tooltip?._active?.length) return;

                        const ctx = chart.ctx;
                        const point = chart.tooltip._active[0].element;
                        const {
                            top,
                            bottom,
                            left,
                            right
                        } = chart.chartArea;

                        ctx.save();
                        ctx.setLineDash([4, 4]);
                        ctx.lineWidth = 1;
                        ctx.strokeStyle = '#9ca3af';

                        // Vertical
                        ctx.beginPath();
                        ctx.moveTo(point.x, top);
                        ctx.lineTo(point.x, bottom);
                        ctx.stroke();

                        // Horizontal
                        ctx.beginPath();
                        ctx.moveTo(left, point.y);
                        ctx.lineTo(right, point.y);
                        ctx.stroke();

                        ctx.restore();
                                    }
                                };

                        Chart.register(crosshairPlugin);


                        // DATA
                        const totals = {!! json_encode($chartTotals) !!};
                        const counts = {!! json_encode($chartCounts) !!};
                        const labels = {!! json_encode($chartLabels) !!};
                                const avg = totals.map((v, i) => counts[i] ? v / counts[i] : 0);

                        const ctx = document.getElementById('expenseBarChart').getContext('2d');

                        let currentType = "bar"; // bar → line → area

                        const chart = new Chart(ctx, {
                            type: 'bar',
                        data: {
                            labels,
                            datasets: [{

                            label: 'Chi Tiêu / Giao Dịch',
                        data: avg,
                        fill: true,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(14, 165, 233, 0.55)',
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 2,
                        pointHoverRadius: 5,
                        yAxisID: "moneyAxis",
                                        },
                        {

                            label: "Tổng Chi Tiêu (VND)",
                        data: totals,
                        borderColor: '#1d4ed8',
                        backgroundColor: createGradient(
                        ctx,
                        'rgba(252, 165, 165, 0.9)',
                        'rgba(244, 63, 94, 0.7)'
                        ),
                        tension: 0.4,
                        borderWidth: 1.5,
                        pointRadius: 2,
                        pointHoverRadius: 5,
                        yAxisID: "moneyAxis"
                                        },
                        {

                            label: 'Số Giao Dịch Thành Công',
                        data: counts,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.25)',
                        borderWidth: 2,
                        tension: 0.4,
                        yAxisID: "countAxis",
                        pointRadius: 2,
                        pointHoverRadius: 5
                                        }

                        ]
                                    },
                        options: {
                            responsive: true,
                        maintainAspectRatio: false,

                        animation: {
                            duration: 600,
                        easing: 'easeInOutQuart'
                                        },

                        scales: {
                            moneyAxis: {
                            position: "left",
                        ticks: {
                            callback: v => v.toLocaleString('vi-VN')
                                                }
                                            },
                        countAxis: {
                            position: "right",
                        beginAtZero: true,
                        grid: {
                            display: false
                                                },
                        ticks: {
                            stepSize: 1,
                                                    callback: v => Number.isInteger(v) ? v : ''
                                                }
                                            }
                                        },

                        plugins: {
                            tooltip: {
                            enabled: true
                                            },
                        legend: {
                            position: 'bottom'
                                            }
                                        }
                                    }
                                });


                        //  BUTTTON: Toggle Chart Type
                        document.getElementById("toggleChartType")
                                    .addEventListener("click", () => {

                            // xoay vòng
                            currentType =
                            currentType === "bar" ? "line" :
                                currentType === "line" ? "area" :
                                    "bar";

                                        chart.data.datasets.forEach(ds => {

                                            if (currentType === "area") {
                            ds.type = "line";
                        ds.fill = true;
                                            } else {
                            ds.type = currentType;
                        ds.fill = false;
                                            }
                                        });

                        chart.update();
                                    });

                        //    --- Logic Chuyển Đổi Phạm Vi ---
                        document.getElementById('chart-range-select')
                        .addEventListener('change', function () {
                                        const selectedValue = this.value;
                        window.location.href = `?range=${selectedValue}`;
                                    });
                            });
        </script>
    @endpush
</x-app-layout>