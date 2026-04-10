import re

filepath = 'resources/views/layouts/app.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

old_logo_block = """        {{-- Left: Logo --}}
        <a href="/" class="flex items-center h-full">
            <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain">       
        </a>"""

new_logo_block = """        {{-- Left: Logo --}}
        <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : '/' }}" class="flex items-center h-full">
            <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain rounded-xl overflow-hidden">       
        </a>"""

if old_logo_block in content:
    content = content.replace(old_logo_block, new_logo_block)
    with open(filepath, 'w') as f:
        f.write(content)
    print("Logo updated with border radius and dynamic link.")
else:
    print("Could not find exact block. Let's try regex.")
    content = re.sub(
        r'<a href="/" class="flex items-center h-full">\s*<img src="/images/logo\.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain">\s*</a>', 
        r'<a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route(\'admin.dashboard\') : route(\'user.dashboard\')) : \'/\' }}" class="flex items-center h-full">\n            <img src="/images/logo.png" alt="SmartParking Logo" class="max-h-12 w-auto object-contain rounded-xl overflow-hidden">\n        </a>', 
        content
    )
    with open(filepath, 'w') as f:
        f.write(content)
    print("Used regex to update logo.")
