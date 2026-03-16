<x-guest-layout>
    <style>
        .auth-title{font-size:1.6rem;font-weight:800;color:var(--nk-gray-900);letter-spacing:-0.5px;margin-bottom:4px;}
        .auth-subtitle{font-size:0.875rem;color:var(--nk-gray-500);margin-bottom:28px;}
        .auth-field{margin-bottom:16px;}
        .auth-label{display:block;font-size:0.75rem;font-weight:700;color:var(--nk-gray-700);letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;}
        .auth-input{width:100%;padding:11px 14px;border:1.5px solid var(--nk-gray-200);border-radius:10px;background:var(--nk-white);color:var(--nk-gray-900);font-size:0.925rem;font-family:'Inter',sans-serif;transition:border-color 0.2s,box-shadow 0.2s;}
        .auth-input:focus{outline:none;border-color:var(--nk-blue);box-shadow:0 0 0 3px rgba(37,99,235,0.12);}
        .auth-btn-primary{width:100%;padding:12px;background:var(--nk-blue);color:white;border:none;border-radius:10px;font-size:0.95rem;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;margin-top:8px;transition:all 0.2s;}
        .auth-btn-primary:hover{background:var(--nk-blue-dark);transform:translateY(-1px);box-shadow:0 4px 16px rgba(37,99,235,0.3);}
        .auth-error{color:#dc2626;font-size:0.8rem;margin-top:5px;display:block;}
        .fields-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    </style>

    <h1 class="auth-title">Set new password</h1>
    <p class="auth-subtitle">Choose a strong, unique password for your account.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-field">
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" class="auth-input"
                   value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   placeholder="you@example.com">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="fields-row">
            <div class="auth-field">
                <label for="password" class="auth-label">New Password</label>
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

        <button type="submit" class="auth-btn-primary">Reset Password</button>
    </form>
</x-guest-layout>
