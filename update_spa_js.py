import re

file_path = 'resources/views/layouts/app.blade.php'
with open(file_path, 'r') as f:
    content = f.read()

# Replace any lingering DOMContentLoaded listeners in the layout
content = content.replace("document.addEventListener('DOMContentLoaded'", "document.addEventListener('turbo:load'")

with open(file_path, 'w') as f:
    f.write(content)

