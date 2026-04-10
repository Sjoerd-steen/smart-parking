import re

file_path = 'resources/views/layouts/app.blade.php'
with open(file_path, 'r') as f:
    content = f.read()

# Add instant.page script before closing body tag if not already there
if 'instant.page' not in content:
    instant_script = '\n    <!-- Instant.page for just-in-time preloading -->\n    <script src="https://instant.page/5.2.0" type="module" integrity="sha384-jnZcgoEq3ZZ1hzLUAWx08GZ068ngG/ZTu8q+851n02//BdjRkIXXF9WfE2OaLq0" defer></script>\n</body>'
    content = content.replace('</body>', instant_script)
    with open(file_path, 'w') as f:
        f.write(content)
    print("Added instant.page script")
else:
    print("instant.page already exists")

