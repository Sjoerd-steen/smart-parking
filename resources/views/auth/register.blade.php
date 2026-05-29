@extends('layouts.app')

@section('title', 'Registreren')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    .register-wrap {
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #f8fafc;
    }

    @media (max-width: 768px) {
        .register-wrap { grid-template-columns: 1fr; }
        .register-aside { display: none; }
    }

    /* ── LEFT PANEL ── */
    .register-aside {
        position: relative;
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 45%, #0891b2 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem;
        overflow: hidden;
    }

    .register-aside::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px);
        background-size: 24px 24px;
    }

    .aside-orb {
        position: absolute;
        bottom: -120px;
        right: -120px;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .aside-orb-2 {
        position: absolute;
        top: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .aside-logo {
        font-family: 'Syne', sans-serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.03em;
        text-decoration: none;
        position: relative;
        z-index: 1;
    }

    .aside-logo span { color: #bfdbfe; }

    .aside-content {
        position: relative;
        z-index: 1;
    }

    .aside-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3rem 0.8rem;
        background: rgba(255,255,255,0.12);
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #bfdbfe;
        margin-bottom: 1.25rem;
    }

    .aside-eyebrow-dot {
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #93c5fd;
        animation: pulse 1.8s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.7); }
    }

    .aside-title {
        font-family: 'Syne', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        letter-spacing: -0.04em;
        margin-bottom: 1rem;
    }

    .aside-subtitle {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.65);
        line-height: 1.7;
        font-weight: 300;
        max-width: 340px;
        margin-bottom: 2.5rem;
    }

    .aside-steps {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .aside-step {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        position: relative;
    }

    .aside-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 15px;
        top: 32px;
        bottom: -12px;
        width: 1px;
        background: rgba(255,255,255,0.15);
    }

    .aside-step + .aside-step { margin-top: 1.25rem; }

    .aside-step-num {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .aside-step-body {
        padding-top: 0.4rem;
    }

    .aside-step-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        margin-bottom: 0.15rem;
    }

    .aside-step-sub {
        font-size: 0.775rem;
        color: rgba(255,255,255,0.45);
        font-weight: 300;
    }

    .aside-footer {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.35);
        position: relative;
        z-index: 1;
    }

    /* ── RIGHT PANEL ── */
    .register-main {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 2rem;
        background: #f8fafc;
        overflow-y: auto;
    }

    .register-box {
        width: 100%;
        max-width: 420px;
        animation: fadeUp 0.5s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .register-box-header {
        margin-bottom: 2rem;
    }

    .register-box-eyebrow {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #2563eb;
        margin-bottom: 0.5rem;
    }

    .register-box-title {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }

    .register-box-sub {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 300;
    }

    /* Two-column grid for fields */
    .fields-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .fields-grid .field-full {
        grid-column: span 2;
    }

    /* Field */
    .field {
        margin-bottom: 0;
    }

    .field-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: #334155;
        letter-spacing: 0.02em;
        margin-bottom: 0.4rem;
    }

    .field-wrap {
        position: relative;
    }

    .field-icon {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .field-icon svg { width: 16px; height: 16px; color: #94a3b8; }

    .field-input {
        width: 100%;
        height: 46px;
        padding: 0 1rem 0 2.75rem;
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        color: #0f172a;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        -webkit-appearance: none;
    }

    .field-input::placeholder { color: #94a3b8; }

    .field-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .field-input:hover:not(:focus) { border-color: #cbd5e1; }

    .field-input.has-error { border-color: #ef4444; }
    .field-input.has-error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

    .field-error {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.35rem;
        font-size: 0.72rem;
        color: #ef4444;
        font-weight: 500;
    }

    .field-error svg { width: 11px; height: 11px; flex-shrink: 0; }

    /* Password strength */
    .pw-strength {
        margin-top: 0.4rem;
        display: flex;
        gap: 4px;
    }

    .pw-bar {
        height: 3px;
        flex: 1;
        border-radius: 2px;
        background: #e2e8f0;
        transition: background 0.3s;
    }

    .pw-bar.weak { background: #ef4444; }
    .pw-bar.medium { background: #f59e0b; }
    .pw-bar.strong { background: #10b981; }

    .pw-hint {
        font-size: 0.7rem;
        color: #94a3b8;
        margin-top: 0.25rem;
    }

    /* Submit */
    .btn-register {
        width: 100%;
        height: 50px;
        background: #2563eb;
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 4px 20px rgba(37,99,235,0.3);
        margin-top: 1.5rem;
    }

    .btn-register:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 8px 28px rgba(37,99,235,0.4);
    }

    .btn-register:active { transform: translateY(0); }

    .btn-register svg {
        width: 16px; height: 16px;
        transition: transform 0.2s;
    }

    .btn-register:hover svg { transform: translateX(3px); }

    /* Divider */
    .form-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .form-divider::before,
    .form-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .form-divider-text {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .login-row {
        text-align: center;
    }

    .login-row p { font-size: 0.85rem; color: #64748b; }

    .login-link {
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
        border-bottom: 1.5px solid #e2e8f0;
        padding-bottom: 1px;
        transition: border-color 0.2s, color 0.2s;
    }

    .login-link:hover { color: #2563eb; border-color: #2563eb; }

    /* Alert */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 0.875rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
        font-size: 0.825rem;
        color: #b91c1c;
        line-height: 1.5;
    }

    .alert-error svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
</style>

<div class="register-wrap">

    <!-- LEFT — decorative panel -->
    <aside class="register-aside">
        <div class="aside-orb"></div>
        <div class="aside-orb-2"></div>

        <a href="{{ url('/') }}" class="aside-logo">Smart<span>Parking</span></a>

        <div class="aside-content">
            <div class="aside-eyebrow">
                <span class="aside-eyebrow-dot"></span>
                Gratis account
            </div>
            <h2 class="aside-title">Word lid in<br>enkele stappen.</h2>
            <p class="aside-subtitle">
                Maak een gratis account aan en reserveer direct je eerste parkeerplek bij SmartParking.
            </p>
            <div class="aside-steps">
                <div class="aside-step">
                    <div class="aside-step-num">1</div>
                    <div class="aside-step-body">
                        <div class="aside-step-title">Vul je gegevens in</div>
                        <div class="aside-step-sub">Naam, e-mail en wachtwoord.</div>
                    </div>
                </div>
                <div class="aside-step">
                    <div class="aside-step-num">2</div>
                    <div class="aside-step-body">
                        <div class="aside-step-title">Account aangemaakt</div>
                        <div class="aside-step-sub">Direct inloggen, geen bevestiging nodig.</div>
                    </div>
                </div>
                <div class="aside-step">
                    <div class="aside-step-num">3</div>
                    <div class="aside-step-body">
                        <div class="aside-step-title">Reserveer een plek</div>
                        <div class="aside-step-sub">Bekijk realtime beschikbaarheid en reserveer.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="aside-footer">&copy; {{ date('Y') }} SmartParking — Adem, Salim, Sjoerd & Mokhless</div>
    </aside>

    <!-- RIGHT — form -->
    <main class="register-main">
        <div class="register-box">

            <div class="register-box-header">
                <div class="register-box-eyebrow">Aan de slag</div>
                <h1 class="register-box-title">Account<br>aanmaken</h1>
                <p class="register-box-sub">Vul je gegevens in om lid te worden van SmartParking.</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="fields-grid">

                    <!-- Name — full width -->
                    <div class="field field-full">
                        <label class="field-label" for="name">Gebruikersnaam</label>
                        <div class="field-wrap">
                            <div class="field-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                class="field-input {{ $errors->has('name') ? 'has-error' : '' }}"
                                placeholder="Jouw naam"
                            >
                        </div>
                        @error('name')
                            <div class="field-error">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email — full width -->
                    <div class="field field-full">
                        <label class="field-label" for="email">E-mailadres</label>
                        <div class="field-wrap">
                            <div class="field-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="field-input {{ $errors->has('email') ? 'has-error' : '' }}"
                                placeholder="naam@voorbeeld.nl"
                            >
                        </div>
                        @error('email')
                            <div class="field-error">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <label class="field-label" for="password">Wachtwoord</label>
                        <div class="field-wrap">
                            <div class="field-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                minlength="6"
                                autocomplete="new-password"
                                class="field-input {{ $errors->has('password') ? 'has-error' : '' }}"
                                placeholder="Min. 6 tekens"
                                oninput="updateStrength(this.value)"
                            >
                        </div>
                        <div class="pw-strength">
                            <div class="pw-bar" id="bar1"></div>
                            <div class="pw-bar" id="bar2"></div>
                            <div class="pw-bar" id="bar3"></div>
                        </div>
                        @error('password')
                            <div class="field-error">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="field">
                        <label class="field-label" for="password_confirmation">Herhaal</label>
                        <div class="field-wrap">
                            <div class="field-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="field-input {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn-register">
                    Account aanmaken
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="form-divider">
                <span class="form-divider-text">Al een account?</span>
            </div>

            <div class="login-row">
                <p><a href="{{ route('login') }}" class="login-link">Terug naar inloggen →</a></p>
            </div>

        </div>
    </main>

</div>

<script>
    function updateStrength(val) {
        const bars = [
            document.getElementById('bar1'),
            document.getElementById('bar2'),
            document.getElementById('bar3'),
        ];

        bars.forEach(b => { b.className = 'pw-bar'; });

        if (!val) return;

        let score = 0;
        if (val.length >= 6) score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val) && /[0-9!@#$%^&*]/.test(val)) score++;

        const levels = ['weak', 'medium', 'strong'];
        for (let i = 0; i < score; i++) {
            bars[i].classList.add(levels[score - 1]);
        }
    }
</script>
@endsection