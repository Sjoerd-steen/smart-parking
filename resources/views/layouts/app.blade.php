<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartParking – @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            /* Light theme */
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --form-bg: #f9fafb;
            --form-border: #d1d5db;
            --form-text: #1f2937;
            --primary: #3b5998;
            --primary-hover: #2d4373;
            --header-bg: #3b5998;
            --btn-text: #ffffff;
            --row-hover: #f3f4f6;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                /* Dark theme */
                --bg-color: #111827;
                --card-bg: #1f2937;
                --card-border: #374151;
                --text-main: #f9fafb;
                --text-muted: #9ca3af;
                --form-bg: #374151;
                --form-border: #4b5563;
                --form-text: #f9fafb;
                --primary: #4b6aab;
                --primary-hover: #5c7cbf;
                --header-bg: #111827;
                --btn-text: #ffffff;
                --row-hover: #374151;
            }
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-image: url('/images/background.png');
            background-color: var(--bg-color);
            background-blend-mode: multiply;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: var(--text-main);
            transition: background-color 0.3s, color 0.3s;
        }

        .main-content { min-height: calc(100vh - 80px); }
        
        .card { 
            background-color: var(--card-bg); 
            border: 1px solid var(--card-border);
            border-radius: 0.5rem; 
            padding: 2rem; 
            color: var(--text-main); 
            width: 100%; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s, border-color 0.3s, color 0.3s; 
        }    
        .card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2); }
        
        .form-input { 
            width: 100%; 
            background-color: var(--form-bg); 
            color: var(--form-text); 
            border: 2px solid var(--form-border); 
            border-radius: 0.5rem; 
            padding: 0.75rem 1rem; 
            margin-top: 0.5rem; 
            outline: none; 
            transition: all 0.3s ease; 
        }
        .form-input:focus { border-color: var(--primary); background-color: var(--form-bg); box-shadow: 0 0 0 3px rgba(59, 89, 152, 0.3); }
        .form-label { display: block; font-size: 0.95rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.25rem; letter-spacing: 0.025em; transition: color 0.3s; }
        
        .btn-primary { background-color: var(--primary); color: var(--btn-text); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-align: center; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border: none; transition: all 0.3s ease; }      
        .btn-primary:hover { background-color: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.2); }
        .btn-secondary { background-color: var(--form-bg); border: 1px solid var(--form-border); color: var(--text-main); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-align: center; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; }
        .btn-secondary:hover { background-color: var(--card-border); transform: translateY(-1px); }
        
        .btn-danger { background-color: #ef4444; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; text-align: center; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; border: none; transition: all 0.3s ease;}
        .btn-danger:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(220,38,38,0.4); }
        
        .badge-green { background-color: rgba(6, 95, 70, 0.8); color: #6ee7b7; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; border: 1px solid #059669; backdrop-filter: blur(4px); transition: all 0.2s; }
        .badge-red { background-color: rgba(127, 29, 29, 0.8); color: #fca5a5; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; border: 1px solid #b91c1c; backdrop-filter: blur(4px); transition: all 0.2s; }
        .badge-blue { background-color: rgba(30, 58, 138, 0.8); color: #93c5fd; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; border: 1px solid #2563eb; backdrop-filter: blur(4px); transition: all 0.2s; }
        
        .hover-row:hover { background-color: var(--row-hover); }
        .text-muted { color: var(--text-muted); }

        .site-header { background-color: var(--header-bg); border-bottom: 1px solid var(--card-border); transition: background-color 0.3s, border-color 0.3s; }
        .nav-mobile { background-color: var(--header-bg); }
        @media (min-width: 768px) {
            .nav-mobile { background-color: transparent !important; }
        }

        /* Mobile menu transition */
        @media (max-width: 767px) {
            #main-nav { transition: max-height 0.4s ease-in-out, opacity 0.4s ease-in-out; overflow: hidden; }
            #main-nav.default-hidden { max-height: 0; opacity: 0; pointer-events: none; }
            #main-nav.menu-open { max-height: 500px; opacity: 1; pointer-events: auto; }
        }
        
        /* Alert animations */
        @keyframes slideInDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-alert { animation: slideInDown 0.4s ease-out forwards; }
    </style>
</head>
<body class="antialiased">

    {{-- TOP HEADER --}}
    <header class="site-header min-h-[80px] px-4 md:px-8 py-4 md:py-0 flex flex-wrap items-center justify-between shadow-md relative">
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center h-full">
            <img src="/images/Screenshot%202026-03-06%20at%2010.43.38%E2%80%AFAM%204.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain">       
        </a>

        {{-- Hamburger Button (Mobile) --}}
        <button id="mobile-menu-btn" class="md:hidden text-white hover:text-gray-200 focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        {{-- Right: Navigation --}}
        <nav id="main-nav" class="nav-mobile hidden md:flex flex-col md:flex-row items-center gap-4 md:gap-6 w-full md:w-auto mt-4 md:mt-0 pb-4 md:pb-0 default-hidden md:max-h-full md:opacity-100 absolute md:relative top-[80px] md:top-auto left-0 z-50 shadow-lg md:shadow-none">
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
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 w-full md:w-auto text-center">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-200 flex flex-col items-center w-full bg-transparent border-none cursor-pointer group transition">
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

    {{-- MAIN CONTENT --}}
    <main class="main-content flex flex-col items-center w-full px-4 py-8 relative">     
        <div class="w-full max-w-6xl mx-auto">
            @if(session('success'))
                <div class="bg-emerald-600/90 backdrop-blur-sm border border-emerald-500 text-white px-6 py-4 rounded-lg shadow-lg relative mb-6 animate-alert flex items-start gap-3">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold">Succes</p>
                        <p class="text-sm opacity-90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-600/90 backdrop-blur-sm border border-red-500 text-white px-6 py-4 rounded-lg shadow-lg relative mb-6 animate-alert flex items-start gap-3">
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
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mainNav = document.getElementById('main-nav');
            
            if(menuBtn && mainNav) {
                menuBtn.addEventListener('click', () => {
                    if (mainNav.classList.contains('hidden')) {
                        mainNav.classList.remove('hidden', 'default-hidden');
                        mainNav.classList.add('flex');
                        // Small timeout to allow display:flex to apply before animating opacity/max-height
                        setTimeout(() => {
                            mainNav.classList.add('menu-open');
                        }, 10);
                    } else {
                        mainNav.classList.remove('menu-open');
                        mainNav.classList.add('default-hidden');
                        setTimeout(() => {
                            mainNav.classList.remove('flex');
                            mainNav.classList.add('hidden');
                        }, 400); // match transition duration
                    }
                });
            }
        });
    </script>
</body>
</html>
