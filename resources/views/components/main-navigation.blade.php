@props(['user' => null])

@php
    $user = $user ?? auth()->user();
    $notifications = [];

    if ($user) {
        // Today's products (example - adjust based on your Product model)
        if (class_exists('\App\Models\Product')) {
            $todayProducts = \App\Models\Product::whereDate('created_at', today())->count();
            if ($todayProducts > 0) {
                $notifications[] = [
                    'type' => 'info',
                    'icon' => '🆕',
                    'title' => 'Sản phẩm mới',
                    'message' => "{$todayProducts} sản phẩm mới được thêm hôm nay",
                    'time' => 'Hôm nay',
                    'link' => route('products'),
                ];
            }
        }

        // Recent transactions (for current user)
        if (class_exists('\App\Models\Transaction')) {
            $recentSuccess = \App\Models\Transaction::where('user_id', $user->id)
                ->where('status', 'success')
                ->whereDate('created_at', '>=', now()->subDays(1))
                ->count();

            if ($recentSuccess > 0) {
                $notifications[] = [
                    'type' => 'success',
                    'icon' => '✅',
                    'title' => 'Giao dịch thành công',
                    'message' => "{$recentSuccess} giao dịch đã được xác nhận",
                    'time' => '24h qua',
                    'link' => '#',
                ];
            }

            $recentPending = \App\Models\Transaction::where('user_id', $user->id)->where('status', 'pending')->count();

            if ($recentPending > 0) {
                $notifications[] = [
                    'type' => 'warning',
                    'icon' => '⏳',
                    'title' => 'Chờ thanh toán',
                    'message' => "{$recentPending} giao dịch đang chờ xử lý",
                    'time' => 'Hiện tại',
                    'link' => '#',
                ];
            }

            $recentFailed = \App\Models\Transaction::where('user_id', $user->id)
                ->whereIn('status', ['failed', 'cancelled'])
                ->whereDate('created_at', '>=', now()->subDays(1))
                ->count();

            if ($recentFailed > 0) {
                $notifications[] = [
                    'type' => 'error',
                    'icon' => '❌',
                    'title' => 'Giao dịch thất bại',
                    'message' => "{$recentFailed} giao dịch không thành công",
                    'time' => '24h qua',
                    'link' => '#',
                ];
            }
        }

        // Daily Check-in Notification
        if (class_exists('\App\Models\DailyCheckin')) {
            $checkin = \App\Models\DailyCheckin::where('user_id', $user->id)->first();
            $isCheckedIn = $checkin && $checkin->last_checkin_date && \Illuminate\Support\Carbon::parse($checkin->last_checkin_date)->isToday();

            if (!$isCheckedIn) {
                $notifications[] = [
                    'type' => 'success',
                    'icon' => '🎁',
                    'title' => 'Điểm danh hàng ngày',
                    'message' => 'Bạn chưa điểm danh hôm nay! Nhận Coinkey ngay.',
                    'time' => 'Hôm nay',
                    'link' => route('checkin.index'),
                ];
            }
        }

        // Account Expiration Notification
        if ($user->account_expiration) {
            $daysRemaining = \Carbon\Carbon::now()->diffInDays($user->account_expiration, false);
            if ($daysRemaining < 3 && $daysRemaining > -30) {
                $notifications[] = [
                    'type' => 'error',
                    'icon' => '⚠️',
                    'title' => 'Tài khoản sắp hết hạn',
                    'message' => "Tài khoản của bạn sẽ hết hạn trong " . ($daysRemaining > 0 ? $daysRemaining . " ngày" : "hôm nay") . ". Gia hạn ngay!",
                    'time' => 'Quan trọng',
                    'link' => route('products'),
                ];
            }
        }
    }

    $hasNotifications = count($notifications) > 0;
@endphp

<style>
/* ══════════════════════════════════════════
   NETKEY SIDEBAR — DESIGN SYSTEM APPLIED
══════════════════════════════════════════ */

/* ── Topbar ── */
.nk-nav-topbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 50;
    height: 60px;
    background: var(--bg-elevated, #ffffff);
    border-bottom: 1px solid var(--border, #e5e7eb);
    display: flex; align-items: center;
    padding: 0 20px;
    justify-content: space-between;
    transition: background 0.2s, border 0.2s;
    font-family: 'Inter', sans-serif;
}
.dark .nk-nav-topbar { background: #161b22; border-color: #30363d; }

.nk-nav-topbar-left { display: flex; align-items: center; gap: 12px; }

.nk-nav-logo {
    display: flex; align-items: center; gap: 9px;
    text-decoration: none;
}
.nk-nav-logo-icon {
    width: 34px; height: 34px;
    background: #2563eb; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.nk-nav-logo-text {
    font-size: 1.2rem; font-weight: 800;
    color: #111827; letter-spacing: -0.5px;
    font-family: 'Inter', sans-serif;
}
.nk-nav-logo-text span { color: #2563eb; }
.dark .nk-nav-logo-text { color: #f1f5f9; }

.nk-hamburger {
    width: 36px; height: 36px; border: none;
    background: transparent; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #6b7280;
    transition: background 0.2s, color 0.2s;
}
.nk-hamburger:hover { background: #eff6ff; color: #2563eb; }
.dark .nk-hamburger:hover { background: rgba(96,165,250,0.1); color: #60a5fa; }

.nk-nav-topbar-right { display: flex; align-items: center; gap: 8px; }

/* Wallet badge */
.nk-wallet-badge {
    display: flex; align-items: center; gap: 8px;
    padding: 6px 12px 6px 14px;
    background: #f9fafb; border: 1px solid #e5e7eb;
    border-radius: 999px; transition: all 0.2s;
    text-decoration: none;
}
.nk-wallet-badge:hover { border-color: #93c5fd; background: #eff6ff; }
.dark .nk-wallet-badge { background: #1f2937; border-color: #374151; }
.dark .nk-wallet-badge:hover { border-color: #60a5fa; background: rgba(96,165,250,0.1); }

.nk-wallet-balance {
    font-size: 0.875rem; font-weight: 700;
    color: #2563eb; font-family: 'Inter', monospace;
}
.dark .nk-wallet-balance { color: #60a5fa; }
.nk-wallet-coin { font-size: 0.875rem; }

.nk-wallet-add {
    width: 26px; height: 26px;
    background: #2563eb; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: white; text-decoration: none;
    transition: all 0.2s; flex-shrink: 0;
}
.nk-wallet-add:hover { background: #1d4ed8; transform: scale(1.1); }

/* Icon buttons in topbar */
.nk-icon-btn {
    width: 36px; height: 36px;
    border-radius: 8px; border: 1px solid #e5e7eb;
    background: transparent; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #6b7280; transition: all 0.2s; position: relative;
}
.nk-icon-btn:hover { background: #eff6ff; color: #2563eb; border-color: #93c5fd; }
.dark .nk-icon-btn { border-color: #374151; color: #8b949e; }
.dark .nk-icon-btn:hover { background: rgba(96,165,250,0.1); color: #60a5fa; border-color: #60a5fa; }

/* Notif badge */
.nk-notif-dot {
    position: absolute; top: -3px; right: -3px;
    width: 18px; height: 18px;
    background: #ef4444; border-radius: 50%;
    border: 2px solid white;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem; font-weight: 700; color: white;
}

/* Dropdown panels */
.nk-dropdown {
    position: absolute; top: calc(100% + 8px); right: 0;
    width: 320px;
    background: var(--bg-elevated, white);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    overflow: hidden; z-index: 100;
    font-family: 'Inter', sans-serif;
}
.dark .nk-dropdown { background: #161b22; border-color: #30363d; }

.nk-dropdown-header {
    padding: 14px 18px;
    border-bottom: 1px solid var(--border, #e5e7eb);
    font-size: 0.8rem; font-weight: 700;
    color: var(--fg, #111827);
    letter-spacing: 0.5px; text-transform: uppercase;
}
.dark .nk-dropdown-header { border-color: #30363d; color: #e6edf3; }

.nk-notif-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--border, #f3f4f6);
    text-decoration: none; transition: background 0.15s;
}
.nk-notif-item:last-child { border-bottom: none; }
.nk-notif-item:hover { background: #f9fafb; }
.dark .nk-notif-item:hover { background: #1f2937; }
.dark .nk-notif-item { border-color: #21262d; }

.nk-notif-icn {
    width: 36px; height: 36px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; flex-shrink: 0; background: #f3f4f6;
}
.dark .nk-notif-icn { background: #21262d; }
.nk-notif-title { font-size: 0.825rem; font-weight: 600; color: #111827; margin-bottom: 3px; }
.dark .nk-notif-title { color: #e6edf3; }
.nk-notif-msg { font-size: 0.775rem; color: #6b7280; line-height: 1.4; }
.dark .nk-notif-msg { color: #8b949e; }
.nk-notif-time { font-size: 0.7rem; color: #9ca3af; margin-top: 4px; }

/* Profile dropdown */
.nk-profile-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 6px 10px 6px 6px;
    border-radius: 10px; border: 1px solid #e5e7eb;
    background: transparent; cursor: pointer;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
}
.nk-profile-btn:hover { background: #eff6ff; border-color: #93c5fd; }
.dark .nk-profile-btn { border-color: #374151; }
.dark .nk-profile-btn:hover { background: rgba(96,165,250,0.1); border-color: #60a5fa; }

.nk-avatar {
    width: 30px; height: 30px; border-radius: 8px;
    background: #2563eb; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700;
    font-family: 'Inter', sans-serif;
    flex-shrink: 0;
}

.nk-profile-name {
    font-size: 0.825rem; font-weight: 600; color: #374151;
    max-width: 100px; overflow: hidden;
    text-overflow: ellipsis; white-space: nowrap;
}
.dark .nk-profile-name { color: #e6edf3; }

/* Profile dropdown items */
.nk-profile-header {
    padding: 16px 18px;
    border-bottom: 1px solid var(--border, #e5e7eb);
}
.dark .nk-profile-header { border-color: #30363d; }
.nk-profile-uname { font-size: 0.875rem; font-weight: 700; color: #111827; }
.dark .nk-profile-uname { color: #e6edf3; }
.nk-profile-email { font-size: 0.75rem; color: #6b7280; margin-top: 2px; }
.dark .nk-profile-email { color: #8b949e; }

.nk-profile-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 18px;
    font-size: 0.85rem; font-weight: 500; color: #374151;
    text-decoration: none; transition: background 0.15s;
    border-bottom: 1px solid #f9fafb;
}
.dark .nk-profile-link { color: #c9d1d9; border-color: #21262d; }
.nk-profile-link:last-child { border-bottom: none; }
.nk-profile-link:hover { background: #f9fafb; color: #2563eb; }
.dark .nk-profile-link:hover { background: #1f2937; color: #60a5fa; }
.nk-profile-link svg { color: #9ca3af; flex-shrink: 0; }
.nk-profile-link:hover svg { color: #2563eb; }
.dark .nk-profile-link:hover svg { color: #60a5fa; }

.nk-profile-logout {
    display: flex; align-items: center; gap: 10px;
    width: 100%; padding: 10px 18px;
    font-size: 0.85rem; font-weight: 500; color: #dc2626;
    text-decoration: none; transition: background 0.15s;
    background: none; border: none; cursor: pointer;
    font-family: 'Inter', sans-serif; text-align: left;
}
.nk-profile-logout:hover { background: #fef2f2; }
.dark .nk-profile-logout { color: #f87171; }
.dark .nk-profile-logout:hover { background: rgba(239,68,68,0.1); }

/* ── SIDEBAR AUTO-HIDE SYSTEM ── */

/*
  Approach: A thin 16px trigger strip sits at the left edge (always visible).
  The sidebar itself is 260px wide but translated -244px so only 16px "peek" shows.
  When hovering either the wrapper (.nk-sidebar-wrapper) which contains both,
  the sidebar slides fully into view.
  On mobile: the hamburger button overrides this with Alpine.js .open class.
*/

/* Wrapper that parents the trigger + sidebar */
.nk-sidebar-wrapper {
    position: fixed; top: 60px; left: 0; bottom: 0;
    z-index: 100; /* Overlays content */
    width: 260px;
    pointer-events: none; /* Let clicks pass through to content when collapsed */
}

/* The thin invisible trigger zone */
.nk-sidebar-trigger {
    position: absolute; top: 0; left: 0; bottom: 0;
    width: 16px; cursor: pointer;
    pointer-events: auto; /* Catch hover events */
    z-index: 101;
}

/* The sidebar itself */
.nk-sidebar {
    position: absolute; top: 0; left: 0; bottom: 0;
    width: 260px;
    background: #0a0f1e;
    border-right: 1px solid rgba(255,255,255,0.06);
    overflow-y: auto; overflow-x: hidden;
    font-family: 'Inter', sans-serif;
    display: flex; flex-direction: column;
    /* Slide completely off-screen */
    transform: translateX(-100%);
    transition: transform 0.28s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.28s ease;
    scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.1) transparent;
    box-shadow: none;
    pointer-events: auto; /* Interact with sidebar content */
}

/* Alpine.js Toggled State */
.nk-sidebar.open {
    transform: translateX(0);
    box-shadow: 8px 0 40px rgba(0,0,0,0.4);
}

/* Hover reveal — desktop only */
@media (min-width: 1025px) {
    .nk-sidebar-wrapper:hover .nk-sidebar {
        transform: translateX(0);
        box-shadow: 8px 0 40px rgba(0,0,0,0.4);
    }
}

/* Scrollbar styling */
.nk-sidebar::-webkit-scrollbar { width: 4px; }
.nk-sidebar::-webkit-scrollbar-track { background: transparent; }
.nk-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

/* User card in sidebar */
.nk-sidebar-user {
    padding: 20px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; gap: 12px;
}
.nk-sidebar-avatar {
    width: 40px; height: 40px; border-radius: 10px;
    background: #2563eb; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem; font-weight: 700;
    flex-shrink: 0; position: relative;
}
.nk-sidebar-avatar-dot {
    position: absolute; bottom: -2px; right: -2px;
    width: 10px; height: 10px;
    background: #22c55e; border: 2px solid #0a0f1e;
    border-radius: 50%;
}
.nk-sidebar-info { min-width: 0; }
.nk-sidebar-name {
    font-size: 0.85rem; font-weight: 600;
    color: #f1f5f9; overflow: hidden;
    text-overflow: ellipsis; white-space: nowrap;
}
.nk-sidebar-email {
    font-size: 0.72rem; color: rgba(255,255,255,0.35);
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    margin-top: 2px;
}
.nk-sidebar-role {
    display: inline-flex; align-items: center;
    padding: 2px 8px; border-radius: 999px;
    font-size: 0.65rem; font-weight: 600;
    margin-top: 5px; letter-spacing: 0.3px;
}
.role-admin { background: rgba(37,99,235,0.2); color: #60a5fa; border: 1px solid rgba(37,99,235,0.3); }
.role-user  { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.45); border: 1px solid rgba(255,255,255,0.08); }

/* Nav sections */
.nk-sidebar-nav { flex: 1; padding: 16px 12px 12px; }

.nk-nav-section { margin-bottom: 24px; }
.nk-nav-section-label {
    font-size: 0.65rem; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase;
    color: rgba(255,255,255,0.25);
    padding: 0 8px; margin-bottom: 6px; display: block;
}

.nk-nav-link {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 10px;
    border-radius: 9px;
    font-size: 0.85rem; font-weight: 500;
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    transition: all 0.2s;
    margin-bottom: 2px; position: relative;
    white-space: nowrap;
}
.nk-nav-link svg { flex-shrink: 0; opacity: 0.6; transition: opacity 0.2s; }
.nk-nav-link:hover {
    background: rgba(37,99,235,0.15);
    color: rgba(255,255,255,0.9);
}
.nk-nav-link:hover svg { opacity: 1; }

/* Active state */
.nk-nav-link.active {
    background: rgba(37,99,235,0.2);
    color: #60a5fa;
}
.nk-nav-link.active::before {
    content: '';
    position: absolute; left: -12px; top: 50%; transform: translateY(-50%);
    width: 3px; height: 24px;
    background: #2563eb; border-radius: 999px;
}
.nk-nav-link.active svg { opacity: 1; color: #60a5fd; }

/* Sidebar footer */
.nk-sidebar-footer {
    padding: 12px 16px;
    border-top: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: space-between;
    font-size: 0.7rem; color: rgba(255,255,255,0.2);
    white-space: nowrap;
}
.nk-sidebar-version {
    background: rgba(37,99,235,0.2);
    color: #60a5fa; border-radius: 999px;
    padding: 2px 8px; font-weight: 600;
}

/* Mobile overlay */
.nk-sidebar-overlay {
    position: fixed; inset: 0; z-index: 35;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(2px);
}

/* Mobile: full slide in via Alpine open class */
@media (max-width: 1024px) {
    .nk-sidebar-wrapper { width: 260px; }
    .nk-sidebar {
        transform: translateX(-100%);
        box-shadow: none;
    }
    .nk-sidebar-trigger { display: none; }
    .nk-sidebar.open, .nk-sidebar-wrapper.open .nk-sidebar {
        transform: translateX(0);
        box-shadow: 8px 0 40px rgba(0,0,0,0.5);
    }
    .nk-wallet-balance-label { display: none; }
}

/* Content area offset — push main content away from sidebar */
@media (min-width: 1025px) {
    /* Content gets 16px left offset for the trigger strip */
    .nk-main-content { margin-left: 16px !important; }
}

/* Expiration badge */
.exp-badge {
    display: inline-flex; align-items: center;
    padding: 2px 8px; border-radius: 999px;
    font-size: 0.65rem; font-weight: 600; margin-top: 4px;
}
.exp-lifetime { background: rgba(34,197,94,0.15); color: #4ade80; }
.exp-expired  { background: rgba(239,68,68,0.15); color: #f87171; }
.exp-soon     { background: rgba(245,158,11,0.15); color: #fbbf24; }
.exp-ok       { background: rgba(37,99,235,0.15); color: #60a5fa; }
</style>

<div>

    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="nk-sidebar-overlay" style="display:none;"></div>

    {{-- ── TOP BAR ── --}}
    <nav class="nk-nav-topbar">
        <div class="nk-nav-topbar-left">
            {{-- Hamburger --}}
            <button @click="sidebarOpen = !sidebarOpen" class="nk-hamburger" aria-label="Toggle sidebar">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="nk-nav-logo">
                <div class="nk-nav-logo-icon">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="nk-nav-logo-text">Net<span>Key</span></span>
            </a>
        </div>

        {{-- Right section --}}
        <div class="nk-nav-topbar-right">

            {{-- Wallet --}}
            <div class="nk-wallet-badge">
                <span class="nk-wallet-coin">💰</span>
                <span class="nk-wallet-balance">{{ number_format($user->getOrCreateWallet()->balance ?? 0) }}</span>
                <a href="{{ route('products') }}" class="nk-wallet-add" title="Top up">
                    <svg width="10" height="10" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </a>
            </div>

            {{-- Dark mode toggle --}}
            <button class="nk-icon-btn" id="nk-theme-toggle" title="Toggle dark mode">
                <span id="nk-icon-sun">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="5"/>
                        <path stroke-linecap="round" d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                </span>
                <span id="nk-icon-moon" style="display:none">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </span>
            </button>

            {{-- Notifications --}}
            <div class="relative">
                <button @click="notificationOpen = !notificationOpen; profileOpen = false" class="nk-icon-btn" title="Notifications">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($hasNotifications)
                        <span class="nk-notif-dot">{{ count($notifications) }}</span>
                    @endif
                </button>

                <div x-show="notificationOpen" @click.away="notificationOpen=false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="nk-dropdown" style="display:none;">
                    <div class="nk-dropdown-header">Notifications</div>
                    @forelse($notifications as $notif)
                        <a href="{{ $notif['link'] }}" class="nk-notif-item">
                            <div class="nk-notif-icn">{{ $notif['icon'] }}</div>
                            <div>
                                <p class="nk-notif-title">{{ $notif['title'] }}</p>
                                <p class="nk-notif-msg">{{ $notif['message'] }}</p>
                                <p class="nk-notif-time">{{ $notif['time'] }}</p>
                            </div>
                        </a>
                    @empty
                        <div style="padding:32px;text-align:center;color:#9ca3af;font-size:0.85rem;">
                            <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block;opacity:0.4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            No new notifications
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Profile --}}
            <div class="relative">
                <button @click="profileOpen = !profileOpen; notificationOpen = false" class="nk-profile-btn">
                    <div class="nk-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                    <span class="nk-profile-name hidden sm:block">{{ $user->name }}</span>
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="color:#9ca3af;flex-shrink:0" class="hidden sm:block">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="profileOpen" @click.away="profileOpen=false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="nk-dropdown" style="display:none;width:240px">
                    <div class="nk-profile-header">
                        <p class="nk-profile-uname">{{ $user->name }}</p>
                        <p class="nk-profile-email">{{ $user->email }}</p>
                        <div>
                            @if(!$user->expires_at)
                                <span class="exp-badge exp-lifetime">✓ Lifetime Member</span>
                            @elseif($user->account_status === 'expired' || $user->expires_at->isPast())
                                <span class="exp-badge exp-expired">✕ Expired</span>
                            @elseif($user->expires_at->diffInDays(now()) < 7)
                                <span class="exp-badge exp-soon">⚠ Expires {{ $user->expires_at->diffForHumans() }}</span>
                            @else
                                <span class="exp-badge exp-ok">Exp: {{ $user->expires_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('checkin.index') }}" class="nk-profile-link">
                        <svg width="15" height="15" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Daily Check-in') }}
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nk-profile-link">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ __('Profile Settings') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="nk-profile-logout">
                            <svg width="15" height="15" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── SIDEBAR ── --}}
    {{-- Wrapper: handles hover-reveal on desktop --}}
    <div class="nk-sidebar-wrapper" id="nk-sidebar-wrapper">
        {{-- Thin trigger strip (always visible on desktop) --}}
        <div class="nk-sidebar-trigger" aria-hidden="true"></div>

        <aside class="nk-sidebar" :class="sidebarOpen ? 'open' : ''" id="nk-sidebar">

        {{-- User card --}}
        <div class="nk-sidebar-user">
            <div class="nk-sidebar-avatar">
                {{ strtoupper(substr($user->name, 0, 2)) }}
                <div class="nk-sidebar-avatar-dot"></div>
            </div>
            <div class="nk-sidebar-info">
                <p class="nk-sidebar-name">{{ $user->name }}</p>
                <p class="nk-sidebar-email">{{ $user->email }}</p>
                @if ($user->is_admin)
                    <span class="nk-sidebar-role role-admin">⚡ Admin</span>
                @else
                    <span class="nk-sidebar-role role-user">User</span>
                @endif
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="nk-sidebar-nav">

            {{-- Main Menu --}}
            <div class="nk-nav-section">
                <span class="nk-nav-section-label">{{ __('Main Menu') }}</span>

                <a href="{{ route('dashboard') }}" class="nk-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    {{ __('Home') }}
                </a>

                <a href="{{ route('products') }}" class="nk-nav-link {{ request()->routeIs('products') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    {{ __('Products') }}
                </a>

                <a href="{{ route('wallet.index') }}" class="nk-nav-link {{ request()->routeIs('wallet.index') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    {{ __('My Wallet') }}
                </a>

                <a href="{{ route('transactions.index') }}" class="nk-nav-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('My Transactions') }}
                </a>

                <a href="{{ route('keys.index') }}" class="nk-nav-link {{ request()->routeIs('keys.index') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    {{ __('My Keys') }}
                </a>

                <a href="{{ route('analytics.index') }}" class="nk-nav-link {{ request()->routeIs('analytics.index') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    {{ __('Analytics') }}
                </a>

                <a href="{{ route('settings.index') }}" class="nk-nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ __('Settings') }}
                </a>
            </div>

            {{-- Admin Section --}}
            @if (Auth::check() && Auth::user()->is_admin)
            <div class="nk-nav-section">
                <span class="nk-nav-section-label">{{ __('Administration') }}</span>

                <a href="{{ route('admin.dashboard') }}" class="nk-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    {{ __('Admin Dashboard') }}
                </a>

                <a href="{{ route('admin.users') }}" class="nk-nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    {{ __('User Management') }}
                </a>

                <a href="{{ route('admin.transactions.all-transactions') }}" class="nk-nav-link {{ request()->routeIs('admin.transactions.all-transactions') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    {{ __('All Transactions') }}
                </a>

                <a href="{{ route('admin.keys.index') }}" class="nk-nav-link {{ request()->routeIs('admin.keys.index') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    {{ __('Keys Management') }}
                </a>
            </div>
            @endif

            {{-- Support --}}
            <div class="nk-nav-section">
                <span class="nk-nav-section-label">{{ __('Support') }}</span>

                <a href="{{ route('support.help_center') }}" class="nk-nav-link {{ request()->routeIs('support.help_center') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('Help Center') }}
                </a>

                <a href="{{ route('support.contact') }}" class="nk-nav-link {{ request()->routeIs('support.contact') ? 'active' : '' }}">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ __('Contact Support') }}
                </a>
            </div>
        </nav>

        {{-- Footer --}}
        <div class="nk-sidebar-footer">
            <span>© {{ date('Y') }} NetKey</span>
            <span class="nk-sidebar-version">v2.0.0</span>
        </div>
    </aside>
    </div>{{-- /.nk-sidebar-wrapper --}}

    {{-- Theme + sidebar JS --}}
    <script>
        // ── Theme init (anti-flash) ──
        (function() {
            const theme = localStorage.getItem('nk-theme') || 'light';
            const html = document.documentElement;
            if (theme === 'dark') {
                html.classList.add('dark');
                html.setAttribute('data-theme', 'dark');
            } else {
                html.classList.remove('dark');
                html.setAttribute('data-theme', 'light');
            }
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const btn    = document.getElementById('nk-theme-toggle');
            const sunEl  = document.getElementById('nk-icon-sun');
            const moonEl = document.getElementById('nk-icon-moon');
            const html   = document.documentElement;

            function applyIcons(theme) {
                // User wants Moon icon to represent Dark Mode, Sun for Light Mode
                if (theme === 'dark') {
                    if (sunEl)  sunEl.style.display  = 'none';
                    if (moonEl) moonEl.style.display = 'block';
                } else {
                    if (sunEl)  sunEl.style.display  = 'block';
                    if (moonEl) moonEl.style.display = 'none';
                }
            }

            function applyTheme(theme) {
                if (theme === 'dark') {
                    html.classList.add('dark');
                    html.classList.remove('light');
                } else {
                    html.classList.remove('dark');
                    html.classList.add('light');
                }
                html.setAttribute('data-theme', theme);
                localStorage.setItem('nk-theme', theme);
                applyIcons(theme);
            }

            // Sync with localstorage immediately
            applyTheme(localStorage.getItem('nk-theme') || 'light');

            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Dựa vào class hiện tại để đổi, dùng này sẽ không bị lệch logic
                    const isDark = html.classList.contains('dark');
                    applyTheme(isDark ? 'light' : 'dark');
                });
            }
        });
    </script>

</div>