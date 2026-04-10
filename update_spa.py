import re

file_path = 'resources/views/layouts/app.blade.php'
with open(file_path, 'r') as f:
    content = f.read()

# Add Hotwire Turbo script just before the head tag closes
if '<script type="module">import hotwireTurbo from "https://cdn.skypack.dev/@hotwired/turbo";</script>' not in content:
    turbo_script = '\n    <!-- Turbo for SPA-like instant navigation -->\n    <script type="module">import hotwireTurbo from "https://cdn.skypack.dev/@hotwired/turbo";</script>\n</head>'
    content = content.replace('</head>', turbo_script)

# Replace DOMContentLoaded with Turbo's equivalent event to ensure javascript still works
content = content.replace("document.addEventListener('DOMContentLoaded', () => {", "document.addEventListener('turbo:load', () => {")
content = content.replace("document.addEventListener('DOMContentLoaded', function() {", "document.addEventListener('turbo:load', function() {")

with open(file_path, 'w') as f:
    f.write(content)

print("Turbo injected and JS fixed.")
