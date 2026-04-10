import re

path = 'resources/views/user/reserve.blade.php'
with open(path, 'r') as f:
    content = f.read()

# Add standard style to select drop down 
content = content.replace('class="form-input text-lg font-semibold h-14 bg-gray-700 text-white cursor-pointer focus:ring-2 focus:ring-blue-500 border-none"', 'class="form-input text-lg font-semibold h-14 bg-form-bg text-form-text border-form-border focus:ring-2 focus:ring-primary rounded-lg cursor-pointer"')

# Fix inline styles for other forms keeping context standard
content = content.replace('class="form-input bg-gray-700 text-white w-full border-none focus:ring-2 focus:ring-blue-500 rounded-lg h-12 mb-4"', 'class="form-input bg-form-bg text-form-text w-full border-form-border focus:ring-2 focus:ring-primary rounded-lg h-12 mb-4 cursor-pointer"')

with open(path, 'w') as f:
    f.write(content)
