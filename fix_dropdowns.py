import glob

def fix_alpine():
    for path in glob.glob("resources/views/**/*.blade.php", recursive=True):
        with open(path, "r") as f:
            content = f.read()

        original = content

        # A common issue when using Turbo with Alpine.js (if any remains) or vanilla JS dropdowns is that
        # event listeners binding multiply on every navigation. But considering this app is mostly tailwind/vanilla JS,
        # moving DOMContentLoaded to turbo:load ensures scripts fire on navigation without an actual reload.

        # Just to be safe, if we have Alpine on the page we'd restart it, but let's just make sure
        # our Javascript listeners attached to 'turbo:load' are correct.

        if content != original:
            with open(path, "w") as f:
                f.write(content)
            print("Updated", path)
            
fix_alpine()
