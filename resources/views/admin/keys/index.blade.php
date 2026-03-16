@push('styles')
<style>
/* Welcome Banner → navy with blue accent */
.nk-welcome-banner {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #0a0f1e 0%, #1a2a4e 60%, #2563eb 100%);
    border-radius: 20px;
    padding: 40px;
    color: white;
    box-shadow: 0 20px 60px rgba(37,99,235,0.2);
}
.nk-welcome-banner::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(37,99,235,0.3) 0%, transparent 70%);
    border-radius: 50%;
}
.nk-welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -40px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%);
    border-radius: 50%;
}

/* Stat cards */
.nk-stat-card {
    background: var(--bg-card, white);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 16px;
    padding: 24px;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
}
.nk-stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
.dark .nk-stat-card { background: var(--bg-card, #161b22); border-color: var(--border, #30363d); }

.nk-stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
}
.nk-stat-icon-blue  { background: rgba(37,99,235,0.1); }
.nk-stat-icon-green { background: rgba(34,197,94,0.1); }
.nk-stat-icon-amber { background: rgba(245,158,11,0.1); }
.nk-stat-icon-red   { background: rgba(239,68,68,0.1); }

.nk-stat-label {
    font-size: 0.72rem; font-weight: 700;
    letter-spacing: 1px; text-transform: uppercase;
    color: var(--fg-muted, #6b7280); margin-bottom: 6px;
}
.nk-stat-value {
    font-size: 2rem; font-weight: 900;
    color: var(--fg, #111827);
    font-family: 'Inter', sans-serif;
    letter-spacing: -1px;
}
.dark .nk-stat-value { color: #e6edf3; }

.nk-stat-sub {
    font-size: 0.75rem; color: var(--fg-muted, #6b7280);
    margin-top: 6px;
}

.nk-stat-accent-stripe {
    position: absolute; top: 0; left: 0; bottom: 0; width: 4px;
    border-radius: 16px 0 0 16px;
}
.stripe-blue  { background: #2563eb; }
.stripe-green { background: #22c55e; }
.stripe-amber { background: #f59e0b; }
.stripe-red   { background: #ef4444; }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">
                    {{ __('Keys Management') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="space-y-6">
            <div class="nk-welcome-banner !p-6 sm:!p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="space-y-2">
                        <h3 class="text-xl sm:text-2xl font-black text-white">
                            {{ __('Keys Overview') }}
                        </h3>
                        <p class="text-white/70 text-sm sm:text-base">{{ __('Manage all keys in the system') }}</p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="text-center">
                            <div class="text-3xl font-black text-white">{{ $stats['total'] }}</div>
                            <div class="text-[10px] text-white/50 uppercase tracking-[2px] font-bold">
                                {{ __('Total Keys') }}
                            </div>
                        </div>
                        <div class="h-10 w-px bg-white/10"></div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

                <div
                    class="nk-stat-card">
                    <div class="nk-stat-accent-stripe stripe-green"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="nk-stat-label">Active</p>
                            <p class="nk-stat-value !text-2xl">
                                {{ number_format($stats['active']) }}
                            </p>
                        </div>
                        <div class="nk-stat-icon nk-stat-icon-green">
                            <svg class="w-6 h-6 text-green-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z " />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe stripe-amber"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="nk-stat-label">Expired</p>
                            <p class="nk-stat-value !text-2xl">
                                {{ number_format($stats['expired']) }}
                            </p>
                        </div>
                        <div class="nk-stat-icon nk-stat-icon-amber">
                            <svg class="w-6 h-6 text-amber-600" fill="none"
                                stroke="currentColor" viewBox="0 0 28 28 ">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3h14v4l-7 8 7 8v4H5v-4l7-8-7-8V3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe stripe-red"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="nk-stat-label">Suspended</p>
                            <p class="nk-stat-value !text-2xl">
                                {{ number_format($stats['suspended']) }}
                            </p>
                        </div>
                        <div class="nk-stat-icon nk-stat-icon-red">
                            <svg class="w-6 h-6 text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="nk-stat-card">
                    <div class="nk-stat-accent-stripe !bg-gray-400"></div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="nk-stat-label">Deleted</p>
                            <p class="nk-stat-value !text-2xl">
                                {{ number_format($stats['deleted']) }}
                            </p>
                        </div>
                        <div class="nk-stat-icon bg-gray-100 p-3 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Box -->
            <div
                class="bg-white dark:bg-[#161b22] rounded-2xl shadow-lg border border-gray-100 dark:border-[#30363d] p-6 transition-all duration-300">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="nk-section-label">{{ __('Search') }}</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search by Key Code or Email...') }}"
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition duration-200">
                    </div>

                    <div>
                        <label class="nk-section-label">{{ __('Status') }}</label>
                        <select name="status"
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200">
                            <option value="">-- {{ __('All Status') }} --</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired
                            </option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>
                                Suspended
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="nk-section-label">{{ __('Deleted Status') }}</label>
                        <select name="show_deleted"
                            class="w-full px-4 py-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 cursor-pointer transition duration-200">
                            <option value="">{{ __('Not Deleted Keys') }}</option>
                            <option value="with" {{ request('show_deleted') == 'with' ? 'selected' : '' }}>
                                {{ __('All Keys') }}
                            </option>
                            <option value="only" {{ request('show_deleted') == 'only' ? 'selected' : '' }}>
                                {{ __('Deleted Keys') }}
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2 pb-[2px]">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-xl hover:bg-blue-700 font-bold transition shadow-lg shadow-blue-500/20 uppercase tracking-wider text-xs">
                            🔍 {{ __('Filter') }}
                        </button>
                        <a href="{{ route('admin.keys.index') }}"
                            class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-xl hover:bg-gray-200 transition flex items-center justify-center border-2 border-transparent">
                            ↺
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div
                class="bg-white dark:bg-[#161b22] rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-[#30363d]">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="bg-[#0a0f1e] text-white">
                            <tr>
                                <th class="px-6 py-5 [10px] font-black uppercase tracking-[2px] opacity-50">{{ __('ID / Time') }}</th>
                                <th class="px-6 py-5 [10px] font-black uppercase tracking-[2px] opacity-50">{{ __('Key Code') }}</th>
                                <th class="px-6 py-5 [10px] font-black uppercase tracking-[2px] opacity-50 hidden lg:table-cell">
                                    {{ __('Owner') }}</th>
                                <th class="px-6 py-5 [10px] font-black uppercase tracking-[2px] opacity-50 hidden lg:table-cell">
                                    {{ __('Type') }}
                                </th>
                                <th class="px-6 py-5 [10px] font-black uppercase tracking-[2px] opacity-50 hidden lg:table-cell">
                                    {{ __('Status') }}</th>
                                <th class="px-6 py-5 [10px] font-black uppercase tracking-[2px] opacity-50">{{ __('Expires') }}</th>
                                <th class="px-6 py-5 text-center [10px] font-black uppercase tracking-[2px] opacity-50">
                                    {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($keys as $key)
                                <tr
                                    class="bg-white dark:bg-[#161b22] hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors duration-150 group {{ $key->trashed() ? 'opacity-60' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                ID Key: {{ $key->id }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $key->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                            </span>
                                            @if ($key->trashed())
                                                <span class="text-xs text-red-500 font-semibold mt-1">
                                                    🗑️ {{ __('Deleted') }}
                                                </span>
                                            @endif
                                            <span class="lg:hidden font-medium text-gray-900 dark:text-white">
                                                Owner: {{ $key->user->email ?? 'Không có' }}
                                            </span>
                                            <span class="lg:hidden text-xs text-gray-500">
                                                ID User: {{ $key->user->id ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-mono font-bold text-blue-600 dark:text-blue-400 select-all">
                                            {{ $key->key_code }}
                                        </span>
                                        <span class="lg:hidden flex flex-col">
                                            @if ($key->key_type == 'custom')
                                                <span class="font-medium text-gray-900 dark:text-white">Class:
                                                    Custom</span>
                                            @else
                                                <span class="font-medium text-gray-900 dark:text-white">Class:
                                                    Auto</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ $key->user->email ?? __('None') }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                ID: {{ $key->user->id ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @if ($key->key_type == 'custom')
                                            <span
                                                class="bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-purple-200 dark:border-purple-800">Custom</span>
                                        @else
                                            <span
                                                class="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-blue-200 dark:border-blue-800">Auto</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @if ($key->isActive())
                                            <span
                                                class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full border border-green-200 dark:border-green-800">
                                                Active
                                            </span>
                                        @elseif($key->isExpired())
                                            <span
                                                class="inline-flex items-center gap-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full border border-gray-300">
                                                Expired
                                            </span>
                                        @elseif($key->isSuspended())
                                            <span
                                                class="inline-flex items-center gap-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full border border-amber-200 dark:border-amber-800">
                                                Suspended
                                            </span>
                                        @elseif($key->isRevoked())
                                            <span
                                                class="inline-flex items-center gap-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full border border-red-200 dark:border-red-800">
                                                Revoked
                                            </span>
                                        @endif
                                    </td>
                                    {{-- <!-- Status Badge -->
                                    <div class="absolute top-4 right-4 z-10">
                                        @if ($key->isActive())
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-lg shadow-sm">ACTIVE</span>
                                        @elseif($key->isExpired())
                                        <span
                                            class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-lg shadow-sm">EXPIRED</span>
                                        @else
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-lg shadow-sm">{{
                                            strtoupper($key->status) }}</span>
                                        @endif
                                    </div> --}}
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        <span class="flex flex-col">
                                            @if ($key->expires_at)
                                                <div>
                                                    {{ $key->expires_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                                                </div>
                                                <div>
                                                    {{ $key->expires_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s') }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $key->expires_at->setTimezone('Asia/Ho_Chi_Minh')->diffForHumans() }}
                                                </div>
                                            @else
                                                <span class="text-infinity text-lg">∞</span>
                                            @endif
                                        </span>
                                        <span class="lg:hidden flex flex-col">
                                            @if ($key->isActive())
                                                <span
                                                    class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold px-2.5 py-0.5 rounded-full border border-green-200 dark:border-green-800">
                                                    Active
                                                </span>
                                            @elseif($key->isExpired())
                                                <span
                                                    class="inline-flex items-center gap-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-bold px-2.5 py-0.5 rounded-full border border-gray-300">
                                                    Expired
                                                </span>
                                            @elseif($key->isSuspended())
                                                <span
                                                    class="inline-flex items-center gap-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-bold px-2.5 py-0.5 rounded-full border border-yellow-200 dark:border-yellow-800">
                                                    Suspended
                                                </span>
                                            @elseif($key->isRevoked())
                                                <span
                                                    class="inline-flex items-center gap-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold px-2.5 py-0.5 rounded-full border border-red-200 dark:border-red-800">
                                                    Revoked
                                                </span>
                                            @endif
                                        </span>

                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            @if ($key->trashed())
                                                {{-- Key đã xóa: Chỉ có Xem & Khôi phục --}}
                                                <a href="{{ route('admin.keys.show', $key->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition text-xs font-medium"
                                                    title="Xem chi tiết">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    {{ __('View') }}
                                                </a>

                                                <form action="{{ route('admin.keys.restore', $key->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 rounded-lg transition text-xs font-medium"
                                                        title="Khôi phục">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                        {{ __('Restore') }}
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Key còn: Xem, Sửa, Xóa --}}
                                                <a href="{{ route('admin.keys.show', $key->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition text-xs font-medium"
                                                    title="Xem chi tiết">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    {{ __('View') }}
                                                </a>

                                                <a href="{{ route('admin.keys.edit', $key->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 rounded-lg transition text-xs font-medium"
                                                    title="Chỉnh sửa">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    {{ __('Edit') }}
                                                </a>

                                                <button onclick="confirmDelete{{ $key->id }}()"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg transition text-xs font-medium"
                                                    title="Xóa key">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    {{ __('Delete') }}
                                                </button>

                                                {{-- Modal xác nhận xóa --}}
                                                <div id="deleteModal{{ $key->id }}"
                                                    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                                                    <div
                                                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                                                        <div class="bg-[#0a0f1e] px-6 py-5 border-b border-white/5">
                                                            <h3 class="text-xl font-black text-white flex items-center gap-2">
                                                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                                Xác nhận xóa Key
                                                            </h3>
                                                        </div>

                                                        <div class="p-6">
                                                            <div
                                                                class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                                                    <strong>⚠️ Lưu ý:</strong> Key sẽ bị xóa
                                                                </p>
                                                            </div>

                                                            <div class="space-y-3 mb-6">
                                                                <div class="flex items-start gap-3">
                                                                    <div
                                                                        class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-semibold text-gray-900 dark:text-white">
                                                                            Key Code: <span
                                                                                class="font-mono text-red-600">{{ $key->key_code }}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-start gap-3">
                                                                    <div
                                                                        class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                                                            Admin vẫn thấy key với nhãn <span
                                                                                class="px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded font-semibold">ĐÃ
                                                                                XÓA</span></p>
                                                                    </div>
                                                                </div>

                                                                <div class="flex items-start gap-3">
                                                                    <div
                                                                        class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                                                                            fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                                                            Có thể <strong class="text-green-600">khôi
                                                                                phục</strong> key này bất cứ lúc nào</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <form action="{{ route('admin.keys.destroy', $key->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="flex gap-3">
                                                                    <button type="button"
                                                                        onclick="closeDeleteModal{{ $key->id }}()"
                                                                        class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-medium transition">
                                                                        Hủy bỏ
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition flex items-center justify-center gap-2">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                            viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                        </svg>
                                                                        Xóa Key
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    function confirmDelete{{ $key->id }}() {
                                                        document.getElementById('deleteModal{{ $key->id }}').classList.remove('hidden');
                                                    }

                                                    function closeDeleteModal{{ $key->id }}() {
                                                        document.getElementById('deleteModal{{ $key->id }}').classList.add('hidden');
                                                    }
                                                </script>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('No matching keys found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($keys->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        {{ $keys->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>