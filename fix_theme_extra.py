with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

# Add theme toggle to mobile menu as well
mobile_auth_old = """@auth
                    @if(Auth::user()->isAdmin())"""
mobile_auth_new = """@auth
                    <li class="menu-item block">
                        <button id="mobile-theme-toggle" type="button" class="w-full inline-flex py-2 relative group focus:outline-none rounded-lg items-center text-left">
                            <span id="mobile-theme-text">Thema (Light)</span>
                            <span class="absolute left-0 bottom-1 w-0 h-[2px] bg-blue-500 transition-all duration-300 group-hover:w-full rounded-full"></span>
                        </button>
                    </li>
                    @if(Auth::user()->isAdmin())"""

content = content.replace(mobile_auth_old, mobile_auth_new)

# Add logic for mobile button
js_old = """var themeToggleBtn = document.getElementById('theme-toggle');"""
js_new = """            var themeToggleBtn = document.getElementById('theme-toggle');
                var mobileThemeToggleBtn = document.getElementById('mobile-theme-toggle');
                var mobileThemeText = document.getElementById('mobile-theme-text');
                
                function updateMobileThemeText() {
                    if (mobileThemeText) {
                        mobileThemeText.textContent = document.documentElement.classList.contains('dark') ? 'Thema (Dark)' : 'Thema (Light)';
                    }
                }
                
                if (mobileThemeText) updateMobileThemeText();"""

content = content.replace(js_old, js_new)

js_old2 = """                        }
                    }
                });
            }"""
js_new2 = """                        }
                    }
                    if (typeof updateMobileThemeText === 'function') updateMobileThemeText();
                });
                
                if (mobileThemeToggleBtn) {
                    mobileThemeToggleBtn.addEventListener('click', function() {
                        themeToggleBtn.click();
                    });
                }
            }"""

content = content.replace(js_old2, js_new2)

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)
