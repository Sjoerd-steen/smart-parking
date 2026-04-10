import re

filepath = 'resources/views/user/reserve.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Update the "Reserveer deze plek ->" button on the map inside the reserve view as well
old_str = '<button type="button" class="bg-blue-600 hover:bg-blue-700 text-gray-900 dark:text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\\'' + spot.id + '\\')">Selecteer deze plek</button>'
new_str = '<button type="button" class="bg-blue-600 hover:bg-blue-500 font-bold py-1.5 px-3 mt-2 rounded-lg text-xs no-underline text-center shadow-sm w-full transition-colors" style="color: #ffffff !important;" onclick="event.preventDefault(); selectSpot(\\'' + spot.id + '\\')">Selecteer deze plek</button>'

if old_str in content:
    content = content.replace(old_str, new_str)
    with open(filepath, 'w') as f:
        f.write(content)
    print("Fixed map select button color in reserve.blade.php")
else:
    print("Could not find the exact select button string. Trying regex.")
    content = re.sub(r'<button type="button" class="bg-blue-600 hover:bg-blue-700.*?">Selecteer deze plek</button>', new_str, content)
    with open(filepath, 'w') as f:
        f.write(content)
    print("Fixed map select button using regex")

