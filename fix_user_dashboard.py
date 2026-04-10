import re

path = 'resources/views/user/dashboard.blade.php'
with open(path, 'r') as f:
    content = f.read()

# Add border radius to buttons
content = content.replace("btn-primary !w-auto !mt-0 !py-2 text-sm uppercase", "btn-primary !w-auto !mt-0 !py-2 text-sm uppercase rounded-xl")
content = content.replace("btn-primary inline-flex gap-2 !py-2 text-sm uppercase tracking-wider group", "btn-primary inline-flex gap-2 !py-2 text-sm uppercase tracking-wider group rounded-xl")
content = content.replace("btn-primary !w-full !mt-6 text-sm uppercase tracking-wider bg-gray-700 hover:bg-gray-600 block", "btn-primary !w-full !mt-6 text-sm uppercase tracking-wider bg-brand-border hover:bg-brand-muted block rounded-xl")

# Remove any emojis if present (none were directly visible but just in case)
content = content.replace("🅿️", "")
content = content.replace("😔", "")

with open(path, 'w') as f:
    f.write(content)
