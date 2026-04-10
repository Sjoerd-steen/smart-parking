with open('app/Http/Controllers/AuthController.php', 'r') as f:
    content = f.read()

# Make sure we import auth logically if we needed to, but we can just use the Auth facade already present.

old_login_form = """    public function loginForm() {
        return view('auth.login');
    }"""
    
new_login_form = """    public function loginForm() {
        if (Auth::check()) {
            return Auth::user()->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }"""

old_register_form = """    public function registerForm() {
        return view('auth.register');
    }"""

new_register_form = """    public function registerForm() {
        if (Auth::check()) {
            return Auth::user()->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
        }
        return view('auth.register');
    }"""

content = content.replace(old_login_form, new_login_form)
content = content.replace(old_register_form, new_register_form)

with open('app/Http/Controllers/AuthController.php', 'w') as f:
    f.write(content)

