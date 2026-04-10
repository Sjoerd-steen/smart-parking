with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

# Fix dark mode CSS selector
content = content.replace("@media (prefers-color-scheme: dark) {\n            :root {", "html.dark {\n            /* Dark theme */")
content = content.replace("            }\n        }\n\n        body {", "        }\n\n        body {")

# Move the theme toggle button to the right

theme_btn = """
            <button id="theme-toggle" type="button" class="text-white hover:text-gray-200 focus:outline-none flex flex-col items-center group transition">
                <svg id="theme-toggle-dark-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <span class="text-xs mt-1 font-bold tracking-widest uppercase">Thema</span>
            </button>"""

left_section_old = """<div class="flex items-center h-full gap-4">
            <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : route('login') }}" class="flex items-center h-full">
                <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain rounded-xl overflow-hidden">       
            </a>

            <button id="theme-toggle" type="button" class="text-white hover:text-gray-200 focus:outline-none flex flex-col items-center group transition">
                <svg id="theme-toggle-dark-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="w-8 h-8 rounded-full border-2 border-white p-1 group-hover:bg-white/20 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <span class="text-xs mt-1 font-bold tracking-widest uppercase">Thema</span>
            </button>
        </div>"""

left_section_new = """<a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : route('login') }}" class="flex items-center h-full">
            <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain rounded-xl overflow-hidden">       
        </a>"""

content = content.replace(left_section_old, left_section_new)

# Add theme button to Right Desktop Nav
desktop_nav_old = '<nav class="hidden md:flex flex-row items-center gap-6">'
desktop_nav_new = desktop_nav_old + '\n' + theme_btn

content = content.replace(desktop_nav_old, desktop_nav_new)

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)
