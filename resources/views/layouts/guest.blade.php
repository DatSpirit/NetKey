<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

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

    <style>
        /* ══════════════════════════════════════
           NETKEY DESIGN SYSTEM — GUEST LAYOUT
        ══════════════════════════════════════ */
        :root {
            --nk-blue:       #2563eb;
            --nk-blue-dark:  #1d4ed8;
            --nk-blue-50:    #eff6ff;
            --nk-blue-100:   #dbeafe;
            --nk-blue-400:   #60a5fa;
            --nk-navy:       #0a0f1e;
            --nk-navy-soft:  #0d1629;
            --nk-black:      #000000;
            --nk-white:      #ffffff;
            --nk-gray-50:    #f9fafb;
            --nk-gray-100:   #f3f4f6;
            --nk-gray-200:   #e5e7eb;
            --nk-gray-300:   #d1d5db;
            --nk-gray-400:   #9ca3af;
            --nk-gray-500:   #6b7280;
            --nk-gray-600:   #4b5563;
            --nk-gray-700:   #374151;
            --nk-gray-800:   #1f2937;
            --nk-gray-900:   #111827;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0; padding: 0;
            background: var(--nk-gray-50);
            color: var(--nk-gray-900);
            min-height: 100vh;
            display: flex;
        }

        /* ── LEFT PANEL ── */
        .guest-left {
            width: 480px;
            min-height: 100vh;
            background: var(--nk-navy);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 48px 40px;
            overflow: hidden;
        }

        /* Grid background pattern */
        .guest-left::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(37,99,235,0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37,99,235,0.1) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Blue glow orb */
        .guest-left::after {
            content: '';
            position: absolute;
            bottom: 0; right: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(37,99,235,0.25) 0%, transparent 65%);
            border-radius: 50%;
        }

        .guest-left-content { position: relative; z-index: 1; }

        .guest-logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; margin-bottom: 64px;
        }
        .guest-logo-icon {
            width: 42px; height: 42px;
            background: var(--nk-blue);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .guest-logo-icon svg { color: white; }
        .guest-logo-text {
            font-size: 1.5rem; font-weight: 800;
            color: white; letter-spacing: -0.5px;
        }
        .guest-logo-text span { color: var(--nk-blue-400); }

        .guest-headline {
            font-size: 2.4rem;
            font-weight: 900;
            color: white;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .guest-headline span { color: var(--nk-blue-400); }

        .guest-tagline {
            color: rgba(255,255,255,0.5);
            font-size: 0.95rem;
            line-height: 1.7;
            max-width: 340px;
            margin-bottom: 48px;
        }

        .guest-features { display: flex; flex-direction: column; gap: 16px; }
        .guest-feature {
            display: flex; align-items: center; gap: 14px;
        }
        .guest-feature-dot {
            width: 32px; height: 32px; flex-shrink: 0;
            background: rgba(37,99,235,0.2);
            border: 1px solid rgba(37,99,235,0.4);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .guest-feature-dot svg { width: 15px; height: 15px; color: var(--nk-blue-400); }
        .guest-feature span {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
        }

        .guest-footer-text {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.25);
        }

        /* ── RIGHT PANEL ── */
        .guest-right {
            margin-left: 480px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
            background: var(--nk-white);
        }

        .guest-form-box {
            width: 100%;
            max-width: 420px;
        }

        .guest-form-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--nk-gray-900);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        .guest-form-subtitle {
            font-size: 0.875rem;
            color: var(--nk-gray-500);
            margin-bottom: 32px;
        }

        /* Form controls override */
        .guest-form-box label {
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: var(--nk-gray-700) !important;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .guest-form-box input[type="email"],
        .guest-form-box input[type="text"],
        .guest-form-box input[type="password"] {
            border-radius: 10px !important;
            border-color: var(--nk-gray-200) !important;
            font-size: 0.95rem !important;
            padding: 11px 14px !important;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .guest-form-box input:focus {
            border-color: var(--nk-blue) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12) !important;
            outline: none !important;
        }

        .guest-form-box .nk-submit-btn {
            width: 100%;
            padding: 12px 24px;
            background: var(--nk-blue);
            color: white;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.2px;
            margin-top: 8px;
        }
        .guest-form-box .nk-submit-btn:hover {
            background: var(--nk-blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(37,99,235,0.3);
        }

        a.nk-link {
            color: var(--nk-blue);
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
        }
        a.nk-link:hover { text-decoration: underline; }

        /* Override primary button component */
        .guest-form-box [type="submit"],
        .guest-form-box button[type="submit"] {
            background: var(--nk-blue) !important;
            border-color: var(--nk-blue) !important;
            border-radius: 10px !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 700 !important;
            transition: all 0.2s !important;
        }
        .guest-form-box [type="submit"]:hover,
        .guest-form-box button[type="submit"]:hover {
            background: var(--nk-blue-dark) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(37,99,235,0.3);
        }

        /* Divider */
        .form-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0;
        }
        .form-divider-line { flex: 1; height: 1px; background: var(--nk-gray-200); }
        .form-divider-text { font-size: 0.75rem; color: var(--nk-gray-400); font-weight: 500; }

        /* Checkbox reskin */
        .guest-form-box input[type="checkbox"] {
            accent-color: var(--nk-blue);
            width: 15px; height: 15px;
            border-radius: 4px;
        }

        /* Responsive: hide left panel on small screens */
        @media (max-width: 900px) {
            .guest-left { display: none; }
            .guest-right { margin-left: 0; }
        }
    </style>
</head>

<body>
    <!-- Left decorative panel -->
    <aside class="guest-left">
        <div class="guest-left-content">
            <a href="/" class="guest-logo">
                <div class="guest-logo-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="guest-logo-text">Net<span>Key</span></span>
            </a>

            <h1 class="guest-headline">
                Smart platform<br>for <span>business</span><br>management
            </h1>
            <p class="guest-tagline">
                Manage users, licenses, transactions and analytics — all in one unified platform built for modern teams.
            </p>

            <div class="guest-features">
                <div class="guest-feature">
                    <div class="guest-feature-dot">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span>Enterprise-grade security & 2FA</span>
                </div>
                <div class="guest-feature">
                    <div class="guest-feature-dot">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span>Real-time analytics dashboard</span>
                </div>
                <div class="guest-feature">
                    <div class="guest-feature-dot">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span>Integrated PayOS payment gateway</span>
                </div>
                <div class="guest-feature">
                    <div class="guest-feature-dot">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <span>Automated license key management</span>
                </div>
            </div>
        </div>

        <p class="guest-footer-text">© {{ date('Y') }} NetKey. All rights reserved.</p>
    </aside>

    <!-- Right form panel -->
    <main class="guest-right">
        <div class="guest-form-box">
            {{ $slot }}
        </div>
    </main>
</body>

</html>