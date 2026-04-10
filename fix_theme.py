import os
import re

app_layout_path = "resources/views/layouts/app.blade.php"
with open(app_layout_path, "r") as f:
    content = f.read()

# Replace parking colors with blue scale
content = re.sub(r"50: '#f0fdf4'", "50: '#eff6ff'", content)
content = re.sub(r"100: '#dcfce7'", "100: '#dbeafe'", content)
content = re.sub(r"200: '#bbf7d0'", "200: '#bfdbfe'", content)
content = re.sub(r"300: '#86efac'", "300: '#93c5fd'", content)
content = re.sub(r"400: '#4ade80'", "400: '#60a5fa'", content)
content = re.sub(r"500: '#22c55e'", "500: '#3b82f6'", content)
content = re.sub(r"600: '#16a34a'", "600: '#2563eb'", content)
content = re.sub(r"700: '#15803d'", "700: '#1d4ed8'", content)
content = re.sub(r"800: '#166534'", "800: '#1e40af'", content)
content = re.sub(r"900: '#14532d'", "900: '#1e3a8a'", content)

# Replace CSS logic
content = re.sub(r"--primary: #16a34a;", "--primary: #2563eb;", content)
content = re.sub(r"--primary-hover: #15803d;", "--primary-hover: #1d4ed8;", content)
content = re.sub(r"--primary: #22c55e;", "--primary: #3b82f6;", content)
content = re.sub(r"--primary-hover: #16a34a;", "--primary-hover: #2563eb;", content)

# Header bg matching
content = re.sub(r"--header-bg: #1e293b;", "--header-bg: #1e3a8a;", content)
content = re.sub(r"--header-bg: #0f172a;", "--header-bg: #172554;", content)

# Focus ring
content = re.sub(r"rgba\(34, 197, 94, 0\.2\)", "rgba(59, 130, 246, 0.2)", content)
content = re.sub(r"rgba\(34, 197, 94, 0\.3\)", "rgba(59, 130, 246, 0.3)", content)

# Update buttons
btn_css = """        .btn-primary:active { transform: translateY(0); box-shadow: none; }
        .btn-secondary { background-color: transparent; border: 1px solid var(--form-border); color: var(--text-main); }
        .btn-secondary:hover { background-color: #eff6ff; border-color: var(--primary); color: var(--primary); }
        .btn-secondary:active { background-color: #dbeafe; }
        .btn-danger { background-color: #ef4444; color: white; }
        .btn-danger:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
        .btn-danger:active { transform: translateY(0); box-shadow: none; }
        .btn:disabled, .btn[disabled] { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; pointer-events: none; }"""

# Replacing the secondary and danger sections
content = re.sub(r"\.btn-secondary {.*?(?=\/\* Badges \*\/)", btn_css + "\n        \n        ", content, flags=re.DOTALL)

with open(app_layout_path, "w") as f:
    f.write(content)

print("Updated app.blade.php")
