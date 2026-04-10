import re

with open('resources/views/user/reserve.blade.php', 'r') as f:
    content = f.read()

content = content.replace(
    "old('external_parking_id') == $spot['id']",
    "old('external_parking_id', $selectedSpotId ?? '') == $spot['id']"
)

with open('resources/views/user/reserve.blade.php', 'w') as f:
    f.write(content)
