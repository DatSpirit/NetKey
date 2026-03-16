<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'NetKey') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Standalone CSS for Error Pages -->
    <style>
        :root {
            --nk-blue: #2563eb;
            --nk-blue-dark: #1d4ed8;
            --nk-navy: #0a0f1e;
            --nk-white: #ffffff;
            --nk-gray-50: #f9fafb;
            --nk-gray-200: #e5e7eb;
            --nk-gray-400: #9ca3af;
            --nk-gray-500: #6b7280;
            --nk-gray-800: #1f2937;
            --nk-gray-900: #111827;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --nk-gray-50: #111827;
                --nk-gray-200: #374151;
                --nk-gray-500: #9ca3af;
                --nk-gray-800: #f3f4f6;
                --nk-gray-900: #ffffff;
                --nk-white: #1f2937;
            }
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--nk-gray-50);
            color: var(--nk-gray-900);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Decorative Backgrounds */
        .decoration-1 {
            position: absolute;
            top: -10vh;
            left: -10vw;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .decoration-2 {
            position: absolute;
            bottom: -20vh;
            right: -10vw;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(10, 15, 30, 0.05) 0%, transparent 60%);
            border-radius: 50%;
            z-index: 0;
        }

        @media (prefers-color-scheme: dark) {
            .decoration-2 {
                background: radial-gradient(circle, rgba(255, 255, 255, 0.02) 0%, transparent 60%);
            }
        }

        /* Main Container */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 600px;
            padding: 40px 20px;
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo Icon */
        .logo-icon {
            width: 56px;
            height: 56px;
            background: var(--nk-blue);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 32px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            color: #ffffff;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, var(--nk-navy) 0%, var(--nk-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
            letter-spacing: -4px;
        }

        @media (prefers-color-scheme: dark) {
            .error-code {
                background: linear-gradient(135deg, #ffffff 0%, var(--nk-blue) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        }

        .error-message {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--nk-gray-800);
            margin-bottom: 16px;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .error-description {
            font-size: 1rem;
            font-weight: 500;
            color: var(--nk-gray-500);
            margin-bottom: 40px;
            line-height: 1.6;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Action Buttons */
        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .btn-primary {
            background-color: var(--nk-blue);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--nk-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background-color: var(--nk-white);
            color: var(--nk-gray-800);
            border-color: var(--nk-gray-200);
        }

        .btn-secondary:hover {
            background-color: var(--nk-gray-50);
            border-color: var(--nk-blue);
            color: var(--nk-blue);
        }

        .btn svg {
            width: 18px;
            height: 18px;
            margin-right: 8px;
        }

        /* Footer */
        .footer {
            margin-top: 60px;
            font-size: 0.8rem;
            color: var(--nk-gray-400);
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="decoration-1"></div>
    <div class="decoration-2"></div>

    <div class="container">
        <!-- Logo -->
        <a href="{{ url('/') }}" style="text-decoration: none;">
            <div class="logo-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </a>

        <!-- Custom Content -->
        <div class="error-code">
            @yield('code')
        </div>
        
        <div class="error-message">
            @yield('message')
        </div>

        <p class="error-description">
            Sorry, we couldn't complete your request. The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>

        <!-- Actions -->
        <div class="actions">
            <button onclick="window.history.back()" class="btn btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Go Back
            </button>
            <a href="{{ url('/') }}" class="btn btn-primary">
                Return Home
            </a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'NetKey') }}. All rights reserved.
        </div>
    </div>

</body>
</html>
