<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartParking - Modern Parking Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --blue: #2563eb;
            --blue-light: #3b82f6;
            --blue-dim: #dbeafe;
            --cyan: #06b6d4;
            --ink: #0f172a;
            --ink-mid: #334155;
            --ink-soft: #64748b;
            --surface: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --border-dark: #1e293b;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
        }

        body.dark {
            background: #090e1a;
            color: #e2e8f0;
        }

        h1, h2, h3, .logo {
            font-family: 'Syne', sans-serif;
        }

        /* ── NAV ── */
        .nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px) saturate(1.4);
            border-bottom: 1px solid var(--border);
            transition: background 0.3s;
        }

        .dark .nav {
            background: rgba(9,14,26,0.85);
            border-bottom-color: var(--border-dark);
        }

        .logo {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--ink);
        }

        .dark .logo { color: #f1f5f9; }

        .logo span { color: var(--blue); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-link {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--ink-mid);
            text-decoration: none;
            transition: color 0.2s;
        }

        .dark .nav-link { color: #94a3b8; }
        .nav-link:hover { color: var(--blue); }

        .btn-nav {
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 0.5rem 1.25rem;
            background: var(--blue);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-nav:hover { background: #1d4ed8; transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 2rem 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 50%, #f0f9ff 100%);
        }

        .dark .hero-bg {
            background: linear-gradient(135deg, #0f1a35 0%, #090e1a 50%, #071525 100%);
        }

        /* Grid overlay */
        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(37,99,235,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37,99,235,0.05) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Orb */
        .hero-orb {
            position: absolute;
            top: -120px;
            right: -80px;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.12) 0%, rgba(6,182,212,0.06) 50%, transparent 70%);
            pointer-events: none;
            animation: orbFloat 8s ease-in-out infinite;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.04); }
        }

        .hero-inner {
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 900px) {
            .hero-inner { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.9rem;
            background: var(--blue-dim);
            color: var(--blue);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s ease both;
        }

        .dark .hero-badge {
            background: rgba(37,99,235,0.15);
            color: #93c5fd;
        }

        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--blue);
            animation: pulse 1.8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.7); }
        }

        .hero-title {
            font-size: clamp(3rem, 6vw, 5.5rem);
            font-weight: 800;
            line-height: 1.0;
            letter-spacing: -0.04em;
            color: var(--ink);
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s 0.1s ease both;
        }

        .dark .hero-title { color: #f1f5f9; }

        .hero-title-accent {
            display: inline-block;
            background: linear-gradient(135deg, var(--blue) 0%, var(--cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: 1.125rem;
            line-height: 1.7;
            color: var(--ink-soft);
            max-width: 480px;
            margin-bottom: 2.5rem;
            font-weight: 300;
            animation: fadeUp 0.6s 0.2s ease both;
        }

        .dark .hero-sub { color: #64748b; }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeUp 0.6s 0.3s ease both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            background: var(--blue);
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            letter-spacing: 0.01em;
            box-shadow: 0 4px 24px rgba(37,99,235,0.3);
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(37,99,235,0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            background: transparent;
            color: var(--ink-mid);
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            text-decoration: none;
            transition: all 0.2s;
        }

        .dark .btn-secondary {
            color: #94a3b8;
            border-color: #1e293b;
        }

        .btn-secondary:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        /* Parking visual widget */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeUp 0.8s 0.2s ease both;
        }

        .parking-grid-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            width: 340px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
            position: relative;
        }

        .dark .parking-grid-card {
            background: #0f1a35;
            border-color: #1e293b;
            box-shadow: 0 24px 80px rgba(0,0,0,0.4);
        }

        .pgc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .pgc-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--ink);
        }

        .dark .pgc-title { color: #e2e8f0; }

        .pgc-live {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #10b981;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .pgc-live-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse 1.5s ease infinite;
        }

        .pgc-legend {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.7rem;
            color: var(--ink-soft);
            font-weight: 500;
        }

        .pgc-legend span { display: flex; align-items: center; gap: 4px; }
        .legend-dot { width: 8px; height: 8px; border-radius: 3px; }

        .pgc-spots {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
        }

        .spot {
            aspect-ratio: 1;
            border-radius: 6px;
            transition: transform 0.2s;
        }

        .spot:hover { transform: scale(1.1); }
        .spot.free { background: #dcfce7; border: 1.5px solid #86efac; }
        .spot.taken { background: #fee2e2; border: 1.5px solid #fca5a5; }
        .spot.reserved { background: #fef9c3; border: 1.5px solid #fde047; }

        .dark .spot.free { background: #052e16; border-color: #166534; }
        .dark .spot.taken { background: #450a0a; border-color: #991b1b; }
        .dark .spot.reserved { background: #422006; border-color: #92400e; }

        .pgc-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-top: 1.25rem;
        }

        .pgc-stat {
            background: var(--surface);
            border-radius: 10px;
            padding: 0.75rem;
            text-align: center;
        }

        .dark .pgc-stat { background: #0f172a; }

        .pgc-stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--blue);
            line-height: 1;
        }

        .pgc-stat-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--ink-soft);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 2px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── ABOUT ── */
        .about {
            padding: 7rem 2rem;
            background: var(--surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .dark .about {
            background: #0d1526;
            border-color: var(--border-dark);
        }

        .section-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--blue);
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.75rem, 3vw, 2.75rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--ink);
            margin-bottom: 1.25rem;
            line-height: 1.15;
        }

        .dark .section-title { color: #f1f5f9; }

        .about-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        @media (max-width: 768px) {
            .about-layout { grid-template-columns: 1fr; gap: 2.5rem; }
        }

        .about-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--ink-soft);
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .dark .about-body { color: #64748b; }

        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .tech-tag {
            padding: 0.35rem 0.9rem;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .tech-tag.laravel { background: #fef2f2; color: #dc2626; }
        .tech-tag.tailwind { background: #eff6ff; color: #2563eb; }
        .tech-tag.js { background: #fefce8; color: #ca8a04; }
        .tech-tag.mysql { background: #f0fdf4; color: #16a34a; }

        .dark .tech-tag.laravel { background: #450a0a; color: #f87171; }
        .dark .tech-tag.tailwind { background: #1e3a8a22; color: #93c5fd; }
        .dark .tech-tag.js { background: #422006; color: #fde047; }
        .dark .tech-tag.mysql { background: #052e16; color: #4ade80; }

        /* Right side decorative block */
        .about-deco {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .deco-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .dark .deco-card {
            background: #0f1a35;
            border-color: #1e293b;
        }

        .deco-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }

        .deco-card:first-child {
            grid-column: span 2;
        }

        .deco-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--blue-dim);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .dark .deco-icon { background: rgba(37,99,235,0.15); }

        .deco-icon svg { width: 20px; height: 20px; color: var(--blue); }

        .deco-card-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .dark .deco-card-title { color: #e2e8f0; }

        .deco-card-body {
            font-size: 0.8rem;
            color: var(--ink-soft);
            line-height: 1.6;
        }

        /* ── HOW IT WORKS ── */
        .how {
            padding: 7rem 2rem;
        }

        .how-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .how-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: end;
            margin-bottom: 4rem;
        }

        @media (max-width: 768px) {
            .how-header { grid-template-columns: 1fr; }
        }

        .how-steps {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1.5rem;
            position: relative;
        }

        @media (max-width: 900px) {
            .how-steps { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 500px) {
            .how-steps { grid-template-columns: 1fr; }
        }

        /* Connecting line */
        .how-steps::before {
            content: '';
            position: absolute;
            top: 28px;
            left: 28px;
            right: 28px;
            height: 1px;
            background: linear-gradient(90deg, var(--blue) 0%, var(--cyan) 100%);
            opacity: 0.2;
        }

        @media (max-width: 900px) {
            .how-steps::before { display: none; }
        }

        .step-card {
            background: transparent;
            padding: 1rem 0;
            position: relative;
        }

        .step-num {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: var(--blue-dim);
            border: 1px solid rgba(37,99,235,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--blue);
            margin-bottom: 1.25rem;
            transition: background 0.2s, transform 0.2s;
        }

        .dark .step-num {
            background: rgba(37,99,235,0.12);
            border-color: rgba(37,99,235,0.2);
        }

        .step-card:hover .step-num {
            background: var(--blue);
            color: #fff;
            transform: translateY(-4px);
        }

        .step-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.4rem;
        }

        .dark .step-title { color: #e2e8f0; }

        .step-body {
            font-size: 0.8rem;
            color: var(--ink-soft);
            line-height: 1.6;
        }

        /* ── RESERVATION BANNER ── */
        .reserve-banner {
            margin: 0 2rem 0;
            border-radius: 24px;
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 40%, #0891b2 100%);
            padding: 5rem 4rem;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .reserve-banner { padding: 3rem 2rem; margin: 0 1rem; }
        }

        .reserve-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .reserve-banner::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .reserve-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 3rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .reserve-inner { grid-template-columns: 1fr; }
        }

        .reserve-title {
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .reserve-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .reserve-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            font-weight: 400;
        }

        .reserve-check {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .reserve-check svg { width: 11px; height: 11px; color: #fff; }

        .reserve-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            min-width: 200px;
        }

        .btn-white {
            padding: 0.875rem 1.75rem;
            background: #fff;
            color: var(--blue);
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
            letter-spacing: 0.01em;
        }

        .btn-white:hover {
            background: #eff6ff;
            transform: translateY(-2px);
        }

        .btn-outline-white {
            padding: 0.875rem 1.75rem;
            background: transparent;
            color: rgba(255,255,255,0.85);
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 10px;
            border: 1.5px solid rgba(255,255,255,0.3);
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-outline-white:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
        }

        /* ── TEAM ── */
        .team {
            padding: 7rem 2rem;
            background: var(--surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            margin-top: 0;
        }

        .dark .team {
            background: #0d1526;
            border-color: var(--border-dark);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-top: 3.5rem;
        }

        @media (max-width: 900px) {
            .team-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 500px) {
            .team-grid { grid-template-columns: 1fr; }
        }

        .member-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .dark .member-card {
            background: #0f1a35;
            border-color: #1e293b;
        }

        .member-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .member-card:hover::before { opacity: 1; }
        .member-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px rgba(0,0,0,0.08); }

        .member-card.blue::before { background: linear-gradient(90deg, var(--blue), var(--cyan)); }
        .member-card.emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .member-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
        .member-card.orange::before { background: linear-gradient(90deg, #f97316, #fb923c); }

        .member-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 auto 1.25rem;
            transition: transform 0.25s;
        }

        .member-card:hover .member-avatar { transform: scale(1.08); }

        .member-avatar.blue { background: #dbeafe; color: var(--blue); }
        .member-avatar.emerald { background: #d1fae5; color: #059669; }
        .member-avatar.purple { background: #ede9fe; color: #7c3aed; }
        .member-avatar.orange { background: #ffedd5; color: #ea580c; }

        .dark .member-avatar.blue { background: #1e3a8a22; color: #93c5fd; }
        .dark .member-avatar.emerald { background: #052e1620; color: #6ee7b7; }
        .dark .member-avatar.purple { background: #4c1d9520; color: #c4b5fd; }
        .dark .member-avatar.orange { background: #431407; color: #fdba74; }

        .member-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .dark .member-name { color: #e2e8f0; }

        .member-role {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .member-role.blue { color: var(--blue); }
        .member-role.emerald { color: #059669; }
        .member-role.purple { color: #7c3aed; }
        .member-role.orange { color: #ea580c; }

        /* ── FEATURES ── */
        .features {
            padding: 7rem 2rem;
        }

        .features-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 3rem;
        }

        .feature-tag {
            padding: 0.65rem 1.25rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--ink-mid);
            transition: all 0.2s;
            cursor: default;
        }

        .dark .feature-tag {
            background: #0f1a35;
            border-color: #1e293b;
            color: #94a3b8;
        }

        .feature-tag:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-dim);
        }

        .dark .feature-tag:hover {
            background: rgba(37,99,235,0.08);
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--ink);
            color: #94a3b8;
            padding: 4rem 2rem;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .footer-logo {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.03em;
        }

        .footer-logo span { color: var(--blue-light); }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-link {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover { color: #fff; }

        .footer-link svg { width: 16px; height: 16px; }

        .footer-divider {
            width: 100%;
            height: 1px;
            background: #1e293b;
        }

        .footer-copy {
            font-size: 0.8rem;
            color: #475569;
            text-align: center;
        }

        /* Scroll animation */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav class="nav">
        <div class="logo">Smart<span>Parking</span></div>
        <div class="nav-links">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-nav">Register</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-orb"></div>
        <div class="hero-inner">
            <div>
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    The Future of Parking
                </div>
                <h1 class="hero-title">
                    Smart<span class="hero-title-accent">Parking</span><br>
                    starts here.
                </h1>
                <p class="hero-sub">
                    Realtime availability at your fingertips. Discover, reserve, and manage your parking — completely seamlessly.
                </p>
                <div class="hero-actions">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">Admin Dashboard</a>
                        @else
                            <a href="{{ route('user.reserve') }}" class="btn-primary">
                                Reserve a Spot
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="btn-secondary">View Availability</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            Reserve a Spot
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary">View Availability</a>
                    @endauth
                </div>
            </div>
            <div class="hero-visual">
                <div class="parking-grid-card">
                    <div class="pgc-header">
                        <div class="pgc-title">Lot A — Level 2</div>
                        <div class="pgc-live"><span class="pgc-live-dot"></span> Live</div>
                    </div>
                    <div class="pgc-legend">
                        <span><span class="legend-dot" style="background:#86efac"></span> Free</span>
                        <span><span class="legend-dot" style="background:#fca5a5"></span> Taken</span>
                        <span><span class="legend-dot" style="background:#fde047"></span> Reserved</span>
                    </div>
                    <div class="pgc-spots" id="spotGrid"></div>
                    <div class="pgc-stats">
                        <div class="pgc-stat">
                            <div class="pgc-stat-num" id="freeCount">12</div>
                            <div class="pgc-stat-label">Available</div>
                        </div>
                        <div class="pgc-stat">
                            <div class="pgc-stat-num" style="color:#ef4444" id="takenCount">8</div>
                            <div class="pgc-stat-label">Occupied</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="about">
        <div class="section-inner">
            <div class="about-layout">
                <div class="reveal">
                    <div class="section-label">About the Project</div>
                    <h2 class="section-title">What is SmartParking?</h2>
                    <p class="about-body">
                        A modern smart parking management system built to show realtime parking availability and allow users to reserve spaces effortlessly. The platform features an integrated fictional payment system to simulate top-tier user experiences.
                    </p>
                    <div class="tech-stack">
                        <span class="tech-tag laravel">Laravel</span>
                        <span class="tech-tag tailwind">Tailwind CSS</span>
                        <span class="tech-tag js">JavaScript</span>
                        <span class="tech-tag mysql">MySQL</span>
                    </div>
                </div>
                <div class="about-deco reveal reveal-delay-2">
                    <div class="deco-card">
                        <div class="deco-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <div class="deco-card-title">Realtime Availability</div>
                        <div class="deco-card-body">Live updates across all parking lots — always know exactly what's free.</div>
                    </div>
                    <div class="deco-card">
                        <div class="deco-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div class="deco-card-title">Secure Auth</div>
                        <div class="deco-card-body">Role-based access for users and administrators.</div>
                    </div>
                    <div class="deco-card">
                        <div class="deco-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div class="deco-card-title">Payment Flow</div>
                        <div class="deco-card-body">Simulated checkout experience end-to-end.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how">
        <div class="how-inner">
            <div class="how-header">
                <div class="reveal">
                    <div class="section-label">Process</div>
                    <h2 class="section-title">How It Works</h2>
                </div>
                <p class="reveal reveal-delay-1" style="font-size:1rem;color:var(--ink-soft);line-height:1.7;font-weight:300;">
                    From sign-up to your reserved spot — five simple steps, done in minutes.
                </p>
            </div>
            <div class="how-steps">
                <div class="step-card reveal reveal-delay-1">
                    <div class="step-num">1</div>
                    <div class="step-title">Create an account</div>
                    <div class="step-body">Sign up securely with your details.</div>
                </div>
                <div class="step-card reveal reveal-delay-2">
                    <div class="step-num">2</div>
                    <div class="step-title">View available spots</div>
                    <div class="step-body">Check real-time availability across lots.</div>
                </div>
                <div class="step-card reveal reveal-delay-3">
                    <div class="step-num">3</div>
                    <div class="step-title">Reserve a space</div>
                    <div class="step-body">Pick your preferred spot instantly.</div>
                </div>
                <div class="step-card reveal reveal-delay-4">
                    <div class="step-num">4</div>
                    <div class="step-title">Complete payment</div>
                    <div class="step-body">Simulate via fictional gateway.</div>
                </div>
                <div class="step-card reveal reveal-delay-4">
                    <div class="step-num">5</div>
                    <div class="step-title">Manage easily</div>
                    <div class="step-body">View or cancel anytime from your dashboard.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- RESERVATION BANNER -->
    <div style="padding: 0 2rem 5rem;">
        <div class="reserve-banner reveal">
            <div class="reserve-inner">
                <div>
                    <h2 class="reserve-title">Ready to park smarter?</h2>
                    <ul class="reserve-list">
                        <li>
                            <div class="reserve-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            Logged-in users can reserve parking spaces
                        </li>
                        <li>
                            <div class="reserve-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            View and manage your active reservations
                        </li>
                        <li>
                            <div class="reserve-check"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                            Cancel anytime before your session starts
                        </li>
                        <li>
                            <div class="reserve-check" style="background:rgba(255,255,255,0.08)"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity:0.6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            Public visitors can only view availability
                        </li>
                    </ul>
                </div>
                <div class="reserve-actions">
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('user.reservations') }}" class="btn-white">My Reservations</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-white">Log In</a>
                        <a href="{{ route('register') }}" class="btn-outline-white">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- TEAM -->
    <section class="team">
        <div class="section-inner">
            <div class="reveal" style="text-align:center; max-width:500px; margin:0 auto;">
                <div class="section-label" style="text-align:center;">The People</div>
                <h2 class="section-title" style="text-align:center;">Developer Team</h2>
                <p style="color:var(--ink-soft);font-size:0.95rem;line-height:1.7;font-weight:300;margin-top:0.5rem;">
                    Collaborated heavily on security, integration, testing, and comprehensive documentation.
                </p>
            </div>
            <div class="team-grid">
                <div class="member-card blue reveal reveal-delay-1">
                    <div class="member-avatar blue">A</div>
                    <div class="member-name">Adem</div>
                    <div class="member-role blue">Backend & Database</div>
                </div>
                <div class="member-card emerald reveal reveal-delay-2">
                    <div class="member-avatar emerald">S</div>
                    <div class="member-name">Salim</div>
                    <div class="member-role emerald">Frontend & Design</div>
                </div>
                <div class="member-card purple reveal reveal-delay-3">
                    <div class="member-avatar purple">S</div>
                    <div class="member-name">Sjoerd</div>
                    <div class="member-role purple">Frontend & Backend</div>
                </div>
                <div class="member-card orange reveal reveal-delay-4">
                    <div class="member-avatar orange">M</div>
                    <div class="member-name">Mokhless</div>
                    <div class="member-role orange">Frontend & Backend</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features">
        <div class="section-inner">
            <div class="reveal" style="max-width:480px;">
                <div class="section-label">Capabilities</div>
                <h2 class="section-title">System Features</h2>
            </div>
            <div class="features-grid reveal reveal-delay-1">
                <span class="feature-tag">Realtime parking availability</span>
                <span class="feature-tag">Secure authentication</span>
                <span class="feature-tag">Admin dashboard</span>
                <span class="feature-tag">Reservation system</span>
                <span class="feature-tag">Responsive design</span>
                <span class="feature-tag">Fictional payment integration</span>
                <span class="feature-tag">Reservation management</span>
                <span class="feature-tag">Role-based access control</span>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-logo">Smart<span>Parking</span></div>
            <div class="footer-links">
                <a href="#" class="footer-link">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    GitHub
                </a>
                <a href="#" class="footer-link">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    Figma
                </a>
            </div>
            <div class="footer-divider"></div>
            <p class="footer-copy">&copy; {{ date('Y') }} SmartParking. Built by Adem, Salim, Sjoerd & Mokhless.</p>
        </div>
    </footer>

    <script>
        // ── Spot grid animation ──
        const spotStates = ['free','free','free','taken','free','free','reserved','taken','free','free','taken','free','free','free','taken','free','taken','reserved','free','free'];
        const grid = document.getElementById('spotGrid');
        if (grid) {
            spotStates.forEach((s, i) => {
                const el = document.createElement('div');
                el.className = `spot ${s}`;
                el.style.animationDelay = `${i * 60}ms`;
                grid.appendChild(el);
            });
        }

        // Animate spot counts
        function animateCount(el, target) {
            let current = 0;
            const step = target / 20;
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = Math.round(current);
                if (current >= target) clearInterval(timer);
            }, 40);
        }

        const freeEl = document.getElementById('freeCount');
        const takenEl = document.getElementById('takenCount');
        if (freeEl) animateCount(freeEl, 12);
        if (takenEl) animateCount(takenEl, 8);

        // Randomize a spot periodically to simulate live updates
        setInterval(() => {
            const spots = document.querySelectorAll('.spot');
            if (!spots.length) return;
            const idx = Math.floor(Math.random() * spots.length);
            const states = ['free','free','taken','reserved'];
            const newState = states[Math.floor(Math.random() * states.length)];
            spots[idx].className = `spot ${newState}`;
        }, 2200);

        // ── Scroll reveal ──
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ── Dark mode check (optional — respects OS preference) ──
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.body.classList.add('dark');
        }
    </script>
</body>
</html>