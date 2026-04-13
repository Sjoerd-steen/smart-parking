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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        parking: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        brand: {
                            dark: '#0f172a',
                            card: '#1e293b',
                            border: '#334155',
                            muted: '#64748b'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Light theme */
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --form-bg: #f1f5f9;
            --form-border: #cbd5e1;
            --form-text: #0f172a;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --header-bg: #1e3a8a;
            --btn-text: #ffffff;
            --row-hover: #f1f5f9;
        }

        html.dark {
            /* Dark theme */
                /* Dark theme */
                --bg-color: #0f172a;
                --card-bg: #1e293b;
                --card-border: #334155;
                --text-main: #f8fafc;
                --text-muted: #94a3b8;
                --form-bg: #0f172a;
                --form-border: #475569;
                --form-text: #f8fafc;
                --primary: #3b82f6;
                --primary-hover: #2563eb;
                --header-bg: #172554;
                --btn-text: #ffffff;
                --row-hover: #334155;
        }


        html.dark body {
            background-image: none !important;
            background-color: var(--bg-color) !important;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-image: url('/images/background.png');
            background-color: var(--bg-color);
            background-blend-mode: normal;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: var(--text-main);
            transition: background-color 0.3s, color 0.3s, background-image 0.3s;
            -webkit-font-smoothing: antialiased;
        }

        .main-content { min-height: calc(100vh - 80px); }
        
        /* Unified Card Styling */
        .card { 
            background-color: var(--card-bg); 
            border: 1px solid var(--card-border);
            border-radius: 1rem; 
            padding: 2rem; 
            color: var(--text-main); 
            width: 100%; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); 
            transition: transform 0.2s ease, box-shadow 0.2s ease; 
        }    
        .card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        
        /* Form Elements */
        .form-input { 
            width: 100%; 
            background-color: var(--form-bg); 
            color: var(--form-text); 
            border: 1px solid var(--form-border); 
            border-radius: 0.75rem !important; 
            padding: 0.75rem 1rem; 
            margin-top: 0.5rem; 
            outline: none; 
            transition: all 0.2s ease; 
            font-size: 0.95rem;
        }
        
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); }
        
        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            cursor: pointer;
        }
        
        /* Dark mode svg for select dropdowns */
        @media (prefers-color-scheme: dark) {
            select.form-input {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            }
        }

        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em; }
        
        /* Button Styles */
        .btn {
            font-weight: 600; 
            padding: 0.75rem 1.5rem; 
            border-radius: 0.75rem !important; 
            text-align: center; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
            border: none; 
            transition: all 0.2s ease;
            letter-spacing: 0.025em;
        }
        .btn-primary { background-color: var(--primary); color: var(--btn-text); }      
        .btn-primary:hover { background-color: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
                .btn-primary:active { transform: translateY(0); box-shadow: none; }
        .btn-secondary { background-color: transparent; border: 1px solid var(--form-border); color: var(--text-main); }
        .btn-secondary:hover { background-color: #eff6ff; border-color: var(--primary); color: var(--primary); }
        .btn-secondary:active { background-color: #dbeafe; }
        .btn-danger { background-color: #ef4444; color: white; }
        .btn-danger:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
        .btn-danger:active { transform: translateY(0); box-shadow: none; }
        .btn:disabled, .btn[disabled] { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; pointer-events: none; }
        
        /* Badges */
        .badge { padding: 0.25rem 0.75rem; border-radius: 9999px !important; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid transparent; }
        .badge-green { background-color: rgba(34, 197, 94, 0.15); color: #22c55e; border-color: rgba(59, 130, 246, 0.3); }
        .badge-red { background-color: rgba(239, 68, 68, 0.15); color: #ef4444; border-color: rgba(239, 68, 68, 0.3); }
        .badge-amber { background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; border-color: rgba(245, 158, 11, 0.3); }
        .badge-blue { background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; border-color: rgba(59, 130, 246, 0.3); }
        
        .hover-row:hover { background-color: var(--row-hover); }
        .text-muted { color: var(--text-muted); }

        .site-header { background-color: var(--header-bg); border-bottom: 1px solid var(--card-border); transition: all 0.3s ease; }
        .nav-mobile { background-color: var(--header-bg); }
        @media (min-width: 768px) {
            .nav-mobile { background-color: transparent !important; }
        }

        /* Mobile menu transition */
        @media (max-width: 767px) {
            .nav-mobile { display: none !important; }
        }

        /* Hamburger Line Animations */
        .hamburger-line {
            transition: transform 0.3s ease-in-out, opacity 0.2s ease-in-out;
            transform-origin: center;
        }
        .hamburger-active .line-top { transform: translateY(8px) rotate(45deg); }
        .hamburger-active .line-middle { opacity: 0; transform: scaleX(0); }
        .hamburger-active .line-bottom { transform: translateY(-8px) rotate(-45deg); }

        /* Staggered Item Animations */
        .menu-item {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.4s ease, transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }
        .drawer-open .menu-item { opacity: 1; transform: translateX(0); }
        .menu-item:nth-child(1) { transition-delay: 0.10s; }
        .menu-item:nth-child(2) { transition-delay: 0.15s; }
        .menu-item:nth-child(3) { transition-delay: 0.20s; }
        .menu-item:nth-child(4) { transition-delay: 0.25s; }
        .menu-item:nth-child(5) { transition-delay: 0.30s; }
        
        /* Alert animations */
        @keyframes slideInDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-alert { animation: slideInDown 0.3s ease-out forwards; }

        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper {
            background-color: var(--card-bg) !important;
            color: var(--text-main) !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid var(--card-border);
        }
        .leaflet-popup-tip {
            background-color: var(--card-bg) !important;
        }
    </style>

    <!-- Turbo for SPA-like instant navigation -->
    <script type="module">import hotwireTurbo from "https://cdn.skypack.dev/@hotwired/turbo";</script>
</head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-[#0a0a0a] dark:text-gray-100 transition-colors duration-300">

    {{-- TOP HEADER --}}
    <header class="site-header min-h-[80px] px-4 md:px-8 py-4 md:py-0 flex items-center justify-between shadow-md relative z-50">
        <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : route('login') }}" class="flex items-center h-full">
            <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain rounded-xl overflow-hidden">       
        </a>

        {{-- Hamburger Button (Mobile) --}}
        <button 
            id="mobile-menu-btn" 
            class="md:hidden relative z-[60] w-10 h-10 flex flex-col items-center justify-center gap-[6px] focus:outline-none rounded-full bg-white/10 hover:bg-white/20 transition-colors"
            aria-expanded="false"
            aria-controls="mobile-menu"
        >
            <div class="hamburger-line line-top w-5 h-[2px] bg-white rounded-full"></div>
            <div class="hamburger-line line-middle w-5 h-[2px] bg-white rounded-full"></div>
            <div class="hamburger-line line-bottom w-5 h-[2px] bg-white rounded-full"></div>
        </button>

        {{-- Right: Navigation (Desktop Only) --}}
        <nav class="hidden md:flex flex-row items-center gap-6">

            <button id="theme-toggle" type="button" class="text-white hover:text-gray-200 focus:outline-none flex flex-col items-center group transition">
                <svg id="theme-toggle-dark-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <span class="text-xs mt-1 font-bold tracking-widest uppercase">Thema</span>
            </button>
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200 flex flex-col items-center group transition">
                        <svg class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-xs mt-1 font-bold tracking-widest uppercase">Admin</span>
                    </a>
                @endif
                <a href="{{ route('user.dashboard') }}" class="text-white hover:text-gray-200 flex flex-col items-center group transition">
                    <svg class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-xs mt-1 font-bold tracking-widest uppercase">Home</span>
                </a>
                <a href="{{ route('user.vehicles.index') }}" class="text-white hover:text-gray-200 flex flex-col items-center group transition">
                    <svg class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 11h8m-8 4h8m-10 4h12l1-5H5l1 5z"></path></svg>
                    <span class="text-xs mt-1 font-bold tracking-widest uppercase">Voertuigen</span>
                </a>
                <a href="{{ route('user.profile.edit') }}" class="text-white hover:text-gray-200 flex flex-col items-center group transition">
                    <svg class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="text-xs mt-1 font-bold tracking-widest uppercase">Profiel</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 text-center">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-200 flex flex-col items-center bg-transparent border-none cursor-pointer group transition">
                        <svg class="w-8 h-8 rounded-full border-2 border-white p-1 mx-auto group-hover:bg-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>     
                        <span class="text-xs mt-1 font-bold tracking-widest uppercase">Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-gray-200 flex flex-col items-center group transition">
                    <svg class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="text-xs mt-1 font-bold tracking-widest uppercase">Login</span>
                </a>
            @endauth
        </nav>
    </header>

    {{-- Overlay for menu --}}
    <div id="menu-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out md:hidden"></div>

    {{-- Mobile Drawer --}}
    <nav id="mobile-menu" class="fixed top-0 right-0 w-[280px] sm:w-[320px] h-full bg-[var(--card-bg)] border-l border-[var(--card-border)] shadow-2xl z-50 transform translate-x-full transition-transform duration-500 ease-[cubic-bezier(0.175,0.885,0.32,1.1)] md:hidden">
        <div class="flex flex-col h-full pt-24 pb-8 px-8 overflow-y-auto">
            <ul class="flex flex-col gap-6 font-semibold text-xl tracking-wide text-[var(--text-main)]">
                @auth
                    <li class="menu-item block">
                        <button id="mobile-theme-toggle" type="button" class="w-full inline-flex py-2 relative group focus:outline-none rounded-lg items-center text-left">
                            <span id="mobile-theme-text">Thema (Light)</span>
                            <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                        </button>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li class="menu-item block">
                            <a href="{{ route('admin.dashboard') }}" class="inline-block py-2 relative group focus:outline-none rounded-lg">
                                Admin Dashboard
                                <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item block">
                        <a href="{{ route('user.dashboard') }}" class="inline-block py-2 relative group focus:outline-none rounded-lg">
                            Home
                            <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                        </a>
                    </li>
                    <li class="menu-item block">
                        <a href="{{ route('user.vehicles.index') }}" class="inline-block py-2 relative group focus:outline-none rounded-lg">
                            Voertuigen
                            <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                        </a>
                    </li>
                    <li class="menu-item block">
                        <a href="{{ route('user.profile.edit') }}" class="inline-block py-2 relative group focus:outline-none rounded-lg">
                            Profiel
                            <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                        </a>
                    </li>
                    <li class="menu-item block">
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 w-full text-left">
                            @csrf
                            <button type="submit" class="inline-block py-2 relative group focus:outline-none rounded-lg font-semibold text-xl border-none bg-transparent cursor-pointer text-red-500 p-0 text-left">
                                Logout
                                <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-red-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                            </button>
                        </form>
                    </li>
                @else
                    <li class="menu-item block">
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-transform active:scale-95 focus:outline-none mt-4">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="main-content flex flex-col items-center w-full px-4 py-8 relative">     
        <div class="w-full max-w-6xl mx-auto">
            @if(session('success'))
                <div class="bg-emerald-600/90 backdrop-blur-sm border border-emerald-500 text-gray-900 dark:text-white px-6 py-4 rounded-lg shadow-lg relative mb-6 animate-alert flex items-start gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold">Succes</p>
                        <p class="text-sm opacity-90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-600/90 backdrop-blur-sm border border-red-500 text-gray-900 dark:text-white px-6 py-4 rounded-lg shadow-lg relative mb-6 animate-alert flex items-start gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold">Er ging iets mis</p>
                        <ul class="list-disc list-inside text-sm opacity-90 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        function initApp() {
            // Prevent multiple initializations on the same DOM when turbo isn't replacing it
            if (document.body.dataset.appInitialized === 'true') {
                return;
            }
            document.body.dataset.appInitialized = 'true';

            const toggleButton = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const menuLinks = mobileMenu ? mobileMenu.querySelectorAll('a, button') : [];
            
            let isMenuOpen = false;

            if(toggleButton && mobileMenu && menuOverlay) {
                const toggleMenu = () => {
                    isMenuOpen = !isMenuOpen;
                    
                    // Toggle Button ARIA & Animation
                    toggleButton.setAttribute('aria-expanded', isMenuOpen);
                    toggleButton.classList.toggle('hamburger-active');
                    
                    // Toggle Drawer Slide
                    mobileMenu.classList.toggle('translate-x-full');
                    mobileMenu.classList.toggle('drawer-open');
                    
                    // Toggle Overlay Fade
                    menuOverlay.classList.toggle('opacity-0');
                    menuOverlay.classList.toggle('pointer-events-none');
                    
                    // Accessibility: disable scrolling on body when menu is open
                    document.body.style.overflow = isMenuOpen ? 'hidden' : '';

                    // Focus management
                    if (isMenuOpen && menuLinks.length) {
                        setTimeout(() => menuLinks[0].focus(), 300);
                    } else {
                        toggleButton.focus();
                    }
                };

                toggleButton.addEventListener('click', toggleMenu);
                menuOverlay.addEventListener('click', toggleMenu);
                
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && isMenuOpen) {
                        toggleMenu();
                    }
                });
            }

            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (themeToggleDarkIcon && themeToggleLightIcon) {
                if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    themeToggleLightIcon.classList.remove('hidden');
                    themeToggleDarkIcon.classList.add('hidden');
                } else {
                    themeToggleDarkIcon.classList.remove('hidden');
                    themeToggleLightIcon.classList.add('hidden');
                }

                var themeToggleBtn = document.getElementById('theme-toggle');
                var mobileThemeToggleBtn = document.getElementById('mobile-theme-toggle');
                var mobileThemeText = document.getElementById('mobile-theme-text');
                
                function updateMobileThemeText() {
                    if (mobileThemeText) {
                        mobileThemeText.textContent = document.documentElement.classList.contains('dark') ? 'Thema (Dark)' : 'Thema (Light)';
                    }
                }
                
                if (mobileThemeText) updateMobileThemeText();

                if (themeToggleBtn) {
                    themeToggleBtn.addEventListener('click', function() {
                        themeToggleDarkIcon.classList.toggle('hidden');
                        themeToggleLightIcon.classList.toggle('hidden');

                        if (localStorage.getItem('color-theme')) {
                            if (localStorage.getItem('color-theme') === 'light') {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('color-theme', 'dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('color-theme', 'light');
                            }
                        } else {
                            if (document.documentElement.classList.contains('dark')) {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('color-theme', 'light');
                            } else {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('color-theme', 'dark');
                            }
                        }
                        if (typeof updateMobileThemeText === 'function') updateMobileThemeText();
                    });

                    if (mobileThemeToggleBtn) {
                        mobileThemeToggleBtn.addEventListener('click', function() {
                            themeToggleBtn.click();
                        });
                    }
                }
            }
        }

        // Initialize on both standard load and Turbo load to ensure it runs
        document.addEventListener('DOMContentLoaded', initApp);
        document.addEventListener('turbo:load', initApp);
        
        // Also run immediately in case DOMContentLoaded already fired (e.g. async module)
        if (document.readyState === 'interactive' || document.readyState === 'complete') {
            initApp();
        }
    </script>

    <!-- Instant.page for just-in-time preloading -->
    <script src="https://instant.page/5.2.0" type="module" integrity="sha384-jnZcgoEq3ZZ1hzLUAWx08GZ068ngG/ZTu8q+851n02//BdjRkIXXF9WfE2OaLq0" defer></script>
</body>
</html>
