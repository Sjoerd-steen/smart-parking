with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

content = content.replace(
    "transition: background-color 0.3s, color 0.3s;",
    "transition: background-color 0.3s, color 0.3s, background-image 0.3s;"
)

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)

