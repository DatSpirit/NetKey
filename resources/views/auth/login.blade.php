<x-guest-layout>
    <style>
        .auth-title {
            font-size: 1.6rem; font-weight: 800;
            color: var(--nk-gray-900); letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        .auth-subtitle {
            font-size: 0.875rem; color: var(--nk-gray-500);
            margin-bottom: 28px;
        }
        .auth-field { margin-bottom: 18px; }
        .auth-label {
            display: block;
            font-size: 0.75rem; font-weight: 700;
            color: var(--nk-gray-700); letter-spacing: 0.5px;
            text-transform: uppercase; margin-bottom: 6px;
        }
        .auth-input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--nk-gray-200);
            border-radius: 10px;
            background: var(--nk-white);
            color: var(--nk-gray-900);
            font-size: 0.925rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-input:focus {
            outline: none;
            border-color: var(--nk-blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .auth-input::placeholder { color: #adb5bd; }
        .auth-btn-primary {
            width: 100%; padding: 12px;
            background: var(--nk-blue);
            color: white; border: none;
            border-radius: 10px;
            font-size: 0.95rem; font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer; margin-top: 4px;
            letter-spacing: 0.2px;
            transition: all 0.2s;
        }
        .auth-btn-primary:hover {
            background: var(--nk-blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(37,99,235,0.3);
        }
        .auth-row {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .auth-check-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.875rem; color: var(--nk-gray-600);
            cursor: pointer;
        }
        .auth-check-label input[type="checkbox"] {
            accent-color: var(--nk-blue);
            width: 15px; height: 15px;
        }
        .auth-link {
            font-size: 0.875rem; color: var(--nk-blue);
            font-weight: 500; text-decoration: none;
        }
        .auth-link:hover { text-decoration: underline; }
        .auth-footer {
            text-align: center; margin-top: 24px;
            font-size: 0.875rem; color: var(--nk-gray-500);
        }
        .auth-divider {
            height: 1px; background: var(--nk-gray-200);
            margin: 24px 0;
        }
        .auth-error {
            color: #dc2626; font-size: 0.8rem;
            margin-top: 5px; display: block;
        }
        .session-status {
            background: #dcfce7; border: 1px solid #86efac;
            color: #15803d; border-radius: 8px;
            padding: 10px 14px; font-size: 0.875rem;
            margin-bottom: 20px;
        }
    </style>

    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <h1 class="auth-title">Welcome back</h1>
    <p class="auth-subtitle">Sign in to your NetKey account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="auth-field">
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" class="auth-input"
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="you@example.com">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="auth-field">
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" class="auth-input"
                   required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember / Forgot -->
        <div class="auth-row">
            <label class="auth-check-label">
                <input type="checkbox" name="remember" id="remember_me">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn-primary">Sign In</button>
    </form>

    @if (Route::has('register'))
        <div class="auth-divider"></div>
        <div class="auth-footer">
            Don't have an account?
            <a href="{{ route('register') }}" class="auth-link" style="margin-left:4px">Create one free →</a>
        </div>
    @endif
</x-guest-layout>
