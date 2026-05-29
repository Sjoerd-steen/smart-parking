<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartParking - De toekomst van parkeren</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #2563eb;
            --accent: #06b6d4;
            --ink: #0f172a;
            --ink-mid: #334155;
            --ink-soft: #64748b;
            --surface: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
        }

        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px) saturate(1.5);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--ink);
        }

        .navbar-brand span { 
            color: var(--primary); 
        }

        .navbar-center {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .navbar-center { display: none; }
        }

        .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--ink-mid);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .nav-link:hover { 
            color: var(--primary); 
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .language-switcher {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(37, 99, 235, 0.05);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink-mid);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .language-switcher:hover {
            background: rgba(37, 99, 235, 0.12);
            border-color: var(--primary);
        }

        .btn-signin {
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            background: transparent;
            color: var(--ink-mid);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-signin:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-signup {
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-signup:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        /* ── HERO SECTION ── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 2rem 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #f0f9ff 0%, #f5f3ff 50%, #fef2f2 100%);
            z-index: -2;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15), transparent 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            z-index: -1;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-40px) translateX(20px); }
        }

        .hero-container {
            max-width: 1280px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        .hero-content h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            line-height: 1.1;
            color: var(--ink);
            margin-bottom: 1.5rem;
            animation: slideUp 0.8s ease 0.1s both;
        }

        .hero-content h1 .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content .tagline {
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--ink-soft);
            margin-bottom: 2.5rem;
            font-weight: 300;
            animation: slideUp 0.8s ease 0.2s both;
        }

        .hero-cta {
            display: flex;
            gap: 1.25rem;
            flex-wrap: wrap;
            animation: slideUp 0.8s ease 0.3s both;
        }

        @media (max-width: 640px) {
            .hero-cta { flex-direction: column; }
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: var(--primary);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(37, 99, 235, 0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: white;
            color: var(--ink);
            font-weight: 700;
            font-size: 1rem;
            border-radius: 12px;
            text-decoration: none;
            border: 2px solid var(--border);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            animation: slideUp 0.8s ease 0.4s both;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .hero-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .hero-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
        }

        .live-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #10b981;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .parking-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 1.5rem;
        }

        .parking-slot {
            aspect-ratio: 1;
            border-radius: 8px;
            border: 2px solid;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .parking-slot:hover { transform: scale(1.15); }
        .parking-slot.free { background: #dcfce7; border-color: #86efac; }
        .parking-slot.occupied { background: #fee2e2; border-color: #fca5a5; }
        .parking-slot.reserved { background: #fef9c3; border-color: #fde047; }

        .hero-card-legend {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--ink-soft);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-box {
            width: 10px;
            height: 10px;
            border-radius: 4px;
        }

        .hero-card-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-item {
            background: rgba(37, 99, 235, 0.05);
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
        }

        .stat-num {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-top: 0.5rem;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── SECTIONS ── */
        section { position: relative; z-index: 10; }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-label {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.1;
            color: var(--ink);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.05rem;
            line-height: 1.7;
            color: var(--ink-soft);
            font-weight: 300;
        }

        /* ── WHY CHOOSE US ── */
        .why-section {
            padding: 7rem 2rem;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            border-bottom: 1px solid var(--border);
        }

        .why-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .why-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 640px) {
            .why-grid { grid-template-columns: 1fr; }
        }

        .feature-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover::before { opacity: 1; }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(6, 182, 212, 0.1));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.75rem;
        }

        .feature-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--ink-soft);
        }

        /* ── HOW IT WORKS ── */
        .how-section {
            padding: 7rem 2rem;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .how-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {
            .how-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 640px) {
            .how-grid { grid-template-columns: 1fr; }
        }

        .step-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .step-card:hover {
            border-color: var(--primary);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.12);
        }

        .step-number {
            width: 50px;
            height: 50px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            transition: transform 0.3s ease;
        }

        .step-card:hover .step-number { transform: scale(1.1) rotate(5deg); }

        .step-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.75rem;
        }

        .step-text {
            font-size: 0.9rem;
            color: var(--ink-soft);
            line-height: 1.6;
        }

        /* ── STATS SECTION ── */
        .stats-section {
            padding: 7rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .stats-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
        }

        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

        .stat-block-number {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-block-label {
            font-size: 0.95rem;
            font-weight: 500;
            opacity: 0.95;
        }

        /* ── CTA SECTION ── */
        .cta-section {
            padding: 7rem 2rem;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .cta-inner {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 24px;
            padding: 5rem 3rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-inner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .cta-text {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .cta-buttons {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-white {
            padding: 0.9rem 2rem;
            background: white;
            color: var(--primary);
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-white {
            padding: 0.9rem 2rem;
            background: transparent;
            color: white;
            font-weight: 700;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: white;
        }

        /* ── TEAM SECTION ── */
        .team-section {
            padding: 7rem 2rem;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .team-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .team-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .team-grid { grid-template-columns: 1fr; }
        }

        .team-member {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .member-avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: white;
        }

        .member-avatar.blue { background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .member-avatar.green { background: linear-gradient(135deg, #10b981, #34d399); }
        .member-avatar.purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
        .member-avatar.orange { background: linear-gradient(135deg, #f97316, #fb923c); }

        .member-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.5rem;
        }

        .member-role {
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            display: inline-block;
        }

        /* ── FEATURES SECTION ── */
        .features-section {
            padding: 7rem 2rem;
        }

        .features-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.8rem 1.5rem;
            background: rgba(37, 99, 235, 0.05);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink-mid);
            transition: all 0.2s ease;
        }

        .feature-badge:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.12);
            color: var(--primary);
        }

        /* ── FOOTER ── */
        .footer {
            background: var(--ink);
            color: #94a3b8;
            padding: 5rem 2rem 2rem;
            border-top: 1px solid #1e293b;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 1024px) {
            .footer-content { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .footer-content { grid-template-columns: 1fr; }
        }

        .footer-col h4 {
            font-size: 0.95rem;
            color: white;
            margin-bottom: 1.25rem;
            font-weight: 700;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.75rem;
        }

        .footer-col a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .footer-col a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid #1e293b;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .footer-logo {
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
        }

        .footer-logo span {
            color: var(--primary);
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: white;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-brand">Smart<span>Parking</span></div>
    
    <div class="navbar-center">
        <a href="#features" class="nav-link">Functies</a>
        <a href="#team" class="nav-link">Team</a>
        <a href="#how" class="nav-link">Hoe het werkt</a>
    </div>

    <div class="navbar-right">
        <div class="language-switcher" onclick="toggleLanguage()">
            <span id="langBtn">🇳🇱 NL</span>
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </div>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn-signin">Dashboard</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn-signin">Dashboard</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-signin">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-signup">Begin nu</a>
            @endif
        @endauth
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <h1>
                Parkeren wordt <span class="gradient-text">slim.</span><br>
                Stress wordt <span class="gradient-text">nul.</span>
            </h1>
            <p class="tagline">
                Realtime beschikbaarheid, instant reserveren, totale controle. SmartParking maakt parkeren moeiteloos en stresvrij.
            </p>
            <div class="hero-cta">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary">Admin Dashboard</a>
                    @else
                        <a href="{{ route('user.reserve') }}" class="btn-primary">
                            Reserveer nu
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn-secondary">Beschikbaarheid zien</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        Reserveer nu
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary">Beschikbaarheid zien</a>
                @endauth
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card">
                <div class="hero-card-header">
                    <div class="hero-card-title">Parkeerterrein A - Niveau 2</div>
                    <div class="live-badge">
                        <span class="live-dot"></span>
                        Live
                    </div>
                </div>

                <div class="hero-card-legend">
                    <div class="legend-item">
                        <div class="legend-box" style="background: #86efac;"></div>
                        Vrij
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #fca5a5;"></div>
                        Bezet
                    </div>
                    <div class="legend-item">
                        <div class="legend-box" style="background: #fde047;"></div>
                        Gereserveerd
                    </div>
                </div>

                <div class="parking-grid" id="parkingGrid"></div>

                <div class="hero-card-stats">
                    <div class="stat-item">
                        <div class="stat-num" id="freeCount">12</div>
                        <div class="stat-label">Beschikbaar</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num" style="color: #ef4444;" id="occupiedCount">8</div>
                        <div class="stat-label">Bezet</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="why-section">
    <div class="section-header reveal">
        <div class="section-label">Voordelen</div>
        <h2 class="section-title">Waarom SmartParking?</h2>
        <p class="section-subtitle">We maken parkeren niet alleen gemakkelijker, maar ook slimmer en veiliger.</p>
    </div>

    <div class="why-grid">
        <div class="feature-card reveal delay-1">
            <div class="feature-icon">⚡</div>
            <h3 class="feature-title">Realtime Beschikbaarheid</h3>
            <p class="feature-text">Weet altijd exact hoeveel plaatsen vrij zijn. Live updates, geen wachten, geen stress.</p>
        </div>

        <div class="feature-card reveal delay-2">
            <div class="feature-icon">⚙️</div>
            <h3 class="feature-title">1 Klik Reserveren</h3>
            <p class="feature-text">Je plek is binnen enkele seconden gereserveerd. Geen gedoe, geen omslachtig proces.</p>
        </div>

        <div class="feature-card reveal delay-3">
            <div class="feature-icon">🔒</div>
            <h3 class="feature-title">Veilig & Secure</h3>
            <p class="feature-text">Enterprise-grade encryptie. Je gegevens zijn in veilige handen. Altijd beveiligd.</p>
        </div>

        <div class="feature-card reveal delay-1">
            <div class="feature-icon">📱</div>
            <h3 class="feature-title">100% Responsive</h3>
            <p class="feature-text">Perfecte ervaring op alle apparaten. Desktop, tablet, telefoon — alles werkt perfect.</p>
        </div>

        <div class="feature-card reveal delay-2">
            <div class="feature-icon">💳</div>
            <h3 class="feature-title">Veilige Betaling</h3>
            <p class="feature-text">Integratie met beveiligde betaalsystemen. Snel, veilig en betrouwbaar.</p>
        </div>

        <div class="feature-card reveal delay-3">
            <div class="feature-icon">📊</div>
            <h3 class="feature-title">Volledig Beheer</h3>
            <p class="feature-text">Manage al je reserveringen. Wijzig, annuleer of bekijk je geschiedenis — alles op één plek.</p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section" id="how">
    <div class="section-header reveal">
        <div class="section-label">Process</div>
        <h2 class="section-title">Hoe werkt het?</h2>
        <p class="section-subtitle">5 simpele stappen naar je gereserveerde plek.</p>
    </div>

    <div class="how-grid">
        <div class="step-card reveal delay-1">
            <div class="step-number">1</div>
            <h3 class="step-title">Account aanmaken</h3>
            <p class="step-text">Registreer met je e-mailadres en maak een veilig account.</p>
        </div>

        <div class="step-card reveal delay-2">
            <div class="step-number">2</div>
            <h3 class="step-title">Bekijk beschikbaarheid</h3>
            <p class="step-text">Zie in real-time welke parkeerplaatsen vrij zijn.</p>
        </div>

        <div class="step-card reveal delay-3">
            <div class="step-number">3</div>
            <h3 class="step-title">Reserveer je plek</h3>
            <p class="step-text">Kies je voorkeursplek en plaats je reservering.</p>
        </div>

        <div class="step-card reveal delay-4">
            <div class="step-number">4</div>
            <h3 class="step-title">Betaal veilig</h3>
            <p class="step-text">Voltooi je betaling via onze beveiligde gateway.</p>
        </div>

        <div class="step-card reveal delay-5">
            <div class="step-number">5</div>
            <h3 class="step-title">Klaar!</h3>
            <p class="step-text">Je reservering is bevestigd. Parkeerplek secured.</p>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="stats-section reveal">
    <div class="stats-grid">
        <div>
            <div class="stat-block-number">50K+</div>
            <div class="stat-block-label">Gebruikers</div>
        </div>
        <div>
            <div class="stat-block-number">10K+</div>
            <div class="stat-block-label">Reserveringen/Maand</div>
        </div>
        <div>
            <div class="stat-block-number">99.9%</div>
            <div class="stat-block-label">Uptime</div>
        </div>
        <div>
            <div class="stat-block-number">24/7</div>
            <div class="stat-block-label">Support</div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <div class="cta-inner reveal">
        <h2 class="cta-title">Klaar voor slim parkeren?</h2>
        <p class="cta-text">Sluit je aan bij duizenden gebruikers die al hun parkeerprobleem hebben opgelost.</p>
        <div class="cta-buttons">
            @auth
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('user.reserve') }}" class="btn-white">Nu reserveren</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-white">Gratis starten</a>
                <a href="{{ route('login') }}" class="btn-outline-white">Al lid? Log in</a>
            @endauth
        </div>
    </div>
</section>

<!-- TEAM SECTION -->
<section class="team-section" id="team">
    <div class="section-header reveal">
        <div class="section-label">Team</div>
        <h2 class="section-title">Bouwers van SmartParking</h2>
        <p class="section-subtitle">Een getalenteerd team dat samen iets speciaals heeft gecreëerd.</p>
    </div>

    <div class="team-grid">
        <div class="team-member reveal delay-1">
            <div class="member-avatar blue">A</div>
            <h3 class="member-name">Adem</h3>
            <div class="member-role">Backend & Database</div>
        </div>

        <div class="team-member reveal delay-2">
            <div class="member-avatar green">S</div>
            <h3 class="member-name">Salim</h3>
            <div class="member-role">Frontend & Design</div>
        </div>

        <div class="team-member reveal delay-3">
            <div class="member-avatar purple">S</div>
            <h3 class="member-name">Sjoerd</h3>
            <div class="member-role">Frontend & Backend</div>
        </div>

        <div class="team-member reveal delay-4">
            <div class="member-avatar orange">M</div>
            <h3 class="member-name">Mokhless</h3>
            <div class="member-role">Frontend & Backend</div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section" id="features">
    <div class="section-header reveal">
        <div class="section-label">Mogelijkheden</div>
        <h2 class="section-title">Alle Features</h2>
        <p class="section-subtitle">Volledig uitgerust met alles wat je nodig hebt.</p>
    </div>

    <div class="features-grid reveal delay-1">
        <span class="feature-badge">Realtime beschikbaarheid</span>
        <span class="feature-badge">Veilige authenticatie</span>
        <span class="feature-badge">Admin dashboard</span>
        <span class="feature-badge">Geavanceerd reserveeringsysteem</span>
        <span class="feature-badge">Responsief design</span>
        <span class="feature-badge">Veilig betaalsysteem</span>
        <span class="feature-badge">Reserverings management</span>
        <span class="feature-badge">Rol-gebaseerde toegang</span>
        <span class="feature-badge">Gebruikersbeheering</span>
        <span class="feature-badge">Voertuig management</span>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-content">
            <div class="footer-col">
                <h4>Product</h4>
                <ul>
                    <li><a href="#features">Functies</a></li>
                    <li><a href="#how">Hoe het werkt</a></li>
                    <li><a href="#team">Team</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    <li><a href="{{ route('login') }}">Inloggen</a></li>
                    <li><a href="{{ route('register') }}">Registreren</a></li>
                    <li><a href="#">Contacteer ons</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Technologie</h4>
                <ul>
                    <li><a href="#">Laravel</a></li>
                    <li><a href="#">Tailwind CSS</a></li>
                    <li><a href="#">MySQL</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Over</h4>
                <ul>
                    <li><a href="#">Over SmartParking</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-logo">Smart<span>Parking</span></div>
            <div class="footer-links">
                <a href="#" class="footer-link">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
                    GitHub
                </a>
                <a href="#" class="footer-link">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Figma
                </a>
            </div>
        </div>

        <div style="border-top: 1px solid #1e293b; padding-top: 2rem; margin-top: 2rem; width: 100%; text-align: center; font-size: 0.85rem; color: #64748b;">
            &copy; {{ date('Y') }} SmartParking. Gebouwd door Adem, Salim, Sjoerd & Mokhless. | Alle rechten voorbehouden.
        </div>
    </div>
</footer>

<script>
    const parkingStates = ['free', 'free', 'free', 'occupied', 'free', 'free', 'reserved', 'occupied', 'free', 'free', 'occupied', 'free', 'free', 'free', 'occupied', 'free', 'occupied', 'reserved', 'free', 'free'];
    const grid = document.getElementById('parkingGrid');
    if (grid) {
        parkingStates.forEach((state, i) => {
            const slot = document.createElement('div');
            slot.className = `parking-slot ${state}`;
            grid.appendChild(slot);
        });
    }

    function animateCounter(el, target) {
        let current = 0;
        const step = target / 20;
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = Math.round(current);
            if (current >= target) clearInterval(timer);
        }, 30);
    }

    const freeCountEl = document.getElementById('freeCount');
    const occupiedCountEl = document.getElementById('occupiedCount');
    if (freeCountEl) animateCounter(freeCountEl, 12);
    if (occupiedCountEl) animateCounter(occupiedCountEl, 8);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    setInterval(() => {
        const slots = document.querySelectorAll('.parking-slot');
        if (!slots.length) return;
        const idx = Math.floor(Math.random() * slots.length);
        const states = ['free', 'free', 'free', 'occupied', 'reserved'];
        const newState = states[Math.floor(Math.random() * states.length)];
        slots[idx].className = `parking-slot ${newState}`;
    }, 3000);

    function toggleLanguage() {
        const btn = document.getElementById('langBtn');
        const currentLang = btn.textContent.includes('NL') ? 'NL' : 'EN';
        if (currentLang === 'NL') {
            btn.textContent = '🇬🇧 EN';
        } else {
            btn.textContent = '🇳🇱 NL';
        }
    }
</script>

</body>
</html>
