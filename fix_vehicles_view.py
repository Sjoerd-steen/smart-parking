import re

path = 'resources/views/user/vehicles/index.blade.php'
with open(path, 'r') as f:
    content = f.read()

# Fix emoji and style dropdown
content = content.replace("🚗 Mijn Voertuigen", "Mijn Voertuigen")
content = content.replace("➕ Opslaan", "Opslaan")
content = content.replace("❌ Verwijderen", "Verwijderen")

# Add standard style to select drop down 
content = content.replace('<select name="type" class="form-input" required>', '<select name="type" class="form-input bg-form-bg text-form-text border-form-border focus:ring-2 focus:ring-primary rounded-lg cursor-pointer h-12" required>')

with open(path, 'w') as f:
    f.write(content)
