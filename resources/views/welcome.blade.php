<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NetKey') }} - Smart Management Platform</title>
    <meta name="description"
        content="NetKey - The leading business management platform. Manage users, products, and payments in one unified system.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ secure_asset('build/assets/app-CfAMAoGE.css') }}">
        <script src="{{ secure_asset('build/assets/app-ByAQDGt7.js') }}" defer></script>
    @endif

    <style>
        /* ==============================
           DESIGN SYSTEM - Blue/White/Black
        ============================== */
        :root {
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-300: #93c5fd;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;
            --blue-900: #1e3a8a;
            --navy: #0a0f1e;
            --navy-soft: #0d1629;
            --black: #000000;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--white);
            color: var(--gray-900);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ==============================
           NAVBAR
        ============================== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--gray-200);
            transition: box-shadow 0.3s;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 24px rgba(37, 99, 235, 0.10);
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--blue-600);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-logo-icon svg {
            color: white;
        }

        .nav-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.5px;
        }

        .nav-logo-text span {
            color: var(--blue-600);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            padding: 8px 16px;
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }

        .nav-link:hover {
            color: var(--blue-600);
            background: var(--blue-50);
        }

        .btn-nav-outline {
            padding: 8px 20px;
            border: 1.5px solid var(--blue-600);
            color: var(--blue-600);
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-nav-outline:hover {
            background: var(--blue-600);
            color: white;
        }

        .btn-nav-fill {
            padding: 8px 20px;
            background: var(--blue-600);
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 12px rgba(37, 99, 235, 0.30);
        }

        .btn-nav-fill:hover {
            background: var(--blue-700);
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.40);
        }

        /* ==============================
           HERO & 3D SCROLL
        ============================== */
        .hero {
            padding: 160px 24px 0;
            /* padding bottom removed for 3D element */
            background: var(--white);
            position: relative;
            z-index: 10;
        }

        /* Decorative grid pattern */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            background-image:
                linear-gradient(var(--blue-100) 1px, transparent 1px),
                linear-gradient(90deg, var(--blue-100) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.3;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.6) 0%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.6) 0%, transparent 100%);
            z-index: -1;
        }

        /* Blue glow orb */
        .hero::after {
            content: '';
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 500px;
            background: radial-gradient(ellipse, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
        }

        .hero-inner {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: var(--blue-50);
            border: 1px solid var(--blue-200);
            border-radius: 999px;
            color: var(--blue-700);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            animation: fadeUp 0.8s ease-out;
        }

        .hero-title {
            font-size: clamp(3rem, 7vw, 5.5rem);
            font-weight: 900;
            line-height: 1.1;
            color: var(--gray-900);
            margin-bottom: 24px;
            letter-spacing: -2.5px;
            animation: fadeUp 1s ease-out;
        }

        .hero-title .accent {
            background: linear-gradient(135deg, var(--blue-600) 0%, var(--blue-400) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--gray-500);
            max-width: 700px;
            margin: 0 auto 40px;
            line-height: 1.7;
            animation: fadeUp 1.2s ease-out;
        }

        .hero-subtitle strong {
            color: var(--blue-600);
            font-weight: 600;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 52px;
            flex-wrap: wrap;
            animation: fadeUp 1.4s ease-out;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 36px;
            background: var(--blue-600);
            color: white;
            font-size: 1.05rem;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.25s;
            box-shadow: 0 4px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-primary:hover {
            background: var(--blue-700);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.45);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 36px;
            background: white;
            color: var(--gray-800);
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 12px;
            border: 2px solid var(--gray-200);
            text-decoration: none;
            transition: all 0.25s;
        }

        .btn-secondary:hover {
            border-color: var(--blue-300);
            color: var(--blue-600);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero 3D Showcase Container */
        .showcase-container {
            perspective: 1200px;
            max-width: 1100px;
            margin: 0 auto;
            margin-top: 40px;
            padding: 0 20px;
            z-index: 20;
            position: relative;
        }

        .showcase-image-wrapper {
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05);
            background: var(--white);
            transform: rotateX(15deg) scale(0.95);
            transform-origin: top center;
            transition: transform 0.1s ease-out;
            /* Smooth JS updating */
        }

        .showcase-img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 20px;
        }

        /* Mockup Top Bar */
        .mockup-bar {
            background: var(--gray-100);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid var(--gray-200);
        }

        .mockup-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .mockup-dot.red {
            background: #ff5f56;
        }

        .mockup-dot.yellow {
            background: #ffbd2e;
        }

        .mockup-dot.green {
            background: #27c93f;
        }

        /* ==============================
           SECTION SHARED
        ============================== */
        .section-label {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--blue-600);
            margin-bottom: 16px;
        }

        .section-title {
            font-size: clamp(2rem, 4.5vw, 3rem);
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -1.5px;
            margin-bottom: 24px;
        }

        .section-sub {
            font-size: 1.15rem;
            color: var(--gray-500);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ==============================
           FEATURES
        ============================== */
        .features {
            padding: 140px 24px 100px;
            background: var(--gray-50);
            position: relative;
            z-index: 5;
        }

        .features-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .features-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 32px;
        }

        .feature-card {
            background: white;
            border-radius: 24px;
            padding: 40px 32px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--blue-600);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            border-color: var(--blue-200);
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.1);
            transform: translateY(-4px);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--blue-600) 0%, var(--blue-400) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            transition: transform 0.3s;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-5deg);
        }

        .feature-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .feature-desc {
            color: var(--gray-500);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            color: var(--gray-700);
            font-weight: 500;
        }

        .feature-list li::before {
            content: '';
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            background: var(--blue-50);
            border: 1.5px solid var(--blue-300);
            border-radius: 50%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' fill='none' stroke='%232563eb' stroke-width='2'%3E%3Cpath d='M2 6l3 3 5-5'/%3E%3C/svg%3E");
            background-size: 12px;
            background-repeat: no-repeat;
            background-position: center;
        }

        /* ==============================
           STATS
        ============================== */
        .stats {
            padding: 100px 24px;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }

        .stats::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 400px;
            background: radial-gradient(ellipse, rgba(37, 99, 235, 0.25) 0%, transparent 70%);
        }

        .stats-inner {
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }

        .stat-item {}

        .stat-num {
            font-size: 3.5rem;
            font-weight: 900;
            color: white;
            letter-spacing: -2px;
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-num span {
            color: var(--blue-400);
        }

        .stat-label {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .stat-divider {
            font-size: 0.6rem;
            letter-spacing: 5px;
            display: block;
            margin-top: 12px;
            color: var(--blue-600);
        }

        /* ==============================
           TESTIMONIALS
        ============================== */
        .testimonials {
            padding: 140px 24px;
            background: white;
        }

        .testimonials-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .testimonials-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 32px;
        }

        .testimonial-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 24px;
            padding: 40px;
            transition: all 0.3s;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .testimonial-card:hover {
            border-color: var(--blue-200);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.08);
            transform: translateY(-4px);
        }

        .quote-icon {
            font-size: 4rem;
            line-height: 0.5;
            color: var(--blue-100);
            font-family: Georgia, serif;
            margin-bottom: 24px;
            display: block;
        }

        .stars {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
        }

        .star {
            color: #f59e0b;
            font-size: 1.2rem;
        }

        .testimonial-text {
            color: var(--gray-700);
            font-size: 1.05rem;
            line-height: 1.8;
            margin-bottom: 32px;
            font-style: italic;
            font-weight: 500;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .author-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--blue-600);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .author-name {
            font-weight: 800;
            color: var(--gray-900);
            font-size: 0.95rem;
        }

        .author-role {
            color: var(--gray-500);
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ==============================
           CTA SECTION
        ============================== */
        .cta-section {
            padding: 120px 24px;
            background: var(--navy);
            text-align: center;
            position: relative;
            overflow: hidden;
            margin: 0 24px 24px;
            border-radius: 32px;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 400px;
            background: radial-gradient(ellipse, rgba(37, 99, 235, 0.35) 0%, transparent 70%);
            z-index: 0;
        }

        .cta-inner {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            z-index: 2;
        }

        .cta-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900;
            color: white;
            letter-spacing: -2px;
            margin-bottom: 24px;
            line-height: 1.1;
        }

        .cta-title .accent {
            color: var(--blue-400);
        }

        .cta-sub {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.25rem;
            margin-bottom: 48px;
            max-width: 600px;
            margin-inline: auto;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 20px 48px;
            background: var(--blue-500);
            color: white;
            font-size: 1.15rem;
            font-weight: 800;
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.25s;
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.4);
        }

        .btn-cta:hover {
            background: var(--blue-400);
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.5);
        }

        .btn-cta-ghost {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 20px 48px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 1.15rem;
            font-weight: 700;
            border-radius: 16px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            text-decoration: none;
            transition: all 0.25s;
        }

        .btn-cta-ghost:hover {
            border-color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .cta-btns {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* ==============================
           FOOTER
        ============================== */
        .footer {
            background: var(--white);
            padding: 60px 24px 40px;
            text-align: center;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            text-decoration: none;
        }

        .footer-logo-icon {
            width: 32px;
            height: 32px;
            background: var(--blue-600);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-logo-text {
            color: var(--gray-900);
            font-weight: 900;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
        }

        .footer-logo-text span {
            color: var(--blue-600);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }

        .footer-links a {
            color: var(--gray-500);
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }

        .footer-links a:hover {
            color: var(--blue-600);
            background: var(--blue-50);
        }

        .footer-copy {
            color: var(--gray-400);
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ==============================
           RESPONSIVE
        ============================== */
        @media (max-width: 900px) {
            .stats-inner {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero {
                padding-top: 140px;
            }

            .cta-section {
                margin: 0 16px 16px;
                border-radius: 24px;
                padding: 80px 20px;
            }
        }

        @media (max-width: 600px) {
            .stats-inner {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .hero-cta {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .nav-actions .btn-nav-outline {
                display: none;
            }

            .cta-btns {
                flex-direction: column;
                align-items: stretch;
            }

            .showcase-container {
                padding: 0 10px;
            }
        }

        /* ==============================
           ANIMATIONS
        ============================== */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <!-- ░░░   NAVBAR   ░░░ -->
    <nav class="navbar" id="mainNav">
        <div class="nav-inner">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                        style="color:white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="nav-logo-text">Net<span>Key</span></span>
            </a>

            <!-- Actions -->
            @if (Route::has('login'))
                <div class="nav-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav-fill">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-nav-fill">Sign up free →</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- ░░░   HERO   ░░░ -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge">
                <svg fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                The #1 Management Platform
            </div>

            <h1 class="hero-title">
                Manage your business<br>
                <span class="accent">much smarter</span>
            </h1>

            <p class="hero-subtitle">
                Streamline workflows, manage users, and process payments securely —
                <strong>all in one unified platform</strong> designed for modern teams.
            </p>

            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn-primary">
                    Start for Free
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="#features" class="btn-secondary">
                    View Features
                </a>
            </div>

            <div
                style="display: flex; justify-content: center; align-items: center; gap: 24px; color: var(--gray-500); font-weight: 600; font-size: 0.9rem; animation: fadeUp 1.6s ease-out;">
                <span style="display: flex; align-items: center; gap: 6px;">
                    <svg width="18" height="18" fill="none" stroke="var(--blue-500)" stroke-width="3"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    30-day Free Trial
                </span>
                <span style="display: flex; align-items: center; gap: 6px;">
                    <svg width="18" height="18" fill="none" stroke="var(--blue-500)" stroke-width="3"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    No Credit Card Required
                </span>
            </div>
        </div>

        <!-- 3D Scroll Showcase -->
        <div class="showcase-container fade-up" style="animation-delay: 0.5s;">
            <div class="showcase-image-wrapper" id="showcaseImage" style="position: relative;">
                <div class="mockup-bar">
                    <div class="mockup-dot red"></div>
                    <div class="mockup-dot yellow"></div>
                    <div class="mockup-dot green"></div>
                    <div style="margin-left: 12px; font-family: monospace; font-size: 0.8rem; color: #9ca3af;">
                        dashboard.netkey.com</div>
                </div>
                <img src="{{ asset('images/showcase/1-user-dashboard.png') }}" id="showcase-slide"
                    alt="NetKey Dashboard Mockup" class="showcase-img" style="transition: opacity 0.5s ease-in-out;">

                <div class="showcase-dots" id="showcase-dots"></div>
            </div>
        </div>

        <style>
            .showcase-dots {
                position: absolute;
                bottom: 24px;
                left: 0;
                right: 0;
                display: flex;
                gap: 8px;
                z-index: 10;
                flex-wrap: wrap;
                justify-content: center;
                padding: 0 20px;
            }

            .showcase-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.5);
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            }

            .showcase-dot.active {
                background: #2563eb;
                border-color: #2563eb;
                transform: scale(1.3);
            }

            .showcase-dot:hover {
                background: rgba(37, 99, 235, 0.8);
            }

            .dark .showcase-dot {
                background: rgba(255, 255, 255, 0.3);
                border-color: rgba(255, 255, 255, 0.2);
            }

            .dark .showcase-dot.active {
                background: #60a5fa;
                border-color: #60a5fa;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const images = [
                    "{{ asset('images/showcase/1-user-dashboard.png') }}",
                    "{{ asset('images/showcase/2-admin-dashboard.png') }}",
                    "{{ asset('images/showcase/3-wallet.png') }}",
                    "{{ asset('images/showcase/4-products.png') }}",
                    "{{ asset('images/showcase/5-my-keys.png') }}",
                    "{{ asset('images/showcase/6-user-transactions.png') }}",
                    "{{ asset('images/showcase/7-manage-keys.png') }}",
                    "{{ asset('images/showcase/8-manage-users.png') }}",
                    "{{ asset('images/showcase/9-all-transactions.png') }}",
                    "{{ asset('images/showcase/10-analytics.png') }}",
                    "{{ asset('images/showcase/11-user-dashboard-dark.png') }}",
                    "{{ asset('images/showcase/12-admin-dashboard-dark.png') }}",
                    "{{ asset('images/showcase/13-wallet-dark.png') }}",
                    "{{ asset('images/showcase/14-products-dark.png') }}",
                    "{{ asset('images/showcase/15-my-keys-dark.png') }}",
                    "{{ asset('images/showcase/16-user-transactions-dark.png') }}",
                    "{{ asset('images/showcase/17-manage-keys-dark.png') }}",
                    "{{ asset('images/showcase/18-manage-users-dark.png') }}",
                    "{{ asset('images/showcase/19-all-transactions-dark.png') }}",
                    "{{ asset('images/showcase/20-analytics-dark.png') }}"
                ];
                let currentIndex = 0;
                let autoSlideInterval;
                let interactionTimeout;
                const showcaseImg = document.getElementById('showcase-slide');
                const dotsContainer = document.getElementById('showcase-dots');
                let dots = [];

                // Initialize dots
                images.forEach((_, index) => {
                    const dot = document.createElement('div');
                    dot.classList.add('showcase-dot');
                    if (index === 0) dot.classList.add('active');

                    dot.addEventListener('click', () => {
                        goToImage(index);
                        resetInteractionTimer();
                    });

                    dotsContainer.appendChild(dot);
                    dots.push(dot);
                });

                function updateDots() {
                    dots.forEach((dot, index) => {
                        if (index === currentIndex) {
                            dot.classList.add('active');
                        } else {
                            dot.classList.remove('active');
                        }
                    });
                }

                function showImage(index) {
                    currentIndex = index;
                    showcaseImg.style.opacity = 0;
                    setTimeout(() => {
                        showcaseImg.src = images[currentIndex];
                        showcaseImg.style.opacity = 1;
                        updateDots();
                    }, 500); // Wait for fade out to complete
                }

                function goToImage(index) {
                    if (index === currentIndex) return;
                    showImage(index);
                }

                function nextImage() {
                    const nextIndex = (currentIndex + 1) % images.length;
                    showImage(nextIndex);
                }

                function startAutoSlide() {
                    clearInterval(autoSlideInterval);
                    autoSlideInterval = setInterval(nextImage, 4000);
                }

                function resetInteractionTimer() {
                    clearInterval(autoSlideInterval);
                    clearTimeout(interactionTimeout);
                    interactionTimeout = setTimeout(() => {
                        startAutoSlide();
                    }, 10000); // 10 seconds of inactivity before auto sliding resumes
                }

                // Initial start
                startAutoSlide();
            });
        </script>
    </section>

    <!-- ░░░   FEATURES   ░░░ -->
    <section id="features" class="features">
        <div class="features-inner">
            <div class="features-header fade-up">
                <div class="section-label">Features</div>
                <h2 class="section-title">Everything You Need</h2>
                <p class="section-sub">Carefully crafted tools to help your business operate and scale effortlessly.</p>
            </div>

            <div class="features-grid">
                <!-- Card 1 -->
                <div class="feature-card fade-up">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">User Management</h3>
                    <p class="feature-desc">Intuitive dashboard with flexible roles, permissions, and real-time smart
                        search.</p>
                    <ul class="feature-list">
                        <li>Quick Filter & Search</li>
                        <li>Bulk Actions</li>
                        <li>Granular Role Management</li>
                    </ul>
                </div>

                <!-- Card 2 -->
                <div class="feature-card fade-up">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Advanced Analytics</h3>
                    <p class="feature-desc">Detailed analytics charts, growth tracking, and automated report generation.
                    </p>
                    <ul class="feature-list">
                        <li>Interactive Charts</li>
                        <li>Growth Metrics</li>
                        <li>Export PDF/Excel</li>
                    </ul>
                </div>

                <!-- Card 3 -->
                <div class="feature-card fade-up">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">PayOS Integration</h3>
                    <p class="feature-desc">Seamless and secure payment processing integrated directly with PayOS.</p>
                    <ul class="feature-list">
                        <li>SSL Encrypted</li>
                        <li>Bank Transfer & Cards</li>
                        <li>Instant Processing</li>
                    </ul>
                </div>

                <!-- Card 4 -->
                <div class="feature-card fade-up">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Product Catalog</h3>
                    <p class="feature-desc">Manage your digital products with flexible categorization and elegant
                        storefronts.</p>
                    <ul class="feature-list">
                        <li>Dynamic Categories</li>
                        <li>Rich Media Support</li>
                        <li>Inventory Tracking</li>
                    </ul>
                </div>

                <!-- Card 5 -->
                <div class="feature-card fade-up">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">High Security</h3>
                    <p class="feature-desc">Two-factor authentication, data encryption, and secure session management.
                    </p>
                    <ul class="feature-list">
                        <li>2FA Authenticator</li>
                        <li>Data Encryption</li>
                        <li>Activity Logging</li>
                    </ul>
                </div>

                <!-- Card 6 -->
                <div class="feature-card fade-up">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">License Key Manager</h3>
                    <p class="feature-desc">Automated generation and verification of unique license keys for software
                        distribution.</p>
                    <ul class="feature-list">
                        <li>Auto-generation</li>
                        <li>Expiration Tracking</li>
                        <li>API Verification</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ░░░   STATS   ░░░ -->
    <section class="stats">
        <div class="stats-inner">
            <div class="stat-item fade-up">
                <div class="stat-num">15K<span>+</span></div>
                <div class="stat-label">Active Users</div>
                <span class="stat-divider">— — —</span>
            </div>
            <div class="stat-item fade-up">
                <div class="stat-num">99<span>.9%</span></div>
                <div class="stat-label">Uptime</div>
                <span class="stat-divider">— — —</span>
            </div>
            <div class="stat-item fade-up">
                <div class="stat-num">24<span>/7</span></div>
                <div class="stat-label">Support</div>
                <span class="stat-divider">— — —</span>
            </div>
            <div class="stat-item fade-up">
                <div class="stat-num">4<span>.9★</span></div>
                <div class="stat-label">Rating</div>
                <span class="stat-divider">— — —</span>
            </div>
        </div>
    </section>

    <!-- ░░░   TESTIMONIALS   ░░░ -->
    <section class="testimonials">
        <div class="testimonials-inner">
            <div class="testimonials-header fade-up">
                <div class="section-label">Testimonials</div>
                <h2 class="section-title">What Our Clients Say</h2>
                <p class="section-sub">Trusted by over 10,000 businesses worldwide every day.</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card fade-up">
                    <span class="quote-icon">"</span>
                    <div class="stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span
                            class="star">★</span><span class="star">★</span>
                    </div>
                    <p class="testimonial-text">"NetKey is an incredible platform! It saves our company up to 70% of
                        management time. Beautiful interface, easy to adopt, and fantastic support."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">J</div>
                        <div>
                            <div class="author-name">James Anderson</div>
                            <div class="author-role">CEO, Tech Startup</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-up">
                    <span class="quote-icon">"</span>
                    <div class="stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span
                            class="star">★</span><span class="star">★</span>
                    </div>
                    <p class="testimonial-text">"The built-in analytics dashboard is exceptionally detailed. I can track
                        everything in real-time. Absolutely worth every penny!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">S</div>
                        <div>
                            <div class="author-name">Sarah Jenkins</div>
                            <div class="author-role">Marketing Director</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card fade-up">
                    <span class="quote-icon">"</span>
                    <div class="stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span
                            class="star">★</span><span class="star">★</span>
                    </div>
                    <p class="testimonial-text">"The secure payment integration is buttery smooth. Customers check out
                        quickly, and our revenue has jumped 150% in just three months."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">M</div>
                        <div>
                            <div class="author-name">Michael Lee</div>
                            <div class="author-role">E-commerce Owner</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ░░░   CTA   ░░░ -->
    <section class="cta-section" data-aos="zoom-in">
        <div class="cta-inner">
            <h2 class="cta-title">Ready to <span class="accent">transform</span><br>your business?</h2>
            <p class="cta-sub">Join thousands of companies scaling effortlessly with our unified infrastructure.</p>
            <div class="cta-btns">
                <a href="{{ route('register') }}" class="btn-cta">
                    Start 30-Day Free Trial
                </a>
                <a href="{{ route('login') }}" class="btn-cta-ghost">Sign In Now</a>
            </div>
        </div>
    </section>

    <!-- ░░░   FOOTER   ░░░ -->
    <footer class="footer">
        <div class="footer-inner">
            <a href="{{ url('/') }}" class="footer-logo">
                <div class="footer-logo-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                        style="color:white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="footer-logo-text">Net<span>Key</span></span>
            </a>
            <div class="footer-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="#features">Features</a>
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Sign up</a>
                @endif
            </div>
            <p class="footer-copy">© {{ date('Y') }} {{ config('app.name', 'NetKey') }}. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 20);
        });

        // 3D Scroll Effect on Hero Mockup
        const showcase = document.getElementById('showcaseImage');
        window.addEventListener('scroll', () => {
            if (!showcase) return;
            const scrollPercent = window.scrollY / (window.innerHeight * 0.8);
            if (scrollPercent < 1.5) {
                // Animate rotateX from 15deg to 0deg, scale from 0.95 to 1.05
                const maxRotate = 15;
                const minScale = 0.95;
                const maxScale = 1.05;

                // Map scroll progress to transform values
                // Cap progress at 1 for the transform calculation
                const progress = Math.min(scrollPercent, 1);

                const rotate = Math.max(0, maxRotate * (1 - progress * 1.5));
                const scale = minScale + (maxScale - minScale) * progress;

                showcase.style.transform = `rotateX(${rotate}deg) scale(${scale})`;
            }
        });

        // Fade-up Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, i * 80); // Stagger
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>

</body>

</html>