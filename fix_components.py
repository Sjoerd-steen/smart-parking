import os
import glob
import re

def update_views():
    for filepath in glob.glob("resources/views/**/*.blade.php", recursive=True):
        with open(filepath, 'r') as f:
            content = f.read()

        if not content: continue
        original_content = content

        # Replace random colors
        content = re.sub(r'bg-green-600', 'bg-blue-600', content)
        content = re.sub(r'bg-green-700', 'bg-blue-700', content)
        content = re.sub(r'bg-green-500', 'bg-blue-500', content)
        content = re.sub(r'text-green-600', 'text-blue-600', content)
        content = re.sub(r'text-green-500', 'text-blue-500', content)
        content = re.sub(r'border-green-500', 'border-blue-500', content)
        content = re.sub(r'focus:border-green-500', 'focus:border-blue-500', content)
        content = re.sub(r'focus:ring-green-500', 'focus:ring-blue-500', content)
        content = re.sub(r'ring-green-500', 'ring-blue-500', content)
        content = re.sub(r'hover:text-green-500', 'hover:text-blue-500', content)
        
        # Replace specific admin/user styling inconsistencies 
        content = re.sub(r'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded', 'btn btn-primary', content)
        content = re.sub(r'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded', 'btn btn-danger', content)
        content = re.sub(r'text-blue-600 hover:text-blue-800', 'text-blue-600 hover:text-blue-800 font-semibold', content)
        content = re.sub(r'text-red-600 hover:text-red-800', 'text-red-600 hover:text-red-800 font-semibold', content)
        
        # Clean up weird inline styles on tables and headers
        content = re.sub(r'class="min-w-full bg-white border border-gray-200"', 'class="min-w-full text-left border-collapse"', content)

        if content != original_content:
            with open(filepath, 'w') as f:
                f.write(content)
            print(f"Updated {filepath}")

update_views()
