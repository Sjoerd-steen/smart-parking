import re

filepath = 'resources/views/layouts/app.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Just replace '/' with route('login') to match your exact request
content = content.replace("? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : '/'", "? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')) : route('login')")

with open(filepath, 'w') as f:
    f.write(content)
print("Logo link updated to redirect appropriately")
