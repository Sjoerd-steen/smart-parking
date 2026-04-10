import os
import re

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    original = content

    # Fix buttons by ensuring they have border radius important, or just adding rounded-xl to classes
    if 'app.blade.php' in filepath:
        content = content.replace('border-radius: 0.75rem;', 'border-radius: 0.75rem !important;')
        content = content.replace('border-radius: 9999px;', 'border-radius: 9999px !important;')

    # Replace hardcoded text colors 
    content = content.replace('text-white', 'text-gray-900 dark:text-white')
    content = content.replace('text-gray-300', 'text-gray-600 dark:text-gray-300')
    content = content.replace('text-gray-400', 'text-gray-500 dark:text-gray-400')
    
    # Fix border and bg colors that are dark-mode only currently
    content = content.replace('border-gray-600', 'border-gray-300 dark:border-gray-600')
    content = content.replace('bg-gray-700', 'bg-gray-100 dark:bg-gray-700')
    content = content.replace('bg-gray-800', 'bg-gray-200 dark:bg-gray-800')
    content = content.replace('bg-gray-900', 'bg-gray-300 dark:bg-gray-900')

    # Fix overlapping classes
    content = content.replace('text-gray-900 dark:text-gray-900 dark:text-white', 'text-gray-900 dark:text-white')
    
    # Specific fix for header text
    if 'app.blade.php' in filepath:
        content = content.replace('text-gray-900 dark:text-white hover:text-gray-200', 'text-white hover:text-gray-200')

    if content != original:
        with open(filepath, 'w') as f:
            f.write(content)
        print(f"Updated {filepath}")

for root, dirs, files in os.walk('resources/views'):
    for file in files:
        if file.endswith('.php'):
            process_file(os.path.join(root, file))

print("Done")
