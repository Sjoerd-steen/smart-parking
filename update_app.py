import re

with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

new_rule = """
        html.dark body {
            background-image: none !important;
            background-color: var(--bg-color) !important;
        }

        body {"""

content = content.replace("        body {", new_rule, 1)

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)

