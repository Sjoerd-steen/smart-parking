with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

# Fix background image support for dark mode
css_bg_old = """        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-image: url('/images/background.png');
            background-color: var(--bg-color);
            background-blend-mode: multiply;"""

css_bg_new = """        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-image: url('/images/background.png');
            background-color: var(--bg-color);
            background-blend-mode: normal;"""

# Add dark mode background blend styling
css_dark_bg_old = """@media (prefers-color-scheme: dark) {
            :root {"""
css_dark_bg_new = """html.dark {
            /* Dark theme */
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --card-border: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --form-bg: #0f172a;
            --form-border: #475569;
            --form-text: #f8fafc;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --header-bg: #172554;
            --btn-text: #ffffff;
            --row-hover: #334155;
        }
        html.dark body { background-blend-mode: multiply; }
        """

content = content.replace(css_bg_old, css_bg_new)
content = content.replace(css_dark_bg_old, css_dark_bg_new)

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)
