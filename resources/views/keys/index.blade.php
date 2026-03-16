@push('styles')
<style>
/* ── KEYS INDEX — NETKEY DESIGN SYSTEM ── */

/* Header action buttons */
.keys-header-btn-primary {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 16px; background:#2563eb; color:white;
    border-radius:9px; font-weight:700; font-size:0.875rem;
    text-decoration:none; transition:all 0.2s; font-family:'Inter',sans-serif;
}
.keys-header-btn-primary:hover { background:#1d4ed8; transform:translateY(-1px); box-shadow:0 4px 14px rgba(37,99,235,0.3); }

/* Overview hero banner */
.nk-keys-hero {
    background: linear-gradient(135deg, #0a0f1e 0%, #1a2a4e 60%, #2563eb 100%);
    border-radius: 16px; padding: 28px 32px; color: white;
    position: relative; overflow: hidden;
}
.nk-keys-hero::before {
    content: ''; position: absolute; top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(96,165,250,0.2) 0%, transparent 70%);
    border-radius: 50%;
}

/* Stats cards */
.nk-key-stat {
    background: var(--bg-card, white);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 12px; padding: 20px;
    position: relative; overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}
.nk-key-stat:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
.dark .nk-key-stat { background: #161b22; border-color: #30363d; }

.nk-key-stat-stripe {
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
}
.stripe-top-blue  { background: linear-gradient(90deg, #2563eb, #60a5fa); }
.stripe-top-amber { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.stripe-top-green { background: linear-gradient(90deg, #22c55e, #4ade80); }

/* Key cards */
.key-card {
    background: var(--bg-card, white) !important;
    border: 1px solid var(--border, #e5e7eb) !important;
    border-radius: 14px !important;
    overflow: hidden !important;
    transition: transform 0.2s, box-shadow 0.2s !important;
}
.key-card:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 28px rgba(37,99,235,0.12) !important;
    border-color: #93c5fd !important;
}
.dark .key-card { background: #161b22 !important; border-color: #30363d !important; }
.dark .key-card:hover { border-color: #60a5fa !important; }

/* Key code display */
.nk-key-code-box {
    background: var(--bg-elevated, #f9fafb) !important;
    border: 1.5px solid var(--border, #e5e7eb) !important;
    border-radius: 10px !important;
}
.dark .nk-key-code-box { background: #21262d !important; border-color: #30363d !important; }

.nk-key-code-text {
    font-family: monospace;
    font-weight: 900;
    color: #2563eb !important;
    letter-spacing: 0.05em;
}
.dark .nk-key-code-text { color: #60a5fa !important; }

/* Status badges */
.nk-badge-active  { background: rgba(34,197,94,0.1); color: #16a34a; border: 1px solid rgba(34,197,94,0.2); border-radius: 6px; padding: 2px 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }
.nk-badge-expired { background: rgba(107,114,128,0.1); color: #6b7280; border: 1px solid rgba(107,114,128,0.2); border-radius: 6px; padding: 2px 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }
.nk-badge-other   { background: rgba(239,68,68,0.1); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); border-radius: 6px; padding: 2px 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }
.nk-badge-auto    { background: rgba(37,99,235,0.1); color: #2563eb; border: 1px solid rgba(37,99,235,0.2); border-radius: 6px; padding: 2px 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }
.nk-badge-custom  { background: rgba(139,92,246,0.1); color: #7c3aed; border: 1px solid rgba(139,92,246,0.2); border-radius: 6px; padding: 2px 8px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }

/* Action buttons in key card */
.nk-key-action-details {
    flex: 1; padding: 9px; text-align: center;
    background: rgba(37,99,235,0.06); color: #2563eb;
    border-radius: 9px; font-weight: 700; font-size: 0.8rem;
    text-decoration: none; transition: all 0.15s; font-family: 'Inter', sans-serif;
}
.nk-key-action-details:hover { background: rgba(37,99,235,0.12); }
.dark .nk-key-action-details { background: rgba(96,165,250,0.08); color: #60a5fa; }

.nk-key-action-extend {
    flex: 1; padding: 9px; text-align: center;
    background: rgba(34,197,94,0.08); color: #16a34a;
    border-radius: 9px; font-weight: 700; font-size: 0.8rem;
    text-decoration: none; transition: all 0.15s; display: flex; align-items: center; justify-content: center; gap: 4px;
    font-family: 'Inter', sans-serif;
}
.nk-key-action-extend:hover { background: rgba(34,197,94,0.15); }
.dark .nk-key-action-extend { background: rgba(34,197,94,0.08); color: #4ade80; }

.nk-key-action-copy {
    flex: 1; padding: 9px; text-align: center;
    background: var(--bg-elevated, #f9fafb); color: var(--fg-muted, #6b7280);
    border-radius: 9px; font-weight: 700; font-size: 0.8rem;
    border: none; cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif;
}
.nk-key-action-copy:hover { background: var(--bg, #f3f4f6); color: var(--fg, #111827); }
.dark .nk-key-action-copy { background: #21262d; color: #8b949e; }

/* Buy link button override */
.keys-header-btn-buy {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 16px; background:#22c55e; color:white;
    border-radius:9px; font-weight:700; font-size:0.875rem;
    text-decoration:none; transition:all 0.2s; font-family:'Inter',sans-serif;
}
.keys-header-btn-buy:hover { background:#16a34a; transform:translateY(-1px); }

.keys-header-btn-danger {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 16px; background:#0a0f1e; color:white;
    border-radius:9px; font-weight:700; font-size:0.875rem;
    text-decoration:none; transition:all 0.2s; border: 1px solid rgba(255,255,255,0.15);
    font-family:'Inter',sans-serif;
}
.keys-header-btn-danger:hover { background:#1a2a4e; }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-900 dark:text-white flex items-center gap-2">
                <svg width="22" height="22" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                {{ __('Your Keys') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('keys.custom-extend') }}" class="keys-header-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    {{ __('Custom Key Extension') }}
                </a>
                <a href="{{ route('products') }}" class="keys-header-btn-buy">
                    🛒 {{ __('Buy Package') }}
                </a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.custom-extend.index') }}" class="keys-header-btn-danger">
                        ⚙ {{ __('Manage Extension Packages') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="space-y-6">

            {{-- Overview hero --}}
            <div class="nk-keys-hero" style="position:relative">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" style="position:relative;z-index:1">
                    <div>
                        <h3 style="font-size:1.25rem;font-weight:800;margin-bottom:4px">{{ __('Key Overview') }}</h3>
                        <p style="color:rgba(255,255,255,0.55);font-size:0.875rem">{{ __('Manage all your keys') }}</p>
                    </div>
                    <div style="display:flex;align-items:center;gap:24px">
                        <div style="text-align:center">
                            <div style="font-size:2rem;font-weight:800">{{ $stats['total'] }}</div>
                            <div style="font-size:0.7rem;color:rgba(255,255,255,0.55);text-transform:uppercase;letter-spacing:1px">{{ __('Total Keys') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="nk-key-stat">
                    <div class="nk-key-stat-stripe stripe-top-green"></div>
                    <div style="font-size:1.75rem;font-weight:800;color:#16a34a;margin-top:8px">{{ $stats['active'] }}</div>
                    <div style="font-size:0.8rem;color:var(--fg-muted,#6b7280);margin-top:4px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px">{{ __('Active') }}</div>
                </div>
                <div class="nk-key-stat">
                    <div class="nk-key-stat-stripe stripe-top-amber"></div>
                    <div style="font-size:1.75rem;font-weight:800;color:#d97706;margin-top:8px">{{ $stats['expiring_soon'] }}</div>
                    <div style="font-size:0.8rem;color:var(--fg-muted,#6b7280);margin-top:4px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px">{{ __('Expiring Soon (7 days)') }}</div>
                </div>
                <div class="nk-key-stat">
                    <div class="nk-key-stat-stripe stripe-top-blue"></div>
                    <div style="font-size:1.75rem;font-weight:800;color:#2563eb;margin-top:8px">{{ number_format($stats['total_spent']) }}</div>
                    <div style="font-size:0.8rem;color:var(--fg-muted,#6b7280);margin-top:4px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px">{{ __('Total Spent') }} (🪙)</div>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="nk-filter-bar">
                <form method="GET" action="{{ route('keys.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search key...') }}"
                            style="width:100%;padding:10px 14px 10px 38px;border:1.5px solid var(--border,#e5e7eb);border-radius:10px;background:var(--bg-elevated,white);color:var(--fg,#111827);font-size:0.875rem;font-family:'Inter',sans-serif">
                    </div>
                    <div class="w-full md:w-44">
                        <select name="status" onchange="this.form.submit()"
                            style="width:100%;padding:10px 14px;border:1.5px solid var(--border,#e5e7eb);border-radius:10px;background:var(--bg-elevated,white);color:var(--fg,#111827);font-size:0.875rem;font-family:'Inter',sans-serif">
                            <option value="">{{ __('All Status') }}</option>
                            <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>🟢 {{ __('Active') }}</option>
                            <option value="expired"   {{ request('status') == 'expired'   ? 'selected' : '' }}>🔴 {{ __('Expired') }}</option>
                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>⚫ {{ __('Suspended') }}</option>
                        </select>
                    </div>
                    <div class="w-full md:w-44">
                        <select name="type" onchange="this.form.submit()"
                            style="width:100%;padding:10px 14px;border:1.5px solid var(--border,#e5e7eb);border-radius:10px;background:var(--bg-elevated,white);color:var(--fg,#111827);font-size:0.875rem;font-family:'Inter',sans-serif">
                            <option value="">{{ __('All Types') }}</option>
                            <option value="auto_generated" {{ request('type') == 'auto_generated' ? 'selected' : '' }}>AUTO</option>
                            <option value="custom"         {{ request('type') == 'custom'         ? 'selected' : '' }}>CUSTOM</option>
                        </select>
                    </div>
                </form>
            </div>

            {{-- Keys Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($keys as $key)
                    <div class="key-card group relative">

                        {{-- Status Badge --}}
                        <div style="position:absolute;top:14px;right:14px;z-index:10">
                            @if ($key->isActive())
                                <span class="nk-badge-active">ACTIVE</span>
                            @elseif($key->isExpired())
                                <span class="nk-badge-expired">EXPIRED</span>
                            @else
                                <span class="nk-badge-other">{{ strtoupper($key->status) }}</span>
                            @endif
                        </div>

                        {{-- Type Badge --}}
                        <div style="position:absolute;top:14px;left:14px;z-index:10">
                            @if ($key->key_type == 'custom')
                                <span class="nk-badge-custom">CUSTOM</span>
                            @else
                                <span class="nk-badge-auto">AUTO</span>
                            @endif
                        </div>

                        <div style="padding:56px 20px 20px">
                            {{-- Key Code --}}
                            <div style="margin-bottom:16px">
                                <span style="font-size:0.7rem;font-weight:700;color:var(--fg-muted,#6b7280);text-transform:uppercase;letter-spacing:1px">{{ __('Key Code') }}</span>
                                <div class="nk-key-code-box" style="display:flex;align-items:center;justify-content:space-between;margin-top:6px;padding:10px 12px">
                                    <code class="nk-key-code-text" style="font-size:0.95rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $key->key_code }}</code>
                                    <button onclick="copyToClipboard('{{ $key->key_code }}')"
                                        style="padding:6px;background:transparent;border:none;cursor:pointer;color:var(--fg-muted,#9ca3af);border-radius:6px"
                                        title="{{ __('Copy') }}">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Details --}}
                            <div style="space:0;font-size:0.8rem;margin-bottom:16px">
                                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid var(--border,#f3f4f6)">
                                    <span style="color:var(--fg-muted,#6b7280)">{{ __('Created At') }}</span>
                                    <span style="font-weight:600;color:var(--fg,#111827)">{{ $key->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid var(--border,#f3f4f6)">
                                    <span style="color:var(--fg-muted,#6b7280)">{{ __('Activated At') }}</span>
                                    <span style="font-weight:600;color:{{ $key->activated_at ? '#16a34a' : 'var(--fg-muted,#9ca3af)' }}">{{ $key->activated_at ? $key->activated_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : __('Not Activated') }}</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid var(--border,#f3f4f6)">
                                    <span style="color:var(--fg-muted,#6b7280)">{{ __('Total Duration') }}</span>
                                    <span style="font-weight:700;color:var(--fg,#111827)">{{ number_format($key->duration_minutes) }} {{ __('minutes') }}</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid var(--border,#f3f4f6)">
                                    <span style="color:var(--fg-muted,#6b7280)">{{ __('Expires At') }}</span>
                                    <span style="font-weight:600;color:{{ $key->isExpired() ? '#dc2626' : '#16a34a' }}">{{ $key->expires_at ? $key->expires_at->format('d/m/Y H:i') : '∞ '.__('Permanent') }}</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid var(--border,#f3f4f6)">
                                    <span style="color:var(--fg-muted,#6b7280)">{{ __('Time left') }}</span>
                                    <span style="font-weight:700;color:#2563eb">
                                        @if ($key->getRemainingSeconds() > 86400)
                                            <span style="display:block;margin-top:28px"></span>
                                            {{ $key->getRemainingDays() }} {{ __('days') }}
                                        @elseif ($key->getRemainingSeconds() > 3600)
                                            <span style="display:block;margin-top:28px"></span>
                                            {{ $key->getRemainingMinutes() }} {{ __('minutes') }}
                                        @else
                                            <span style="display:block;margin-top:28px"></span>
                                            {{ $key->getRemainingSeconds() }} {{ __('seconds') }}
                                        @endif
                                    </span>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:5px 0">
                                    <span style="color:var(--fg-muted,#6b7280)">{{ __('Total Cost') }}</span>
                                    <span style="font-weight:700;color:#d97706">{{ number_format($key->key_cost) }} 🪙</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div style="display:flex;gap:8px;padding-top:12px;border-top:1px solid var(--border,#e5e7eb)">
                                <a href="{{ route('keys.keydetails', $key->id) }}" class="nk-key-action-details">{{ __('Details') }}</a>
                                @if ($key->product_id)
                                    <a href="{{ route('keys.extend-confirm', $key->id) }}" class="nk-key-action-extend">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ __('Extend') }}
                                    </a>
                                @endif
                                <button onclick="copyToClipboard('{{ $key->key_code }}')" class="nk-key-action-copy">📋 {{ __('Copy') }}</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div style="width:72px;height:72px;background:var(--bg-elevated,#f3f4f6);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                            <svg width="32" height="32" fill="none" stroke="#9ca3af" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                        <h3 style="font-size:1.1rem;font-weight:700;color:var(--fg,#111827);margin-bottom:8px">{{ __('You have no keys') }}</h3>
                        <p style="color:var(--fg-muted,#6b7280);margin-bottom:20px">{{ __('Create your first key') }}</p>
                        <a href="{{ route('products') }}" class="keys-header-btn-primary">✨ {{ __('Create Key Now') }}</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $keys->links() }}
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('✅ ' + '{{ __('Key copied') }}' + ': ' + text);
            });
        }
    </script>

</x-app-layout>