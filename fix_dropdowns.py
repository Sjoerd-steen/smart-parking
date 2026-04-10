import os

filepath = 'resources/views/layouts/app.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

css_addition = """
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); }
        
        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            cursor: pointer;
        }
        
        /* Dark mode svg for select dropdowns */
        @media (prefers-color-scheme: dark) {
            select.form-input {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            }
        }
"""

if "select.form-input" not in content:
    content = content.replace(".form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); }", css_addition)
    
    with open(filepath, 'w') as f:
        f.write(content)
    print("Added dropdown CSS to app.blade.php")
