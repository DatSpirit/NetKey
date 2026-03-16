<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-root">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NetKey') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ secure_asset('build/assets/app-CfAMAoGE.css') }}">
        <script src="{{ secure_asset('build/assets/app-ByAQDGt7.js') }}" defer></script>
    @endif

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Apply theme BEFORE render to prevent flash -->
    <script>
        (function() {
            const theme = localStorage.getItem('nk-theme') || 'light';
            document.documentElement.classList.add(theme === 'dark' ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <style>
        /* ══════════════════════════════════════
           NETKEY DESIGN SYSTEM — APP LAYOUT
        ══════════════════════════════════════ */
        :root {
            --nk-blue:      #2563eb;
            --nk-blue-dark: #1d4ed8;
            --nk-blue-50:   #eff6ff;
            --nk-blue-100:  #dbeafe;
            --nk-blue-400:  #60a5fa;
            --nk-blue-600:  #2563eb;
            --nk-navy:      #0a0f1e;
            --nk-black:     #000000;
            --nk-white:     #ffffff;
            --nk-gray-50:   #f9fafb;
            --nk-gray-100:  #f3f4f6;
            --nk-gray-200:  #e5e7eb;
            --nk-gray-400:  #9ca3af;
            --nk-gray-500:  #6b7280;
            --nk-gray-600:  #4b5563;
            --nk-gray-700:  #374151;
            --nk-gray-800:  #1f2937;
            --nk-gray-900:  #111827;

            /* Semantic tokens — light mode */
            --bg:           var(--nk-gray-50);
            --bg-card:      var(--nk-white);
            --bg-elevated:  var(--nk-white);
            --fg:           var(--nk-gray-900);
            --fg-muted:     var(--nk-gray-500);
            --border:       var(--nk-gray-200);
            --accent:       var(--nk-blue);
            --accent-light: var(--nk-blue-50);
        }

        /* Dark mode tokens */
        .dark {
            --bg:           #0d1117;
            --bg-card:      #161b22;
            --bg-elevated:  #21262d;
            --fg:           #e6edf3;
            --fg-muted:     #8b949e;
            --border:       #30363d;
            --accent:       #60a5fa;
            --accent-light: rgba(96,165,250,0.1);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--fg);
            transition: background 0.2s, color 0.2s;
            min-height: 100vh;
        }

        /* ─── TOPBAR ─── */
        /* Note: The actual topbar structure is inside main-navigation.blade.php.
           Here we only define layout-level variables if needed. */
        .nk-topbar {
            display: none; /* Removed hardcoded topbar in favor of main-navigation component */
        }

        .nk-topbar-left {
            display: flex; align-items: center; gap: 12px;
        }

        .nk-page-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--fg);
        }

        .nk-topbar-right {
            display: flex; align-items: center; gap: 10px;
        }

        /* Dark mode toggle */
        .nk-theme-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--fg-muted);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .nk-theme-btn:hover {
            background: var(--accent-light);
            color: var(--accent);
            border-color: var(--accent);
        }
        .nk-theme-btn .icon-light { display: block; }
        .nk-theme-btn .icon-dark  { display: none; }
        .dark .nk-theme-btn .icon-light { display: none; }
        .dark .nk-theme-btn .icon-dark  { display: block; }

        /* ─── PAGE CONTENT ─── */
        .nk-content {
            padding-top: 60px;
            padding-left: 0; /* content fills full width; sidebar is an overlay */
            min-height: 100vh;
            background: var(--bg);
            transition: background 0.2s;
        }

        .nk-page-header {
            background: var(--bg-elevated);
            border-bottom: 1px solid var(--border);
            padding: 20px 32px;
            transition: background 0.2s, border 0.2s;
        }

        .nk-page-body {
            padding: 28px 32px;
        }

        /* Shift content when sidebar is toggled via hamburger */
        .nk-content.sidebar-pushed {
            padding-left: 260px;
        }

        /* Responsive: on mobile, don't push content, just overlay */
        @media (max-width: 1024px) {
            .nk-content.sidebar-pushed {
                padding-left: 0;
            }
        }
        /* ─── CARDS ─── */
        .nk-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            transition: background 0.2s, border 0.2s;
        }

        /* ─── TABLES ─── */
        .nk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        .nk-table thead th {
            background: var(--bg-elevated);
            color: var(--fg-muted);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }
        .nk-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--fg);
        }
        .nk-table tbody tr:last-child td { border-bottom: none; }
        .nk-table tbody tr:hover td { background: var(--accent-light); }

        /* ─── BADGES ─── */
        .nk-badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .nk-badge-blue  { background: var(--accent-light); color: var(--accent); }
        .nk-badge-green { background: #dcfce7; color: #15803d; }
        .nk-badge-red   { background: #fee2e2; color: #dc2626; }
        .nk-badge-gray  { background: var(--bg-elevated); color: var(--fg-muted); border: 1px solid var(--border); }
        .dark .nk-badge-green { background: rgba(21,128,61,0.2); color: #4ade80; }
        .dark .nk-badge-red   { background: rgba(220,38,38,0.2); color: #f87171; }

        /* ─── BUTTONS ─── */
        .nk-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px;
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }
        .nk-btn-primary {
            background: var(--nk-blue);
            color: white;
        }
        .nk-btn-primary:hover {
            background: var(--nk-blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(37,99,235,0.35);
        }
        .nk-btn-ghost {
            background: transparent;
            color: var(--fg-muted);
            border: 1px solid var(--border);
        }
        .nk-btn-ghost:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
        }
        .nk-btn-danger {
            background: transparent;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .nk-btn-danger:hover {
            background: #fee2e2;
        }
        .dark .nk-btn-danger {
            border-color: rgba(220,38,38,0.3);
            color: #f87171;
        }
        .dark .nk-btn-danger:hover { background: rgba(220,38,38,0.1); }

        /* ─── INPUTS ─── */
        .nk-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--bg-card);
            color: var(--fg);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .nk-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .nk-input::placeholder { color: var(--fg-muted); }

        /* ─── TOAST ─── */
        #toast-container {
            position: fixed; top: 72px; right: 16px;
            z-index: 200;
            display: flex; flex-direction: column; gap: 10px;
        }
        .nk-toast {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--bg-elevated);
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--fg);
            transform: translateX(120%);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            max-width: 360px;
        }
        .nk-toast.show { transform: translateX(0); opacity: 1; }
        .nk-toast-success { border-left: 3px solid #22c55e; }
        .nk-toast-error   { border-left: 3px solid #ef4444; }
        .nk-toast-warning { border-left: 3px solid #f59e0b; }
        .nk-toast-info    { border-left: 3px solid var(--accent); }

        .nk-section-label {
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--fg-muted); margin-bottom: 8px;
        }
    </style>

    @stack('styles')
</head>

<body x-data="{ sidebarOpen: false, notificationOpen: false, profileOpen: false }" 
      @keydown.escape.window="sidebarOpen=false;notificationOpen=false;profileOpen=false"
      class="antialiased">

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <!-- Navigation (sidebar + topbar) -->
    <x-main-navigation />

    <!-- Main content -->
    <div class="nk-content" :class="sidebarOpen ? 'sidebar-pushed' : ''">
        @isset($header)
            <div class="nk-page-header">{{ $header }}</div>
        @endisset

        <main class="nk-page-body">
            {{ $slot }}
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // ── Removed redundant dark mode script ──

        // ── Toast Notifications ──
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const icons = {
                success: '<svg width="18" height="18" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                error:   '<svg width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                warning: '<svg width="18" height="18" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                info:    '<svg width="18" height="18" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            };

            const toast = document.createElement('div');
            toast.className = `nk-toast nk-toast-${type}`;
            toast.innerHTML = `
                <div>${icons[type]}</div>
                <p style="flex:1;margin:0">${message}</p>
                <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:var(--fg-muted);padding:0;display:flex;align-items:center">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            container.appendChild(toast);

            requestAnimationFrame(() => {
                requestAnimationFrame(() => toast.classList.add('show'));
            });

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Display Laravel Flash Messages
        @if(session('success'))
            showToast("{{ addslashes(session('success')) }}", 'success');
        @endif
        @if(session('error'))
            showToast("{{ addslashes(session('error')) }}", 'error');
        @endif
        @if(session('warning'))
            showToast("{{ addslashes(session('warning')) }}", 'warning');
        @endif
        @if(session('info'))
            showToast("{{ addslashes(session('info')) }}", 'info');
        @endif
    </script>

    @stack('scripts')
</body>

</html>