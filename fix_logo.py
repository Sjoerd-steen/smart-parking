import codecs

filepath = 'resources/views/layouts/app.blade.php'
with codecs.open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('/images/Screenshot%202026-03-06%20at%2010.43.38%E2%80%AFAM%204.png', '/images/logo.png')

with codecs.open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Logo updated successfully.")
