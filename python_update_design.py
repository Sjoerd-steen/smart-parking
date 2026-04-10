import re

with open('resources/views/layouts/app.blade.php', 'r') as f:
    content = f.read()

head_pattern = r"<head>.*?</head>"

new_head = """<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartParking – @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'media',
            theme: {
                extend: {
                    colors: {
                        parking: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        brand: {
                            dark: '#0f172a',
                            card: '#1e293b',
                            border: '#334155',
                            muted: '#64748b'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Light theme */
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --form-bg: #f1f5f9;
            --form-border: #cbd5e1;
            --form-text: #0f172a;
            --primary: #16a34a;
            --primary-hover: #15803d;
            --header-bg: #1e293b;
            --btn-text: #ffffff;
            --row-hover: #f1f5f9;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                /* Dark theme */
                --bg-color: #0f172a;
                --card-bg: #1e293b;
                --card-border: #334155;
                --text-main: #f8fafc;
                --text-muted: #94a3b8;
                --form-bg: #0f172a;
                --form-border: #475569;
                --form-text: #f8fafc;
                --primary: #22c55e;
                --primary-hover: #16a34a;
                --header-bg: #0f172a;
                --btn-text: #ffffff;
                --row-hover: #334155;
            }
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-image: url('/images/background.png');
            background-color: var(--bg-color);
            background-blend-mode: multiply;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: var(--text-main);
            transition: background-color 0.3s, color 0.3s;
            -webkit-font-smoothing: antialiased;
        }

        .main-content { min-height: calc(100vh - 80px); }
        
        /* Unified Card Styling */
        .card { 
            background-color: var(--card-bg); 
            border: 1px solid var(--card-border);
            border-radius: 1rem; 
            padding: 2rem; 
            color: var(--text-main); 
            width: 100%; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); 
            transition: transform 0.2s ease, box-shadow 0.2s ease; 
        }    
        .card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        
        /* Form Elements */
        .form-input { 
            width: 100%; 
            background-color: var(--form-bg); 
            color: var(--form-text); 
            border: 1px solid var(--form-border); 
            border-radius: 0.75rem; 
            padding: 0.75rem 1rem; 
            margin-top: 0.5rem; 
            outline: none; 
            transition: all 0.2s ease; 
            font-size: 0.95rem;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2); }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em; }
        
        /* Button Styles */
        .btn {
            font-weight: 600; 
            padding: 0.75rem 1.5rem; 
            border-radius: 0.75rem; 
            text-align: center; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
            border: none; 
            transition: all 0.2s ease;
            letter-spacing: 0.025em;
        }
        .btn-primary { background-color: var(--primary); color: var(--btn-text); }      
        .btn-primary:hover { background-color: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3); }
        .btn-secondary { background-color: transparent; border: 1px solid var(--form-border); color: var(--text-main); }
        .btn-secondary:hover { background-color: var(--form-bg); border-color: var(--text-muted); }
        .btn-danger { background-color: #ef4444; color: white; }
        .btn-danger:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }
        
        /* Badges */
        .badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid transparent; }
        .badge-green { background-color: rgba(34, 197, 94, 0.15); color: #22c55e; border-color: rgba(34, 197, 94, 0.3); }
        .badge-red { background-color: rgba(239, 68, 68, 0.15); color: #ef4444; border-color: rgba(239, 68, 68, 0.3); }
        .badge-amber { background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; border-color: rgba(245, 158, 11, 0.3); }
        .badge-blue { background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; border-color: rgba(59, 130, 246, 0.3); }
        
        .hover-row:hover { background-color: var(--row-hover); }
        .text-muted { color: var(--text-muted); }

        .site-header { background-color: var(--header-bg); border-bottom: 1px solid var(--card-border); transition: all 0.3s ease; }
        .nav-mobile { background-color: var(--header-bg); }
        @media (min-width: 768px) {
            .nav-mobile { background-color: transparent !important; }
        }

        /* Mobile menu transition */
        @media (max-width: 767px) {
            #main-nav { transition: max-height 0.3s ease-out, opacity 0.3s ease-out; overflow: hidden; }
            #main-nav.default-hidden { max-height: 0; opacity: 0; pointer-events: none; }
            #main-nav.menu-open { max-height: 500px; opacity: 1; pointer-events: auto; }
        }
        
        /* Alert animations */
        @keyframes slideInDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-alert { animation: slideInDown 0.3s ease-out forwards; }

        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper {
            background-color: var(--card-bg) !important;
            color: var(--text-main) !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid var(--card-border);
        }
        .leaflet-popup-tip {
            background-color: var(--card-bg) !important;
        }
    </style>
</head>"""

content = re.sub(head_pattern, new_head, content, flags=re.DOTALL)

# Let's standardize buttons across the file by appending `.btn` to usages of `.btn-[primary|secondary|danger]`
content = content.replace('class="btn-primary', 'class="btn btn-primary')
content = content.replace('class="btn-secondary', 'class="btn btn-secondary')
content = content.replace('class="btn-danger', 'class="btn btn-danger')

with open('resources/views/layouts/app.blade.php', 'w') as f:
    f.write(content)
