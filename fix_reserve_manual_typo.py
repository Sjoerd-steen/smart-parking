import os

filepath = 'resources/views/user/reserve.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Make sure "Geen kenteken" from earlier fix displays license_plate
content = content.replace("{{ $v->kenteken ?? 'Geen kenteken' }}", "{{ $v->license_plate ?? 'Geen kenteken' }}")

with open(filepath, 'w') as f:
    f.write(content)
print("Updated reserve.blade.php kenteken check")
