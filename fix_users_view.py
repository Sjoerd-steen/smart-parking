import re

path = "resources/views/admin/users/index.blade.php"
with open(path, "r") as f:
    content = f.read()

# Replace search bar buttons
content = re.sub(r'class="btn-primary"', 'class="btn btn-primary"', content)
content = re.sub(r'class="btn-secondary"', 'class="btn btn-secondary"', content)
content = re.sub(r'class="form-input flex-1"', 'class="form-input flex-1 m-0"', content)

# Table styling
content = re.sub(r'border-gray-600', 'border-brand-border', content)
content = re.sub(r'text-gray-300', 'text-brand-muted', content)
content = re.sub(r'text-gray-400', 'text-brand-muted', content)
content = re.sub(r'divide-gray-600', 'divide-brand-border', content)
content = re.sub(r"hover:bg-\[\#2b3a5b\]", "hover-row", content)
content = re.sub(r"text-white", "text-main", content)

# Badges and buttons
content = re.sub(r'class="\s*\{\{\s*\$user->role', 'class="badge {{ $user->role', content)
content = re.sub(r'class="\s*\{\{\s*\$user->is_banned \? \'badge-red\'', 'class="badge {{ $user->is_banned ? \'badge-red\'', content)

content = re.sub(r'class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-300 px-3 py-1\.5 rounded-lg font-medium"', 'class="btn btn-primary !py-1 !px-3 font-semibold text-xs"', content)
content = re.sub(r'class="text-xs \{\{ \$user->is_banned \? \'bg-green-100 hover:bg-green-200 text-green-300\' : \'bg-red-100 hover:bg-red-200 text-red-700\' \}\} px-3 py-1\.5 rounded-lg font-medium"', 'class="btn {{ $user->is_banned ? \'btn-primary\' : \'btn-danger\' }} !py-1 !px-3 font-semibold text-xs"', content)

with open(path, "w") as f:
    f.write(content)
print("Updated users index")
