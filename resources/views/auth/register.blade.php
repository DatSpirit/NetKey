<x-guest-layout>
    <style>
        .auth-title { font-size:1.6rem;font-weight:800;color:var(--nk-gray-900);letter-spacing:-0.5px;margin-bottom:4px; }
        .auth-subtitle { font-size:0.875rem;color:var(--nk-gray-500);margin-bottom:28px; }
        .auth-field { margin-bottom:16px; }
        .auth-label { display:block;font-size:0.75rem;font-weight:700;color:var(--nk-gray-700);letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px; }
        .auth-input { width:100%;padding:11px 14px;border:1.5px solid var(--nk-gray-200);border-radius:10px;background:var(--nk-white);color:var(--nk-gray-900);font-size:0.925rem;font-family:'Inter',sans-serif;transition:border-color 0.2s,box-shadow 0.2s; }
        .auth-input:focus { outline:none;border-color:var(--nk-blue);box-shadow:0 0 0 3px rgba(37,99,235,0.12); }
        .auth-input::placeholder { color:#adb5bd; }
        .auth-btn-primary { width:100%;padding:12px;background:var(--nk-blue);color:white;border:none;border-radius:10px;font-size:0.95rem;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;margin-top:8px;letter-spacing:0.2px;transition:all 0.2s; }
        .auth-btn-primary:hover { background:var(--nk-blue-dark);transform:translateY(-1px);box-shadow:0 4px 16px rgba(37,99,235,0.3); }
        .auth-link { font-size:0.875rem;color:var(--nk-blue);font-weight:500;text-decoration:none; }
        .auth-link:hover { text-decoration:underline; }
        .auth-footer { text-align:center;margin-top:24px;font-size:0.875rem;color:var(--nk-gray-500); }
        .auth-divider { height:1px;background:var(--nk-gray-200);margin:24px 0; }
        .auth-error { color:#dc2626;font-size:0.8rem;margin-top:5px;display:block; }
        .fields-row { display:grid;grid-template-columns:1fr 1fr;gap:12px; }
    </style>

    <h1 class="auth-title">Create account</h1>
    <p class="auth-subtitle">Join NetKey — it's free for 30 days</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="auth-field">
            <label for="name" class="auth-label">Full Name</label>
            <input id="name" type="text" name="name" class="auth-input"
                   value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Your full name">
            @error('name')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="auth-field">
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" class="auth-input"
                   value="{{ old('email') }}" required autocomplete="username"
                   placeholder="you@example.com">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Phone -->
        <div class="auth-field">
            <label for="phone_number" class="auth-label">Phone Number</label>
            <input id="phone_number" type="text" name="phone_number" class="auth-input"
                   value="{{ old('phone_number') }}" required
                   placeholder="+84 xxx xxx xxx">
            @error('phone_number')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Passwords row -->
        <div class="fields-row">
            <div class="auth-field">
                <label for="password" class="auth-label">Password</label>
                <input id="password" type="password" name="password" class="auth-input"
                       required autocomplete="new-password" placeholder="••••••••">
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="auth-field">
                <label for="password_confirmation" class="auth-label">Confirm</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="auth-input" required autocomplete="new-password" placeholder="••••••••">
                @error('password_confirmation')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="auth-btn-primary">Create Account</button>
    </form>

    <div class="auth-divider"></div>
    <div class="auth-footer">
        Already have an account?
        <a href="{{ route('login') }}" class="auth-link" style="margin-left:4px">Sign in →</a>
    </div>
</x-guest-layout>