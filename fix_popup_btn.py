import os

filepath = 'resources/views/user/dashboard.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

old_str = '<a href="/user/reserve?spot_id=${spot.id}" class="mt-3 block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-3 rounded-lg text-xs no-underline transition-colors shadow-sm">Reserveer deze plek →</a>'
new_str = '<a href="/user/reserveren?spot_id=${spot.id}" class="mt-3 block text-center bg-blue-600 hover:bg-blue-500 font-bold py-1.5 px-3 rounded-lg text-xs no-underline transition-colors shadow-sm" style="color: #ffffff !important;">Reserveer deze plek →</a>'

if old_str in content:
    content = content.replace(old_str, new_str)
    with open(filepath, 'w') as f:
        f.write(content)
    print("Fixed map popup button URL and color")
else:
    print("Could not find the exact string. Let's try regex.")
    import re
    content = re.sub(r'<a href="/user/reserve\?spot_id=\$\{spot\.id\}".*?>Reserveer deze plek →</a>', new_str, content)
    with open(filepath, 'w') as f:
        f.write(content)
    print("Fixed map popup using regex")

