import os
import glob
import re

def fix_views():
    for path in glob.glob("resources/views/**/*.blade.php", recursive=True):
        with open(path, "r") as f:
            content = f.read()

        original = content

        # Replace standard auth buttons
        content = re.sub(r'class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"', 'class="w-full btn btn-primary mt-4"', content)
        content = re.sub(r'class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"', 'class="w-full btn btn-primary mt-4"', content)
        content = re.sub(r'class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"', 'class="text-sm text-blue-600 hover:text-blue-800 font-semibold"', content)
        
        # Replace input fields to use form-input
        content = re.sub(r'class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"', 'class="form-input mb-3"', content)
        content = re.sub(r'class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"', 'class="form-input"', content)
        
        # Labels and headers
        content = re.sub(r'class="block text-gray-700 text-sm font-bold mb-2"', 'class="form-label"', content)
        
        # Admin / generic table borders
        content = re.sub(r'border-gray-200', 'border-brand-border', content)
        content = re.sub(r'text-gray-500', 'text-brand-muted', content)
        content = re.sub(r'text-gray-900', 'text-main', content)

        if content != original:
            with open(path, "w") as f:
                f.write(content)
            print("Updated", path)
            
fix_views()
