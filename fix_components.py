import glob

def fix_js():
    for path in glob.glob("resources/views/**/*.blade.php", recursive=True):
        with open(path, "r") as f:
            content = f.read()

        original = content

        content = content.replace("document.addEventListener('DOMContentLoaded'", "document.addEventListener('turbo:load'")

        if content != original:
            with open(path, "w") as f:
                f.write(content)
            print("Updated", path)
            
fix_js()
