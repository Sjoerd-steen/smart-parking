import re

filepath = 'resources/views/user/reserve.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Make the text of the map selection button explicitly white
content = re.sub(
    r'<button type="button" class="bg-blue-600 hover:bg-blue-700 text-gray-900 dark:text-white', 
    '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white', 
    content
)

with open(filepath, 'w') as f:
    f.write(content)
print("Fixed map select button color in reserve.blade.php")
