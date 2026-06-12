<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartParking – @yield('title', 'Dashboard')</title>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;500;600;700;800&family=Satoshi:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        parking: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe',
                            300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* ─── TOKENS ─── */
        :root {
            --ink:        #0a0f1e;
            --ink-2:      #1e2842;
            --ink-3:      #3d4f70;
            --ink-4:      #7b8eb5;
            --ink-5:      #b0bdd6;
            --surface:    #f4f6fb;
            --surface-2:  #edf0f9;
            --white:      #ffffff;
            --border:     rgba(30,40,66,.10);
            --border-2:   rgba(30,40,66,.06);
            --blue:       #1a56db;
            --blue-2:     #1e40af;
            --blue-light: #3b82f6;
            --cyan:       #06b6d4;
            --grad:       linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            --grad-soft:  linear-gradient(135deg, rgba(26,86,219,.08) 0%, rgba(6,182,212,.06) 100%);
            --sh-sm:      0 2px 8px rgba(10,15,30,.07);
            --sh-md:      0 8px 32px rgba(10,15,30,.10);
            --sh-lg:      0 24px 64px rgba(10,15,30,.14);
            --sh-blue:    0 8px 40px rgba(26,86,219,.28);
            --r-sm:       8px;
            --r-md:       14px;
            --r-lg:       20px;
            --r-xl:       28px;
            --font-display: 'Cabinet Grotesk', sans-serif;
            --font-body:    'Satoshi', sans-serif;
            --ease-spring:  cubic-bezier(.22,1,.36,1);

            --bg-color:      #f4f6fb;
            --card-bg:       #ffffff;
            --card-border:   #e2e8f0;
            --text-main:     #0a0f1e;
            --text-muted:    #7b8eb5;
            --form-bg:       #f4f6fb;
            --form-border:   #b0bdd6;
            --form-text:     #0a0f1e;
            --primary:       #1a56db;
            --primary-hover: #1e40af;
            --btn-text:      #ffffff;
            --row-hover:     #edf0f9;
        }

        html.dark {
            --ink:        #e8edf5;
            --ink-2:      #c8d3e8;
            --ink-3:      #8fa3c8;
            --ink-4:      #5a7299;
            --ink-5:      #3a5070;
            --surface:    #0d1220;
            --surface-2:  #141a2e;
            --white:      #1a2338;
            --border:     rgba(160,185,230,.10);
            --border-2:   rgba(160,185,230,.06);
            --blue:       #4d8ef0;
            --blue-2:     #6ba3f5;
            --blue-light: #7ab5f7;

            --bg-color:      #0d1220;
            --card-bg:       #1a2338;
            --card-border:   #243050;
            --text-main:     #e8edf5;
            --text-muted:    #5a7299;
            --form-bg:       #0d1220;
            --form-border:   #2d3f60;
            --form-text:     #e8edf5;
            --primary:       #4d8ef0;
            --primary-hover: #6ba3f5;
            --row-hover:     #1e2c48;
        }

        /* ─── RESET ─── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--surface);
            color: var(--ink);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
            transition: background-color .3s, color .3s;
        }

        a { text-decoration: none; }
        img { display: block; max-width: 100%; }

        /* ─── NAVBAR ─── */
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 200;
            background: #1e3a8a;
            border-bottom: 1px solid rgba(255,255,255,.08);
            padding: .875rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            transition: background .25s, box-shadow .25s;
            box-shadow: 0 2px 12px rgba(10,15,30,.18);
        }

        html.dark .site-nav {
            background: #172554;
            border-bottom-color: rgba(255,255,255,.06);
        }

        /* Logo */
        .nav-logo {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.02em;
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-shrink: 0;
        }

        .nav-logo-mark {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nav-logo-mark svg { color: #fff; width: 16px; height: 16px; }
        .logo-accent { color: #93c5fd; }

        /* Center links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: .15rem;
            flex: 1;
            justify-content: center;
        }

        @media (max-width: 768px) { .nav-links { display: none; } }

        .nav-link {
            font-family: var(--font-body);
            font-size: .875rem;
            font-weight: 500;
            color: rgba(255,255,255,.7);
            padding: .45rem .85rem;
            border-radius: var(--r-sm);
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: .45rem;
        }

        .nav-link svg { width: 15px; height: 15px; flex-shrink: 0; }
        .nav-link:hover  { color: #fff; background: rgba(255,255,255,.1); }
        .nav-link.active { color: #fff; background: rgba(255,255,255,.15); }

        /* Right actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0;
        }

        .btn-theme {
            width: 36px;
            height: 36px;
            border-radius: var(--r-sm);
            border: 1.5px solid rgba(255,255,255,.2);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .18s;
            color: rgba(255,255,255,.7);
            flex-shrink: 0;
        }

        .btn-theme:hover {
            border-color: rgba(255,255,255,.5);
            color: #fff;
            background: rgba(255,255,255,.1);
        }

        .btn-theme svg { width: 16px; height: 16px; }

        .nav-divider {
            width: 1px;
            height: 20px;
            background: rgba(255,255,255,.15);
            flex-shrink: 0;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: .55rem;
            padding: .38rem .75rem .38rem .38rem;
            border-radius: 100px;
            border: 1.5px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.1);
            cursor: default;
            transition: all .18s;
        }

        .user-chip:hover {
            border-color: rgba(255,255,255,.4);
            background: rgba(255,255,255,.15);
        }

        .user-av {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(255,255,255,.2);
            border: 1px solid rgba(255,255,255,.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: .65rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .user-name {
            font-family: var(--font-display);
            font-size: .8rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }

        .btn-logout {
            font-family: var(--font-body);
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255,255,255,.7);
            padding: .45rem .85rem;
            border-radius: var(--r-sm);
            border: 1.5px solid rgba(255,255,255,.2);
            background: transparent;
            cursor: pointer;
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: .4rem;
            white-space: nowrap;
        }

        .btn-logout svg { width: 14px; height: 14px; }

        .btn-logout:hover {
            color: #fca5a5;
            border-color: rgba(239,68,68,.4);
            background: rgba(239,68,68,.12);
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem 1.2rem;
            background: rgba(255,255,255,.15);
            color: #fff;
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: var(--r-sm);
            font-family: var(--font-body);
            font-size: .875rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s var(--ease-spring);
        }

        .btn-login:hover {
            background: rgba(255,255,255,.25);
            border-color: rgba(255,255,255,.5);
            transform: translateY(-1px);
        }

        /* ─── MOBILE HAMBURGER ─── */
        .hamburger {
            display: none;
            width: 38px;
            height: 38px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border-radius: var(--r-sm);
            border: 1.5px solid rgba(255,255,255,.2);
            background: transparent;
            cursor: pointer;
            transition: all .18s;
            flex-shrink: 0;
        }

        @media (max-width: 768px) { .hamburger { display: flex; } }

        .hamburger:hover {
            border-color: rgba(255,255,255,.5);
            background: rgba(255,255,255,.1);
        }

        .ham-line {
            width: 16px;
            height: 2px;
            background: rgba(255,255,255,.8);
            border-radius: 2px;
            transition: transform .3s var(--ease-spring), opacity .2s;
            transform-origin: center;
        }

        .hamburger.open .ham-line:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open .ham-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open .ham-line:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ─── MOBILE DRAWER ─── */
        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10,15,30,.5);
            backdrop-filter: blur(4px);
            z-index: 150;
            opacity: 0;
            transition: opacity .3s;
        }

        .mobile-overlay.visible { opacity: 1; }

        .mobile-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 280px;
            height: 100%;
            background: var(--white);
            border-left: 1px solid var(--border);
            z-index: 160;
            transform: translateX(100%);
            transition: transform .4s var(--ease-spring);
            display: flex;
            flex-direction: column;
            padding: 5rem 1.75rem 2rem;
            gap: .25rem;
            overflow-y: auto;
        }

        .mobile-drawer.open { transform: translateX(0); }

        .drawer-link {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink-2);
            padding: .85rem 1rem;
            border-radius: var(--r-sm);
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .drawer-link svg { width: 18px; height: 18px; color: var(--ink-4); flex-shrink: 0; }
        .drawer-link:hover { background: rgba(26,86,219,.06); color: var(--blue); }
        .drawer-link:hover svg { color: var(--blue); }
        .drawer-link.active { background: rgba(26,86,219,.08); color: var(--blue); }
        .drawer-link.active svg { color: var(--blue); }

        .drawer-divider { height: 1px; background: var(--border); margin: .5rem 0; }

        .drawer-logout {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: #b91c1c;
            padding: .85rem 1rem;
            border-radius: var(--r-sm);
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: .65rem;
            width: 100%;
            text-align: left;
        }

        .drawer-logout svg { width: 18px; height: 18px; flex-shrink: 0; }
        .drawer-logout:hover { background: rgba(239,68,68,.06); }

        /* ─── MAIN ─── */
        .main-content {
            min-height: calc(100vh - 65px);
            padding: 2rem 1.75rem;
        }

        .main-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ─── ALERTS ─── */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-radius: var(--r-md);
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
            animation: alertIn .3s var(--ease-spring);
        }

        @keyframes alertIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:none; } }

        .alert svg { width: 20px; height: 20px; flex-shrink: 0; margin-top: .1rem; }
        .alert-title { font-family: var(--font-display); font-size: .9rem; font-weight: 700; margin-bottom: .2rem; }
        .alert-body { font-size: .85rem; opacity: .9; }

        .alert-success {
            background: rgba(16,185,129,.1);
            border-color: rgba(16,185,129,.25);
            color: #065f46;
        }

        .alert-error {
            background: rgba(239,68,68,.08);
            border-color: rgba(239,68,68,.2);
            color: #b91c1c;
        }

        html.dark .alert-success { background: rgba(16,185,129,.12); color: #6ee7b7; }
        html.dark .alert-error   { background: rgba(239,68,68,.12);  color: #fca5a5; }

        /* ─── LEGACY STYLES ─── */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--r-lg);
            padding: 2rem;
            color: var(--text-main);
            box-shadow: var(--sh-sm);
            transition: transform .2s, box-shadow .2s;
        }

        .card:hover { transform: translateY(-2px); box-shadow: var(--sh-md); }

        .form-input {
            width: 100%;
            background: var(--form-bg);
            color: var(--form-text);
            border: 1.5px solid var(--form-border);
            border-radius: var(--r-sm);
            padding: .65rem 1rem;
            font-family: var(--font-body);
            font-size: .875rem;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,86,219,.1);
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%237b8eb5' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right .75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        .form-label {
            display: block;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: .4rem;
        }

        .btn {
            font-family: var(--font-body);
            font-weight: 700;
            padding: .65rem 1.5rem;
            border-radius: var(--r-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            cursor: pointer;
            border: none;
            transition: all .2s var(--ease-spring);
        }

        .btn-primary { background: var(--grad); color: #fff; box-shadow: var(--sh-blue); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(26,86,219,.38); }

        .btn-secondary {
            background: transparent;
            border: 1.5px solid var(--border);
            color: var(--ink-3);
        }

        .btn-secondary:hover { border-color: var(--blue); color: var(--blue); background: rgba(26,86,219,.05); }

        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(239,68,68,.3); }

        .btn:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; pointer-events: none; }

        .badge { padding: .28rem .75rem; border-radius: 100px; font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; border: 1px solid transparent; }
        .badge-green { background: rgba(16,185,129,.08); color: #065f46; border-color: rgba(16,185,129,.22); }
        .badge-red   { background: rgba(239,68,68,.08);  color: #b91c1c; border-color: rgba(239,68,68,.2); }
        .badge-amber { background: rgba(245,158,11,.08); color: #92400e; border-color: rgba(245,158,11,.22); }
        .badge-blue  { background: rgba(26,86,219,.08);  color: var(--blue-2); border-color: rgba(26,86,219,.2); }

        .text-muted  { color: var(--text-muted); }
        .hover-row:hover { background: var(--row-hover); }

        .leaflet-popup-content-wrapper {
            background: var(--card-bg) !important;
            color: var(--text-main) !important;
            border-radius: var(--r-md) !important;
            box-shadow: var(--sh-lg) !important;
            border: 1px solid var(--card-border);
        }
        .leaflet-popup-tip { background: var(--card-bg) !important; }
    </style>

    <script type="module">import hotwireTurbo from "https://cdn.skypack.dev/@hotwired/turbo";</script>
</head>
<body>

{{-- NAVBAR --}}
<header class="site-nav" id="site-nav">

    <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : route('login') }}" class="nav-logo">
        <div class="nav-logo-mark">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        Smart<span class="logo-accent">Parking</span>
    </a>

    @auth
    <nav class="nav-links">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Home
        </a>
        <a href="{{ route('user.reservations') }}" class="nav-link {{ request()->routeIs('user.reservations*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/></svg>
            Reserveringen
        </a>
        <a href="{{ route('user.vehicles.index') }}" class="nav-link {{ request()->routeIs('user.vehicles*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h8m-8 4h4m-6 4h12l1-5H5l1 5z"/></svg>
            Voertuigen
        </a>
        <a href="{{ route('user.profile.edit') }}" class="nav-link {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profiel
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Admin
        </a>
        @endif
    </nav>
    @endauth

    <div class="nav-actions">

        <button class="btn-theme" id="theme-toggle" aria-label="Thema wisselen">
            <svg id="icon-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="hidden"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
            <svg id="icon-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="hidden"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
        </button>

        @auth
            <div class="nav-divider"></div>

            <div class="user-chip">
                <div class="user-av">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="display:contents">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Uitloggen
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-login">Inloggen →</a>
        @endauth

        <button class="hamburger" id="hamburger" aria-label="Menu openen">
            <div class="ham-line"></div>
            <div class="ham-line"></div>
            <div class="ham-line"></div>
        </button>

    </div>
</header>

{{-- Mobile overlay --}}
<div class="mobile-overlay" id="mobile-overlay"></div>

{{-- Mobile drawer --}}
<nav class="mobile-drawer" id="mobile-drawer">
    @auth
        <a href="{{ route('user.dashboard') }}" class="drawer-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Home
        </a>
        <a href="{{ route('user.reservations') }}" class="drawer-link {{ request()->routeIs('user.reservations*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/></svg>
            Reserveringen
        </a>
        <a href="{{ route('user.vehicles.index') }}" class="drawer-link {{ request()->routeIs('user.vehicles*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 11h8m-8 4h4m-6 4h12l1-5H5l1 5z"/></svg>
            Voertuigen
        </a>
        <a href="{{ route('user.profile.edit') }}" class="drawer-link {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profiel
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}" class="drawer-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Admin
        </a>
        @endif

        <div class="drawer-divider"></div>

        <form method="POST" action="{{ route('logout') }}" style="display:contents">
            @csrf
            <button type="submit" class="drawer-logout">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Uitloggen
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="drawer-link">Inloggen</a>
    @endauth
</nav>

{{-- MAIN CONTENT --}}
<main class="main-content">
    <div class="main-inner">

        @if(session('success'))
            <div class="alert alert-success">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div class="alert-title">Succes</div>
                    <div class="alert-body">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div class="alert-title">Er ging iets mis</div>
                    <div class="alert-body">
                        <ul style="list-style:disc;padding-left:1rem;margin-top:.25rem">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')

    </div>
</main>

<script>
    function initApp() {
        if (document.body.dataset.init === 'true') return;
        document.body.dataset.init = 'true';

        const iconLight = document.getElementById('icon-light');
        const iconDark  = document.getElementById('icon-dark');

        function applyThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            if (iconLight) iconLight.classList.toggle('hidden', !isDark);
            if (iconDark)  iconDark.classList.toggle('hidden', isDark);
        }

        applyThemeIcons();

        document.getElementById('theme-toggle')?.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            document.documentElement.classList.toggle('dark', !isDark);
            localStorage.setItem('color-theme', isDark ? 'light' : 'dark');
            applyThemeIcons();
        });

        const hamburger = document.getElementById('hamburger');
        const drawer    = document.getElementById('mobile-drawer');
        const overlay   = document.getElementById('mobile-overlay');
        let open = false;

        function toggleDrawer() {
            open = !open;
            hamburger?.classList.toggle('open', open);
            drawer?.classList.toggle('open', open);
            if (overlay) {
                overlay.style.display = open ? 'block' : 'none';
                requestAnimationFrame(() => overlay.classList.toggle('visible', open));
            }
            document.body.style.overflow = open ? 'hidden' : '';
        }

        hamburger?.addEventListener('click', toggleDrawer);
        overlay?.addEventListener('click', toggleDrawer);
        document.addEventListener('keydown', e => { if (e.key === 'Escape' && open) toggleDrawer(); });
    }

    document.addEventListener('DOMContentLoaded', initApp);
    document.addEventListener('turbo:load', initApp);
    if (document.readyState !== 'loading') initApp();
</script>

<script src="https://instant.page/5.2.0" type="module" integrity="sha384-jnZcgoEq3ZZ1hzLUAWx08GZ068ngG/ZTu8q+851n02//BdjRkIXXF9WfE2OaLq0" defer></script>
</body>
</html>