@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap');

        :root {
            --nk-primary: #0061ff;
            --nk-primary-container: #2563eb;
            --nk-surface: #f8fafc;
            --nk-surface-low: #f1f5f9;
            --nk-surface-lowest: #ffffff;
            --nk-on-surface: #0f172a;
            --nk-on-surface-variant: #475569;
            --nk-outline-variant: rgba(203, 213, 225, 0.3);
            
            /* Vibrant Status Colors */
            --nk-success: #10b981;
            --nk-success-bg: #ecfdf5;
            --nk-warning: #f59e0b;
            --nk-warning-bg: #fffbeb;
            --nk-error: #ef4444;
            --nk-error-bg: #fef2f2;
        }

        .dark {
            --nk-primary: #3b82f6;
            --nk-primary-container: #1e40af;
            --nk-surface: #0b0f1a;
            --nk-surface-low: #151b2c;
            --nk-surface-lowest: #1e293b;
            --nk-on-surface: #f1f5f9;
            --nk-on-surface-variant: #94a3b8;
            --nk-outline-variant: rgba(51, 65, 85, 0.4);
            
            --nk-success-bg: rgba(16, 185, 129, 0.1);
            --nk-warning-bg: rgba(245, 158, 11, 0.1);
            --nk-error-bg: rgba(239, 68, 68, 0.1);
        }

        /* Essential Animations */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1); }

        /* Typography */
        .font-manrope { font-family: 'Manrope', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }

        /* Base Styles */
        body {
            background-color: var(--nk-surface);
            color: var(--nk-on-surface);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Welcome Hero banner */
        .nk-hero-gradient {
            background: linear-gradient(100deg, #004ac6 50%, #002167ff 100%);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 74, 198, 0.2);
        }

        .nk-glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
        }
        .dark .nk-glass-card {
            background: rgba(15, 23, 42, 0.3);
            border-color: rgba(255, 255, 255, 0.05);
        }

        /* Stats Cards */
        .nk-stat-card {
            background: var(--nk-surface-lowest);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid var(--nk-outline-variant);
        }
        .nk-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border-color: var(--nk-primary);
        }
        .nk-stat-accent {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            border-radius: 20px 20px 0 0;
        }

        /* Section Layouts */
        .nk-section-underlay {
            background: var(--nk-surface-low);
            border-radius: 28px;
            padding: 32px;
            transition: background-color 0.3s ease;
        }

        .nk-card-white {
            background: var(--nk-surface-lowest);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--nk-outline-variant);
            transition: all 0.3s ease;
        }

        /* Buttons */
        .nk-btn-primary {
            background: linear-gradient(135deg, #0061ff 0%, #60a5fa 100%);
            color: white;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 97, 255, 0.3);
        }
        .nk-btn-primary:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 97, 255, 0.4);
        }

        .nk-btn-secondary {
            background: var(--nk-surface-lowest);
            color: var(--nk-primary);
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            border: 1px solid var(--nk-outline-variant);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .nk-btn-secondary:hover {
            background: var(--nk-surface-low);
            transform: translateY(-1px);
            border-color: var(--nk-primary);
        }

        /* Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--nk-outline-variant); border-radius: 10px; }

        /* Chart overrides */
        #toggleChartType {
            background: var(--nk-primary) !important;
            border: none !important;
            border-radius: 8px !important;
        }
    </style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between animate-slide-in">
            <div>
                <h2 class="text-4xl font-manrope font-black text-[var(--nk-on-surface)] tracking-tight">{{ __('Dashboard') }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <p class="text-sm font-inter font-medium text-[var(--nk-on-surface-variant)]">
                        {{ __('Online') }} • {{ __("System overview") }}
                    </p>
                </div>
            </div>
            @if ($user->expires_at)
                <div class="hidden md:flex nk-glass-card px-4 py-2 border-none bg-[var(--nk-surface-low)]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[var(--nk-surface-lowest)] flex items-center justify-center shadow-sm border border-[var(--nk-outline-variant)]">
                            <svg class="w-4 h-4 text-[var(--nk-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--nk-on-surface-variant)] uppercase tracking-widest">{{ __('Expires') }}
                            </p>
                            <p class="text-sm font-manrope font-bold text-[var(--nk-on-surface)]">
                                {{ $user->expires_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="space-y-8 py-6">
        {{-- Welcome Banner --}}
        <div class="lg:col-span-2 relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-8 text-white">
            {{-- Modern Decorative Elements --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#2563eb] opacity-20 blur-3xl -ml-24 -mb-24"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
                <div class="text-center lg:text-left space-y-4">
                    <h1 class="text-4xl md:text-6xl font-manrope font-black text-white leading-tight">
                        {{ __('Hello') }}, <span class="opacity-80">{{ $user->name }}</span>
                    </h1>
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        <div
                            class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-xl backdrop-blur-md border border-white/10">
                            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm font-bold text-white">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div
                            class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-xl backdrop-blur-md border border-white/10">
                            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="text-sm font-bold text-white">{{ number_format($user->login_count ?? 0) }}
                                {{ __('Sessions') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4">
                    @if ($user->expires_at)
                        <div class="nk-glass-card p-5 min-w-[240px] text-center shadow-2xl">
                            <p class="text-[10px] font-bold text-blue-100 uppercase tracking-widest mb-2 opacity-70">
                                {{ __('Access Remaining') }}</p>
                            <p id="countdown" class="text-2xl font-manrope font-black text-white"
                                data-expires-at="{{ $user->expires_at->timestamp * 1000 }}">
                                --:--:--
                            </p>
                        </div>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="nk-btn-secondary group min-w-[160px] justify-center">
                        <span>{{ __('Account Settings') }}</span>
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-180" fill="none"
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-in"
            style="animation-delay: 0.1s">

            {{-- Total Spend Card --}}
            <div class="nk-stat-card">
                <div class="nk-stat-accent bg-[var(--nk-primary)]"></div>
                <div class="flex flex-col gap-1">
                    <p class="text-[10px] font-bold text-[var(--nk-on-surface-variant)] uppercase tracking-widest font-inter">
                        {{ __('Total Spending') }}</p>
                    <div class="flex items-baseline gap-1">
                        <span
                            class="text-3xl font-manrope font-black text-[var(--nk-on-surface)]">{{ number_format($stats['total_spend']) }}</span>
                        <span class="text-xs font-bold text-[var(--nk-on-surface-variant)]">VND</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-[var(--nk-surface-low)] flex items-center justify-center border border-[var(--nk-outline-variant)]">
                            <svg class="w-4 h-4 text-[var(--nk-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-[var(--nk-on-surface-variant)]">{{ __('Successful') }}</span>
                    </div>
                </div>
            </div>

            {{-- Success Transactions --}}
            <div class="nk-stat-card">
                <div class="nk-stat-accent bg-[var(--nk-success)]"></div>
                <div class="flex flex-col gap-1">
                    <p class="text-[10px] font-bold text-[var(--nk-on-surface-variant)] uppercase tracking-widest font-inter">
                        {{ __('Successful') }}</p>
                    <div class="flex items-baseline gap-1">
                        <span
                            class="text-3xl font-manrope font-black text-[var(--nk-on-surface)]">{{ number_format($stats['success']) }}</span>
                        <span class="text-xs font-bold text-[var(--nk-on-surface-variant)]">{{ __('Trans.') }}</span>
                    </div>
                    <div class="mt-4">
                        <div
                            class="flex items-center justify-between text-[10px] font-bold uppercase tracking-tighter text-[var(--nk-on-surface-variant)] mb-1">
                            <span>{{ __('Rate') }}</span>
                            <span>{{ $stats['total_transactions'] > 0 ? round(($stats['success'] / $stats['total_transactions']) * 100, 1) : 0 }}%</span>
                        </div>
                        <div class="w-full h-1 bg-[var(--nk-surface-low)] rounded-full overflow-hidden">
                            <div class="h-full bg-[var(--nk-success)] shadow-[0_0_8px_rgba(16,185,129,0.3)]"
                                style="width: {{ $stats['total_transactions'] > 0 ? ($stats['success'] / $stats['total_transactions']) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Transactions --}}
            <div class="nk-stat-card">
                <div class="nk-stat-accent bg-[var(--nk-warning)]"></div>
                <div class="flex flex-col gap-1">
                    <p class="text-[10px] font-bold text-[var(--nk-on-surface-variant)] uppercase tracking-widest font-inter">
                        {{ __('Awaiting Payment') }}</p>
                    <div class="flex items-baseline gap-1">
                        <span
                            class="text-3xl font-manrope font-black text-[var(--nk-on-surface)]">{{ number_format($stats['pending']) }}</span>
                        <span class="text-xs font-bold text-[var(--nk-on-surface-variant)]">{{ __('Trans.') }}</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-[var(--nk-warning-bg)] flex items-center justify-center border border-[var(--nk-outline-variant)]">
                            <svg class="w-4 h-4 text-[var(--nk-warning)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-[var(--nk-on-surface-variant)]">{{ $stats['total_transactions'] > 0 ? round(($stats['pending'] / $stats['total_transactions']) * 100, 1) : 0 }}%
                            {{ __('of total') }}</span>
                    </div>
                </div>
            </div>

            {{-- Failed/Cancelled --}}
            <div class="nk-stat-card">
                <div class="nk-stat-accent bg-[var(--nk-error)]"></div>
                <div class="flex flex-col gap-1">
                    <p class="text-[10px] font-bold text-[var(--nk-on-surface-variant)] uppercase tracking-widest font-inter">
                        {{ __('Failed/Cancelled') }}</p>
                    <div class="flex items-baseline gap-1">
                        <span
                            class="text-3xl font-manrope font-black text-[var(--nk-on-surface)]">{{ number_format($stats['failed']) }}</span>
                        <span class="text-xs font-bold text-[var(--nk-on-surface-variant)]">{{ __('Trans.') }}</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-[var(--nk-error-bg)] flex items-center justify-center border border-[var(--nk-outline-variant)]">
                            <svg class="w-4 h-4 text-[var(--nk-error)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-medium text-[var(--nk-on-surface-variant)]">{{ $stats['total_transactions'] > 0 ? round(($stats['failed'] / $stats['total_transactions']) * 100, 1) : 0 }}%
                            {{ __('of total') }}</span>
                    </div>
                </div>
            </div>
        </div> {{-- Charts Section --}}
        <div class="nk-section-underlay animate-slide-in" style="animation-delay: 0.2s">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Pie Chart --}}
                <div class="nk-card-white">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-manrope font-black text-[var(--nk-on-surface)]">{{ __('Distribution') }}</h3>
                    </div>
                    <div class="relative h-64">
                        <canvas id="transactionPieChart"></canvas>
                    </div>
                    <div class="mt-8 space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--nk-surface-low)]">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#10B981]"></span>
                                <span class="text-sm font-inter font-bold text-[var(--nk-on-surface)]">{{ __('Successful') }}</span>
                            </div>
                            <span class="font-manrope font-black text-xs text-[var(--nk-on-surface)]">{{ $stats['success'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--nk-surface-low)]">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#F59E0B]"></span>
                                <span class="text-sm font-inter font-bold text-[var(--nk-on-surface)]">{{ __('Pending') }}</span>
                            </div>
                            <span class="font-manrope font-black text-xs text-[var(--nk-on-surface)]">{{ $stats['pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--nk-surface-low)]">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#EF4444]"></span>
                                <span class="text-sm font-inter font-bold text-[var(--nk-on-surface)]">{{ __('Failed') }}</span>
                            </div>
                            <span class="font-manrope font-black text-xs text-[var(--nk-on-surface)]">{{ $stats['failed'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- Bar Chart --}}
                <div class="lg:col-span-2 nk-card-white">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-manrope font-black text-[var(--nk-on-surface)]">{{ __('Expenditure Trend') }}
                            </h3>
                        </div>

                        <div class="flex items-center gap-2">
                            <button id="toggleChartType" class="nk-btn-primary !py-2 !px-4 !text-xs">
                                {{ __('Switch View') }}
                            </button>
                            <select id="chart-range-select"
                                class="p-2 border-none bg-[var(--nk-surface-low)] rounded-xl text-xs font-bold font-manrope text-[var(--nk-on-surface-variant)] focus:ring-2 focus:ring-[var(--nk-primary)]">
                                <option value="7days" {{ $currentRange === '7days' ? 'selected' : '' }}>7D</option>
                                <option value="month" {{ $currentRange === 'month' ? 'selected' : '' }}>30D</option>
                                <option value="year" {{ $currentRange === 'year' ? 'selected' : '' }}>1Y</option>
                            </select>
                        </div>
                    </div>

                    <div class="h-80">
                        <canvas id="expenseBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        >

        {{-- Recent Activities & Products --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-in" style="animation-delay: 0.3s">

            {{-- Recent Products --}}
            <div class="nk-card-white">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-manrope font-black text-[var(--nk-on-surface)]">{{ __('Recent Orders') }}</h3>
                    </div>
                    <a href="{{ route('transactions.index') }}"
                        class="text-xs font-bold text-[var(--nk-primary)] hover:underline uppercase tracking-widest font-inter">
                        {{ __('View All') }}
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse($productsBought as $transaction)
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl hover:bg-[var(--nk-surface-low)] transition-all group">
                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                <div
                                    class="w-12 h-12 bg-[var(--nk-surface-low)] rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-[var(--nk-surface-lowest)] group-hover:shadow-sm transition-colors border border-[var(--nk-outline-variant)]">
                                    <svg class="w-6 h-6 text-[var(--nk-on-surface-variant)]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-[var(--nk-on-surface)] truncate">
                                        {{ $transaction->product->name ?? 'Unknown' }}</p>
                                    <p class="text-[10px] font-medium text-[var(--nk-on-surface-variant)] uppercase tracking-tighter">
                                        #{{ $transaction->order_code }} • {{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-manrope font-black text-[var(--nk-success)]">
                                    {{ number_format($transaction->amount) }}</p>
                                <p class="text-[10px] font-bold text-[var(--nk-on-surface-variant)]">VND</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20">
                            <p class="text-sm font-medium text-[var(--nk-on-surface-variant)] mb-4">{{ __('No orders found') }}</p>
                            <a href="{{ route('products') }}" class="nk-btn-primary !text-xs">{{ __('Explore') }}</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Activity Timeline --}}
            <div class="nk-card-white">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-manrope font-black text-[var(--nk-on-surface)]">{{ __('Timeline') }}</h3>
                    </div>
                </div>
                <div class="space-y-1">
                    @foreach ($activities as $activity)
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-[var(--nk-surface-low)] transition-all">
                            <div class="mt-1.5 flex flex-col items-center flex-shrink-0">
                                <div
                                    class="w-2.5 h-2.5 rounded-full bg-{{ $activity['color'] }}-500 shadow-[0_0_8px_rgba(var(--color-{{ $activity['color'] }}-500),0.4)]">
                                </div>
                                <div class="w-0.5 h-full bg-[var(--nk-surface-low)] mt-1 min-h-[20px]"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-[var(--nk-on-surface)] leading-tight">{{ $activity['desc'] }}</p>
                                <p class="text-[10px] font-medium text-[var(--nk-on-surface-variant)] mt-1">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Actions Banner --}}
        <div class="nk-hero-gradient p-10 mt-12 mb-8 animate-slide-in" style="animation-delay: 0.4s">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-center md:text-left">
                    <h3 class="text-3xl font-manrope font-black text-white mb-2">{{ __('Ready to expand?') }}</h3>
                    <p class="text-blue-100 font-inter font-medium opacity-80">
                        {{ __('Explore our premium products and exclusive deals today.') }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('products') }}" class="nk-btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        {{ __('Store') }}
                    </a>
                    <a href="{{ route('support.contact') }}"
                        class="flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold transition-all backdrop-blur-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        {{ __('Support') }}
                    </a>
                </div>
            </div>
            {{-- Decorative circles for CTA --}}
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 blur-3xl rounded-full -ml-32 -mt-32"></div>
        </div>
    </div>
    </div>
    @push('scripts')
        {{-- Progress/Countdown Script --}}
        @if ($user->expires_at)
            <script>
                (function () {
                    const countdownEl = document.getElementById('countdown');
                    if (!countdownEl) return;
                    const expiresAt = parseInt(countdownEl.dataset.expiresAt);

                    const countdownInterval = setInterval(function () {
                        const now = new Date().getTime();
                        const distance = expiresAt - now;

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        if (distance > 0) {
                            countdownEl.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                        } else {
                            clearInterval(countdownInterval);
                            countdownEl.innerHTML = "EXPIRED";
                            countdownEl.classList.add('text-red-400');
                        }
                    }, 1000);
                })();
            </script>
        @endif

        {{-- Charts Script --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctxPie = document.getElementById('transactionPieChart')?.getContext('2d');
                const ctxBar = document.getElementById('expenseBarChart')?.getContext('2d');

                // Utility: Create Gradient
                const createGradient = (ctx, colorFrom, colorTo) => {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, colorFrom);
                    gradient.addColorStop(1, colorTo);
                    return gradient;
                };

                const isDarkMode = document.documentElement.classList.contains('dark');
                const labelColor = isDarkMode ? '#94a3b8' : '#64748b';
                const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(148, 163, 184, 0.1)';

                // Pie Chart Logic
                if (ctxPie) {
                    const successCount = {{ $stats['success'] }};
                    const pendingCount = {{ $stats['pending'] }};
                    const failedCount = {{ $stats['failed'] }};
                    const totalTransactions = successCount + pendingCount + failedCount;

                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: ['Thành công', 'Chờ xử lý', 'Thất bại'],
                            datasets: [{
                                data: [successCount, pendingCount, failedCount],
                                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                                borderWidth: 0,
                                hoverOffset: 15
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '80%',
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: isDarkMode ? '#1e293b' : '#0f172a',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    padding: 15,
                                    bodyFont: { family: 'Inter', size: 13, weight: '600' },
                                    callbacks: {
                                        label: (context) => {
                                            const count = context.parsed;
                                            const pct = totalTransactions > 0 ? ((count / totalTransactions) * 100).toFixed(1) : 0;
                                            return ` ${context.label}: ${count} (${pct}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Bar Chart Logic
                if (ctxBar) {
                    const crosshairPlugin = {
                        id: 'crosshairPlugin',
                        afterDraw(chart) {
                            if (!chart.tooltip?._active?.length) return;
                            const { ctx, chartArea: { top, bottom, left, right } } = chart;
                            const point = chart.tooltip._active[0].element;
                            ctx.save();
                            ctx.setLineDash([4, 4]);
                            ctx.lineWidth = 1;
                            ctx.strokeStyle = isDarkMode ? 'rgba(255, 255, 255, 0.2)' : 'rgba(148, 163, 184, 0.5)';
                            ctx.beginPath(); ctx.moveTo(point.x, top); ctx.lineTo(point.x, bottom); ctx.stroke();
                            ctx.beginPath(); ctx.moveTo(left, point.y); ctx.lineTo(right, point.y); ctx.stroke();
                            ctx.restore();
                        }
                    };
                    Chart.register(crosshairPlugin);

                    const totals = {!! json_encode($chartTotals) !!};
                    const counts = {!! json_encode($chartCounts) !!};
                    const labels = {!! json_encode($chartLabels) !!};
                    
                    const chart = new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [
                                {
                                    label: 'Tổng Chi Tiêu (VND)',
                                    data: totals,
                                    borderColor: '#0061ff',
                                    backgroundColor: createGradient(ctxBar, 'rgba(0, 97, 255, 0.6)', 'rgba(0, 97, 255, 0.05)'),
                                    tension: 0.4,
                                    borderWidth: 3,
                                    fill: true,
                                    yAxisID: "moneyAxis"
                                },
                                {
                                    label: 'Số Giao Dịch VC',
                                    data: counts,
                                    borderColor: '#f59e0b',
                                    backgroundColor: 'rgba(245, 158, 11, 0.3)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    yAxisID: "countAxis"
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { intersect: false, mode: 'index' },
                            scales: {
                                moneyAxis: {
                                    position: "left",
                                    grid: { color: gridColor },
                                    ticks: { color: labelColor, callback: v => v.toLocaleString('vi-VN'), font: { family: 'Manrope', size: 10, weight: '700' } }
                                },
                                countAxis: {
                                    position: "right",
                                    grid: { display: false },
                                    ticks: { color: labelColor, stepSize: 1, font: { family: 'Manrope', size: 10, weight: '700' } }
                                }
                            },
                            plugins: {
                                legend: { position: 'bottom', labels: { color: labelColor, font: { family: 'Inter', size: 11, weight: '700' }, usePointStyle: true, boxWidth: 6 } },
                                tooltip: { backgroundColor: isDarkMode ? '#1e293b' : '#0f172a', padding: 15, bodyFont: { family: 'Inter', size: 12 } }
                            }
                        }
                    });

                    // Toggle Logic
                    document.getElementById("toggleChartType")?.addEventListener("click", () => {
                        currentType = currentType === "bar" ? "line" : "bar";
                        chart.data.datasets.forEach(ds => { ds.type = currentType; ds.fill = (currentType === "line"); });
                        chart.update();
                    });

                    // Range Switch
                    document.getElementById('chart-range-select')?.addEventListener('change', function () {
                        window.location.href = `?range=${this.value}`;
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>