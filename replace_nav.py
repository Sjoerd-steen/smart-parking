import re
with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

# Replace CSS
css_old = r"""        /\* Mobile menu transition \*/
        @media \(max-width: 767px\) \{
            #main-nav \{ transition: max-height 0\.3s ease-out, opacity 0\.3s ease-out; overflow: hidden; \}
            #main-nav\.default-hidden \{ max-height: 0; opacity: 0; pointer-events: none; \}
            #main-nav\.menu-open \{ max-height: 500px; opacity: 1; pointer-events: auto; \}
        \}"""

css_new = """        /* Mobile menu transition */
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
        .menu-item:nth-child(5) { transition-delay: 0.30s; }"""

content = re.sub(css_old, css_new, content)


# Replace Header Structure
header_old = r"""    \{\{-- TOP HEADER --\}\}
    <header class="site-header.*?</header>"""

header_new = """    {{-- TOP HEADER --}}
    <header class="site-header min-h-[80px] px-4 md:px-8 py-4 md:py-0 flex items-center justify-between shadow-md relative z-50">
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center h-full">
            <img src="/images/Screenshot%202026-03-06%20at%2010.43.38%E2%80%AFAM%204.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain">       
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
    </nav>"""

content = re.sub(header_old, header_new, content, flags=re.DOTALL)

# Replace Javascript 
script_old = r"""    <script>
        document\.addEventListener\('DOMContentLoaded', \(\) => \{
            const menuBtn = document\.getElementById\('mobile-menu-btn'\);.*?\}\);
    </script>"""

script_new = """    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
        });
    </script>"""

content = re.sub(script_old, script_new, content, flags=re.DOTALL)

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)
