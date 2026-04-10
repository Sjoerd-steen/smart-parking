import re

filepath = 'resources/views/user/dashboard.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Also ensure the generic "Nieuwe Reservering" link is using the correct url in case it was wrong
content = content.replace("Route('user.reserve')", "route('user.reserve')")

# Explicitly ensure the route is /user/reserveren
content = re.sub(r'href="/user/reserveren\?spot_id=\$\{spot\.id\}"', r'href="/user/reserveren?spot_id=${spot.id}"', content)

with open(filepath, 'w') as f:
    f.write(content)
print("Updated dashboard button routes")
