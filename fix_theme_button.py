import re

with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

# Replace darkMode: 'media' with darkMode: 'class'
content = content.replace("darkMode: 'media',", "darkMode: 'class',")

# Replace media queries with .dark class
content = content.replace("@media (prefers-color-scheme: dark) {", "html.dark {")
content = content.replace("@media (prefers-color-scheme: dark) {\n            select.form-input {", "html.dark select.form-input {")

# Add script at top
script_top = """    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>"""
content = re.sub(r'<script src="https://cdn.tailwindcss.com"></script>', script_top, content)

# Add button
btn_html = """
        <div class="flex items-center gap-4 h-full">
            {{-- Left: Logo --}}
            <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : route('login') }}" class="flex items-center h-full">
                <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain rounded-xl overflow-hidden">       
            </a>

            <button id="theme-toggle" type="button" class="text-white hover:text-gray-200 focus:outline-none flex flex-col items-center group transition ml-2 md:ml-4">
                <svg id="theme-toggle-dark-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <span class="text-[10px] md:text-xs mt-1 font-bold tracking-widest uppercase truncate max-w-[60px]">Thema</span>
            </button>
        </div>"""

content = re.sub(r'\{\{-- Left: Logo --\}\}.*?</a>', btn_html, content, flags=re.DOTALL)

# Add script at bottom
js_btm = """
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const menuLinks = mobileMenu ? mobileMenu.querySelectorAll('a, button') : [];
            
            let isMenuOpen = false;

            if(toggleButton && mobileMenu && menuOverlay) {
                const toggleMenu = () => {
                    isMenuOpen = !isMenuOpen;
                    toggleButton.setAttribute('aria-expanded', isMenuOpen);
                    toggleButton.classList.toggle('hamburger-active');
                    mobileMenu.classList.toggle('translate-x-full');
                    mobileMenu.classList.toggle('drawer-open');
                    menuOverlay.classList.toggle('opacity-0');
                    menuOverlay.classList.toggle('pointer-events-none');
                    document.body.style.overflow = isMenuOpen ? 'hidden' : '';
                    if (isMenuOpen && menuLinks.length) {
                        setTimeout(() => menuLinks[0].focus(), 300);
                    } else {
                        toggleButton.focus();
                    }
                };

                toggleButton.addEventListener('click', toggleMenu);
                menuOverlay.addEventListener('click', toggleMenu);
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && isMenuOpen) toggleMenu();
                });
            }

            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (themeToggleDarkIcon && themeToggleLightIcon) {
                if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    themeToggleLightIcon.classList.remove('hidden');
                } else {
                    themeToggleDarkIcon.classList.remove('hidden');
                }

                var themeToggleBtn = document.getElementById('theme-toggle');

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
                });
            }
        });
    </script>
</body>"""

content = re.sub(r'<script>.*?</script>\n</body>', js_btm, content, flags=re.DOTALL)
content = content.replace("html.dark.dark", "html.dark")

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)
