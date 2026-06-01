<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartParking — De toekomst van parkeren</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ─────────────────────────────────────────────
           DESIGN TOKENS
        ───────────────────────────────────────────── */
        :root {
            --primary:        #2563eb;
            --primary-dark:   #1d4ed8;
            --primary-light:  #3b82f6;
            --accent:         #06b6d4;
            --accent-dark:    #0891b2;
            --ink:            #0f172a;
            --ink-mid:        #334155;
            --ink-soft:       #64748b;
            --ink-faint:      #94a3b8;
            --surface:        #f8fafc;
            --surface-2:      #f1f5f9;
            --white:          #ffffff;
            --border:         #e2e8f0;
            --border-soft:    rgba(226,232,240,0.6);
            --grad-brand:     linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            --grad-hero:      linear-gradient(160deg, #f0f7ff 0%, #fafcff 40%, #f0fdff 70%, #f5f3ff 100%);
            --shadow-sm:      0 2px 8px rgba(15,23,42,.06);
            --shadow-md:      0 8px 28px rgba(15,23,42,.09);
            --shadow-lg:      0 20px 60px rgba(15,23,42,.12);
            --shadow-brand:   0 8px 32px rgba(37,99,235,.28);
            --r-sm:  10px;
            --r-md:  16px;
            --r-lg:  24px;
            --r-xl:  32px;
        }

        /* ─────────────────────────────────────────────
           RESET & BASE
        ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            letter-spacing: -0.025em;
            line-height: 1.1;
        }

        a { text-decoration: none; }

        /* ─────────────────────────────────────────────
           UTILITY
        ───────────────────────────────────────────── */
        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .gradient-text {
            background: var(--grad-brand);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ─────────────────────────────────────────────
           REVEAL ANIMATIONS
        ───────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .65s cubic-bezier(.22,1,.36,1), transform .65s cubic-bezier(.22,1,.36,1);
        }
        .reveal.visible { opacity: 1; transform: none; }
        .delay-1 { transition-delay: .08s; }
        .delay-2 { transition-delay: .16s; }
        .delay-3 { transition-delay: .24s; }
        .delay-4 { transition-delay: .32s; }
        .delay-5 { transition-delay: .40s; }

        /* ─────────────────────────────────────────────
           NAVBAR
        ───────────────────────────────────────────── */
        .navbar {
            position: fixed;
            inset: 0 0 auto;
            z-index: 200;
            padding: .9rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background .3s, box-shadow .3s, backdrop-filter .3s;
        }

        .navbar.scrolled {
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(24px) saturate(1.6);
            box-shadow: 0 1px 0 var(--border), var(--shadow-sm);
        }

        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .navbar-brand .brand-icon {
            width: 34px; height: 34px;
            background: var(--grad-brand);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }
        .navbar-brand .brand-icon svg { color: white; }
        .navbar-brand span { color: var(--primary); }

        .navbar-center {
            display: flex;
            align-items: center;
            gap: 2.2rem;
        }
        @media (max-width: 768px) { .navbar-center { display: none; } }

        .nav-link {
            font-size: .875rem;
            font-weight: 500;
            color: var(--ink-mid);
            transition: color .2s;
        }
        .nav-link:hover { color: var(--primary); }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .lang-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem .9rem;
            background: transparent;
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            font-size: .8rem;
            font-weight: 600;
            color: var(--ink-mid);
            cursor: pointer;
            transition: all .2s;
        }
        .lang-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(37,99,235,.05);
        }

        .btn-ghost {
            font-size: .875rem;
            font-weight: 600;
            padding: .5rem 1.1rem;
            background: transparent;
            color: var(--ink-mid);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            cursor: pointer;
            transition: all .2s;
            display: inline-flex; align-items: center;
        }
        .btn-ghost:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            padding: .6rem 1.4rem;
            background: var(--grad-brand);
            color: white;
            font-weight: 700;
            font-size: .875rem;
            border-radius: var(--r-sm);
            border: none;
            cursor: pointer;
            transition: all .28s cubic-bezier(.22,1,.36,1);
            box-shadow: var(--shadow-brand);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0);
            transition: background .2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(37,99,235,.38);
        }
        .btn-primary:hover::after { background: rgba(255,255,255,.08); }

        .btn-primary-lg {
            padding: .9rem 2.1rem;
            font-size: 1rem;
            border-radius: var(--r-md);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            padding: .9rem 2.1rem;
            background: white;
            color: var(--ink-mid);
            font-weight: 600;
            font-size: 1rem;
            border-radius: var(--r-md);
            border: 1.5px solid var(--border);
            cursor: pointer;
            transition: all .28s cubic-bezier(.22,1,.36,1);
        }
        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(37,99,235,.04);
            transform: translateY(-2px);
        }

        /* ─────────────────────────────────────────────
           PAGE BACKGROUND
           Soft grain + mesh gradient — premium, clean
        ───────────────────────────────────────────── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -2;
            background:
                radial-gradient(ellipse 80% 50% at 20% 10%, rgba(37,99,235,.07) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 80% 5%, rgba(6,182,212,.06) 0%, transparent 55%),
                radial-gradient(ellipse 50% 60% at 50% 90%, rgba(139,92,246,.05) 0%, transparent 60%),
                #f8fafc;
            pointer-events: none;
        }
        /* Subtle noise grain overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            opacity: .022;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 200px 200px;
            pointer-events: none;
        }

        /* ─────────────────────────────────────────────
           HERO — Full-width premium SaaS style
        ───────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 130px 2rem 80px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        /* Ambient orbs in hero */
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            will-change: transform;
        }
        .hero-orb-1 {
            width: 680px; height: 680px;
            background: radial-gradient(circle, rgba(37,99,235,.13) 0%, transparent 65%);
            top: -180px; left: -140px;
            animation: orbFloat1 10s ease-in-out infinite;
        }
        .hero-orb-2 {
            width: 520px; height: 520px;
            background: radial-gradient(circle, rgba(6,182,212,.10) 0%, transparent 65%);
            bottom: 60px; right: -100px;
            animation: orbFloat2 12s ease-in-out infinite;
        }
        .hero-orb-3 {
            width: 340px; height: 340px;
            background: radial-gradient(circle, rgba(139,92,246,.09) 0%, transparent 65%);
            top: 35%; left: 55%;
            animation: orbFloat3 14s ease-in-out infinite;
        }
        @keyframes orbFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(35px,45px)} }
        @keyframes orbFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-40px,-25px)} }
        @keyframes orbFloat3 { 0%,100%{transform:translate(0,0)} 33%{transform:translate(25px,18px)} 66%{transform:translate(-18px,-12px)} }

        /* Dot grid texture on hero */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(37,99,235,.09) 1px, transparent 1px);
            background-size: 36px 36px;
            mask-image: radial-gradient(ellipse 85% 85% at 50% 50%, black 30%, transparent 100%);
            pointer-events: none;
        }

        /* Hero content wrapper */
        .hero-content-wrap {
            position: relative;
            z-index: 10;
            max-width: 860px;
            margin: 0 auto;
            animation: fadeSlideUp .7s ease .1s both;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .4rem 1rem;
            background: rgba(37,99,235,.08);
            border: 1px solid rgba(37,99,235,.2);
            border-radius: 100px;
            font-size: .8rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 1.6rem;
        }
        .hero-badge-dot {
            width: 6px; height: 6px;
            background: var(--primary);
            border-radius: 50%;
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

        .hero-h1 {
            font-size: clamp(2.8rem, 5.5vw, 5rem);
            color: var(--ink);
            margin-bottom: 1.4rem;
            animation: fadeSlideUp .7s ease .18s both;
        }

        .hero-sub {
            font-size: 1.2rem;
            color: var(--ink-soft);
            font-weight: 300;
            line-height: 1.75;
            max-width: 580px;
            margin: 0 auto 2.4rem;
            animation: fadeSlideUp .7s ease .26s both;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeSlideUp .7s ease .34s both;
        }
        @media (max-width: 480px) { .hero-cta { flex-direction: column; align-items: center; } }

        .hero-social-proof {
            margin-top: 2.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            animation: fadeSlideUp .7s ease .42s both;
        }
        .hero-avatars { display: flex; }
        .hero-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            border: 2.5px solid white;
            background: var(--grad-brand);
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; font-weight: 800; color: white;
            margin-left: -8px; flex-shrink: 0;
        }
        .hero-avatar:first-child { margin-left: 0; }
        .hero-sp-text { font-size: .85rem; color: var(--ink-mid); }
        .hero-sp-text strong { color: var(--ink); }

        /* ── Hero image / mockup panel ── */
        .hero-visual-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1060px;
            margin: 4rem auto 0;
            animation: fadeSlideUp .9s ease .5s both;
        }

        /* Glow behind the panel */
        .hero-visual-wrap::before {
            content: '';
            position: absolute;
            inset: -30px;
            background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(37,99,235,.12), transparent 70%);
            border-radius: var(--r-xl);
            pointer-events: none;
            filter: blur(20px);
        }

        .hero-panel {
            background: rgba(255,255,255,.7);
            backdrop-filter: blur(24px) saturate(1.4);
            border: 1px solid rgba(255,255,255,.9);
            border-radius: var(--r-xl);
            box-shadow:
                0 0 0 1px rgba(226,232,240,.6),
                0 4px 6px rgba(15,23,42,.04),
                0 24px 80px rgba(15,23,42,.1),
                0 60px 120px rgba(37,99,235,.08);
            overflow: hidden;
            position: relative;
        }

        /* Top bar inside panel */
        .panel-topbar {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .85rem 1.4rem;
            border-bottom: 1px solid rgba(226,232,240,.7);
            background: rgba(248,250,252,.8);
        }
        .panel-dot { width: 10px; height: 10px; border-radius: 50%; }
        .panel-dot.r { background: #fc5f5a; }
        .panel-dot.y { background: #fdbc40; }
        .panel-dot.g { background: #34c749; }
        .panel-url-bar {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .panel-url-pill {
            background: rgba(226,232,240,.6);
            border: 1px solid rgba(226,232,240,.8);
            border-radius: 6px;
            padding: .25rem 1rem;
            font-size: .72rem;
            font-weight: 600;
            color: var(--ink-soft);
            letter-spacing: .02em;
        }

        /* ── Placeholder image area — replace src with your image ── */
        .hero-image-placeholder {
            display: block;
            width: 100%;
            /* Landscape 16:9-ish aspect ratio */
            aspect-ratio: 16 / 7;
            object-fit: cover;
            object-position: center top;
            background: linear-gradient(135deg, #eff6ff 0%, #f0fdff 40%, #faf5ff 80%, #f0fdf4 100%);
            position: relative;
        }

        /* Placeholder graphic when no real image exists */
        .hero-image-placeholder .placeholder-inner {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .placeholder-icon {
            width: 64px; height: 64px;
            background: rgba(37,99,235,.1);
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
        }
        .placeholder-icon svg { color: var(--primary); }
        .placeholder-label {
            font-size: .875rem;
            font-weight: 600;
            color: var(--ink-soft);
        }
        .placeholder-sub {
            font-size: .75rem;
            color: var(--ink-faint);
        }

        /* If you supply a real image, use this class on an <img> tag */
        .hero-real-image {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 7;
            object-fit: cover;
            object-position: center top;
            loading: lazy;
        }

        /* Bottom shimmer strip */
        .panel-shimmer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: linear-gradient(to top, rgba(255,255,255,.9), transparent);
            pointer-events: none;
        }

        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }

        /* ─────────────────────────────────────────────
           TRUST BAR
        ───────────────────────────────────────────── */
        .trust-bar {
            padding: 3.5rem 2rem;
            background: white;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .trust-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            flex-wrap: wrap;
        }
        .trust-item {
            display: flex; flex-direction: column; align-items: center;
            padding: 1.2rem 3.5rem;
            border-right: 1px solid var(--border);
        }
        .trust-item:last-child { border-right: none; }
        @media (max-width: 640px) {
            .trust-item { border-right: none; border-bottom: 1px solid var(--border); width: 50%; }
        }
        .trust-num {
            font-family: 'Syne', sans-serif; font-size: 2.1rem; font-weight: 800;
            background: var(--grad-brand);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            line-height: 1;
        }
        .trust-label { font-size: .8rem; font-weight: 500; color: var(--ink-soft); margin-top: .4rem; text-align: center; }

        /* ─────────────────────────────────────────────
           SECTION WRAPPER
        ───────────────────────────────────────────── */
        .section { padding: 7rem 2rem; }
        .section-alt { background: white; }
        .section-surface { background: var(--surface); }
        .section-dark { background: var(--ink); color: white; }

        .section-header { text-align: center; margin-bottom: 4rem; }
        .section-label {
            display: inline-block; font-size: .72rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase; color: var(--primary);
            background: rgba(37,99,235,.08); border: 1px solid rgba(37,99,235,.18);
            border-radius: 100px; padding: .3rem .85rem; margin-bottom: 1rem;
        }
        .section-title { font-size: clamp(2rem, 4vw, 3rem); color: var(--ink); margin-bottom: 1rem; }
        .section-sub {
            font-size: 1.05rem; color: var(--ink-soft); font-weight: 300;
            line-height: 1.7; max-width: 560px; margin: 0 auto;
        }

        /* ─────────────────────────────────────────────
           WHY / FEATURES
        ───────────────────────────────────────────── */
        .cards-3 {
            max-width: 1240px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;
        }
        @media (max-width: 1024px) { .cards-3 { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 640px)  { .cards-3 { grid-template-columns: 1fr; } }

        .feat-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--r-lg); padding: 2rem;
            transition: all .32s cubic-bezier(.22,1,.36,1);
            position: relative; overflow: hidden;
        }
        .feat-card::before {
            content: ''; position: absolute; inset: -1px; border-radius: inherit;
            background: var(--grad-brand); opacity: 0; transition: opacity .3s; z-index: 0;
        }
        .feat-card::after {
            content: ''; position: absolute; inset: 1px;
            border-radius: calc(var(--r-lg) - 1px); background: white; z-index: 1;
        }
        .feat-card > * { position: relative; z-index: 2; }
        .feat-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
        .feat-card:hover::before { opacity: 1; }

        .feat-icon-wrap {
            width: 56px; height: 56px; border-radius: var(--r-sm);
            background: linear-gradient(135deg, rgba(37,99,235,.1), rgba(6,182,212,.1));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; margin-bottom: 1.4rem; transition: transform .3s;
        }
        .feat-card:hover .feat-icon-wrap { transform: scale(1.1) rotate(-3deg); }
        .feat-title { font-size: 1.05rem; font-weight: 700; color: var(--ink); margin-bottom: .6rem; }
        .feat-text { font-size: .9rem; color: var(--ink-soft); line-height: 1.65; }

        /* ─────────────────────────────────────────────
           HOW IT WORKS
        ───────────────────────────────────────────── */
        .steps-row {
            max-width: 1240px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.25rem; position: relative;
        }
        .steps-row::before {
            content: ''; position: absolute;
            top: 25px; left: calc(10% + 25px); right: calc(10% + 25px);
            height: 2px; background: linear-gradient(90deg, var(--primary), var(--accent));
            opacity: .25; z-index: 0;
        }
        @media (max-width: 1024px) { .steps-row { grid-template-columns: repeat(3, 1fr); } .steps-row::before { display: none; } }
        @media (max-width: 640px)  { .steps-row { grid-template-columns: 1fr; } }

        .step-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--r-md); padding: 1.75rem 1.25rem;
            text-align: center; transition: all .3s; position: relative; z-index: 1;
        }
        .step-card:hover { border-color: var(--primary); box-shadow: 0 12px 32px rgba(37,99,235,.12); transform: translateY(-6px); }
        .step-num {
            width: 50px; height: 50px; margin: 0 auto 1.25rem;
            background: var(--grad-brand); color: white; border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; transition: transform .3s;
        }
        .step-card:hover .step-num { transform: scale(1.1) rotate(5deg); }
        .step-title { font-size: .95rem; font-weight: 700; color: var(--ink); margin-bottom: .5rem; }
        .step-text  { font-size: .85rem; color: var(--ink-soft); line-height: 1.6; }

        /* ─────────────────────────────────────────────
           STATS BAND
        ───────────────────────────────────────────── */
        .stats-band { background: var(--grad-brand); padding: 5rem 2rem; position: relative; overflow: hidden; }
        .stats-band::before {
            content: ''; position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.1) 1px, transparent 1px); background-size: 40px 40px;
        }
        .stats-band-grid {
            max-width: 1240px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 2rem; position: relative; z-index: 1; text-align: center; color: white;
        }
        @media (max-width: 1024px) { .stats-band-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px)  { .stats-band-grid { grid-template-columns: 1fr; } }
        .sb-num { font-family: 'Syne', sans-serif; font-size: 3rem; font-weight: 800; line-height: 1; margin-bottom: .4rem; }
        .sb-label { font-size: .9rem; font-weight: 500; opacity: .9; }

        /* ─────────────────────────────────────────────
           FEATURE SPLIT SECTIONS
        ───────────────────────────────────────────── */
        .split-section { padding: 6rem 2rem; }
        .split-section.alt { background: var(--surface); }
        .split-inner {
            max-width: 1240px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
        }
        @media (max-width: 1024px) {
            .split-inner { grid-template-columns: 1fr; gap: 3rem; }
            .split-inner.reverse .split-text { order: 1; }
            .split-inner.reverse .split-img  { order: 2; }
        }
        .split-inner.reverse .split-text { order: 2; }
        .split-inner.reverse .split-img  { order: 1; }
        .split-text .section-label { display: inline-block; text-align: left; }
        .split-text .section-title { text-align: left; font-size: clamp(1.8rem, 3vw, 2.4rem); }
        .split-text .section-sub   { text-align: left; margin: 0 0 2rem; }

        .split-checklist { list-style: none; display: flex; flex-direction: column; gap: .85rem; margin-bottom: 2rem; }
        .split-checklist li { display: flex; align-items: flex-start; gap: .75rem; font-size: .95rem; color: var(--ink-mid); }
        .check-icon {
            width: 22px; height: 22px; background: rgba(37,99,235,.1); border-radius: 6px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: .1rem;
        }
        .check-icon svg { color: var(--primary); }

        /* Mini analytics illustration */
        .mini-dash {
            background: white; border: 1px solid var(--border);
            border-radius: var(--r-xl); padding: 1.8rem; box-shadow: var(--shadow-lg); position: relative;
        }
        .mini-dash::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 4px; background: var(--grad-brand); border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
        .mini-bar-row { display: flex; justify-content: space-between; align-items: flex-end; gap: .6rem; height: 120px; margin-top: 1rem; }
        .mini-bar-wrap { display: flex; flex-direction: column; align-items: center; gap: .4rem; flex: 1; }
        .mini-bar { width: 100%; border-radius: 6px 6px 0 0; transition: height .5s ease; }
        .mini-bar.b1 { height: 60%; background: rgba(37,99,235,.85); }
        .mini-bar.b2 { height: 80%; background: var(--grad-brand); }
        .mini-bar.b3 { height: 45%; background: rgba(37,99,235,.55); }
        .mini-bar.b4 { height: 90%; background: var(--grad-brand); }
        .mini-bar.b5 { height: 70%; background: rgba(37,99,235,.7); }
        .mini-bar.b6 { height: 55%; background: rgba(37,99,235,.5); }
        .mini-bar.b7 { height: 85%; background: var(--grad-brand); }
        .mini-bar-lbl { font-size: .68rem; font-weight: 600; color: var(--ink-soft); }
        .mini-kpi-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .8rem; margin-top: 1.2rem; }
        .mini-kpi { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-sm); padding: .8rem; text-align: center; }
        .mini-kpi-n { font-family: 'Syne', sans-serif; font-size: 1.3rem; font-weight: 800; color: var(--primary); }
        .mini-kpi-l { font-size: .65rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-soft); margin-top: .2rem; }

        /* Map illustration */
        .map-mock { background: white; border: 1px solid var(--border); border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-lg); position: relative; }
        .map-header { padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .map-title { font-family: 'Syne', sans-serif; font-size: .95rem; font-weight: 700; color: var(--ink); }
        .map-body { height: 260px; background: linear-gradient(135deg, #eff6ff 0%, #f0fdff 100%); position: relative; display: flex; align-items: center; justify-content: center; }
        .map-grid-lines { position: absolute; inset: 0; background-image: linear-gradient(rgba(37,99,235,.07) 1px, transparent 1px), linear-gradient(90deg, rgba(37,99,235,.07) 1px, transparent 1px); background-size: 30px 30px; }
        .map-pins { position: relative; z-index: 1; display: flex; gap: 2rem; }
        .map-pin { display: flex; flex-direction: column; align-items: center; gap: .4rem; cursor: pointer; transition: transform .2s; }
        .map-pin:hover { transform: scale(1.1) translateY(-4px); }
        .pin-circle { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 800; color: white; box-shadow: 0 6px 16px rgba(0,0,0,.15); }
        .pin-circle.g { background: #10b981; }
        .pin-circle.r { background: #ef4444; }
        .pin-circle.y { background: #f59e0b; }
        .pin-lbl { font-size: .72rem; font-weight: 700; color: var(--ink-mid); background: white; padding: .2rem .5rem; border-radius: 6px; box-shadow: var(--shadow-sm); }

        /* ─────────────────────────────────────────────
           TESTIMONIALS
        ───────────────────────────────────────────── */
        .testi-grid {
            max-width: 1240px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;
        }
        @media (max-width: 1024px) { .testi-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 640px)  { .testi-grid { grid-template-columns: 1fr; } }
        .testi-card {
            background: white; border: 1px solid var(--border); border-radius: var(--r-lg);
            padding: 2rem; transition: all .3s;
        }
        .testi-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); }
        .testi-stars { display: flex; gap: .2rem; margin-bottom: 1rem; }
        .star { color: #f59e0b; font-size: 1rem; }
        .testi-quote { font-size: .95rem; color: var(--ink-mid); line-height: 1.7; margin-bottom: 1.5rem; font-style: italic; }
        .testi-author { display: flex; align-items: center; gap: .85rem; }
        .testi-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .9rem; font-weight: 800; color: white; flex-shrink: 0; }
        .testi-name { font-size: .9rem; font-weight: 700; color: var(--ink); }
        .testi-role { font-size: .78rem; color: var(--ink-soft); }

        /* ─────────────────────────────────────────────
           CTA SECTION
        ───────────────────────────────────────────── */
        .cta-section { padding: 7rem 2rem; background: white; }
        .cta-box {
            max-width: 900px; margin: 0 auto; background: var(--ink);
            border-radius: var(--r-xl); padding: 5.5rem 3rem; text-align: center; position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute; top: -50%; left: -20%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(37,99,235,.35) 0%, transparent 70%);
            border-radius: 50%; animation: orbFloat1 8s ease-in-out infinite;
        }
        .cta-box::after {
            content: ''; position: absolute; bottom: -40%; right: -10%;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(6,182,212,.25) 0%, transparent 70%);
            border-radius: 50%; animation: orbFloat2 10s ease-in-out infinite;
        }
        .cta-box > * { position: relative; z-index: 1; }
        .cta-title  { font-size: clamp(2rem,4vw,3rem); color: white; margin-bottom: .75rem; }
        .cta-sub    { font-size: 1.1rem; color: rgba(255,255,255,.7); margin-bottom: 2.5rem; font-weight: 300; }
        .cta-btns   { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

        .btn-white {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: .9rem 2.1rem; background: white; color: var(--primary);
            font-weight: 700; font-size: 1rem; border-radius: var(--r-md); border: none;
            cursor: pointer; transition: all .3s;
        }
        .btn-white:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(0,0,0,.2); }

        .btn-outline-white {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: .9rem 2.1rem; background: transparent; color: white;
            font-weight: 700; font-size: 1rem; border-radius: var(--r-md);
            border: 1.5px solid rgba(255,255,255,.3); cursor: pointer; transition: all .3s;
        }
        .btn-outline-white:hover { background: rgba(255,255,255,.1); border-color: white; }

        /* ─────────────────────────────────────────────
           TEAM
        ───────────────────────────────────────────── */
        .team-grid {
            max-width: 1240px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;
        }
        @media (max-width: 1024px) { .team-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 640px)  { .team-grid { grid-template-columns: 1fr; } }
        .team-card {
            background: white; border: 1px solid var(--border);
            border-radius: var(--r-lg); padding: 2rem 1.5rem;
            text-align: center; transition: all .32s cubic-bezier(.22,1,.36,1); position: relative; overflow: hidden;
        }
        .team-card::before {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 4px; background: var(--grad-brand); transform: scaleX(0); transition: transform .3s; transform-origin: left;
        }
        .team-card:hover::before { transform: scaleX(1); }
        .team-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
        .team-avatar {
            width: 76px; height: 76px; margin: 0 auto 1.25rem; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 800; color: white;
        }
        .av-blue   { background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .av-green  { background: linear-gradient(135deg, #10b981, #34d399); }
        .av-purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
        .av-orange { background: linear-gradient(135deg, #f97316, #fb923c); }
        .team-name { font-size: 1.05rem; font-weight: 700; color: var(--ink); margin-bottom: .5rem; }
        .team-role { display: inline-block; font-size: .78rem; font-weight: 600; background: rgba(37,99,235,.1); color: var(--primary); padding: .3rem .8rem; border-radius: 100px; }

        /* ─────────────────────────────────────────────
           FEATURE BADGES
        ───────────────────────────────────────────── */
        .badges-wrap { max-width: 1240px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: .85rem; justify-content: center; }
        .feat-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .7rem 1.25rem; background: white; border: 1.5px solid var(--border);
            border-radius: var(--r-sm); font-size: .875rem; font-weight: 600; color: var(--ink-mid); transition: all .2s;
        }
        .feat-badge:hover { border-color: var(--primary); background: rgba(37,99,235,.05); color: var(--primary); transform: translateY(-2px); }
        .feat-badge svg { color: var(--primary); }

        /* Live pill / dots reused */
        .live-pill {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .3rem .75rem; background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25);
            border-radius: 100px; font-size: .72rem; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: .05em;
        }
        .live-dot { width: 7px; height: 7px; background: #10b981; border-radius: 50%; animation: pulse 1.8s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.9)} }

        /* ─────────────────────────────────────────────
           FOOTER
        ───────────────────────────────────────────── */
        .footer { background: var(--ink); padding: 5rem 2rem 0; }
        .footer-inner { max-width: 1240px; margin: 0 auto; }
        .footer-top {
            display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 3rem;
            padding-bottom: 3rem; border-bottom: 1px solid rgba(255,255,255,.07);
        }
        @media (max-width: 1024px) { .footer-top { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 640px)  { .footer-top { grid-template-columns: 1fr; } }
        .footer-brand-col .footer-logo {
            font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; color: white;
            display: flex; align-items: center; gap: .5rem; margin-bottom: 1rem;
        }
        .footer-logo-icon { width: 30px; height: 30px; background: var(--grad-brand); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .footer-logo span { color: var(--primary-light); }
        .footer-desc { font-size: .875rem; color: #64748b; line-height: 1.7; max-width: 280px; }
        .footer-col h4 { font-family: 'Syne', sans-serif; font-size: .875rem; font-weight: 700; color: white; margin-bottom: 1.25rem; letter-spacing: .02em; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: .7rem; }
        .footer-col a { font-size: .875rem; color: #64748b; transition: color .2s; }
        .footer-col a:hover { color: white; }
        .footer-bottom { padding: 2rem 0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.25rem; }
        .footer-copy { font-size: .8rem; color: #475569; }
        .footer-socials { display: flex; gap: .75rem; }
        .social-btn {
            width: 36px; height: 36px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--r-sm); display: flex; align-items: center; justify-content: center;
            color: #64748b; transition: all .2s;
        }
        .social-btn:hover { background: var(--primary); border-color: var(--primary); color: white; }

        /* ─────────────────────────────────────────────
           LANGUAGE TRANSITION OVERLAY
        ───────────────────────────────────────────── */
        .lang-transitioning * { transition: opacity .15s ease !important; }
        [data-lang-nl], [data-lang-en] { transition: none; }
    </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════════ -->
<nav class="navbar" id="navbar">
    <a href="/" class="navbar-brand">
        <div class="brand-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        Smart<span>Parking</span>
    </a>

    <div class="navbar-center">
        <a href="#features" class="nav-link" data-lang-nl="Functies" data-lang-en="Features">Functies</a>
        <a href="#how"      class="nav-link" data-lang-nl="Hoe het werkt" data-lang-en="How it works">Hoe het werkt</a>
        <a href="#team"     class="nav-link" data-lang-nl="Team" data-lang-en="Team">Team</a>
        <a href="#pricing"  class="nav-link" data-lang-nl="Prijzen" data-lang-en="Pricing">Prijzen</a>
    </div>

    <div class="navbar-right">
        <button class="lang-btn" id="langToggle" onclick="toggleLang()" aria-label="Toggle language">
            <span id="langTxt">🇳🇱 NL</span>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn-ghost" data-lang-nl="Dashboard" data-lang-en="Dashboard">Dashboard</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn-ghost" data-lang-nl="Dashboard" data-lang-en="Dashboard">Dashboard</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-ghost" data-lang-nl="Log in" data-lang-en="Log in">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary" data-lang-nl="Begin nu →" data-lang-en="Get started →">Begin nu →</a>
            @endif
        @endauth
    </div>
</nav>


<!-- ═══════════════════════════════════════════════════
     HERO — Premium SaaS style, centred layout
═══════════════════════════════════════════════════ -->
<section class="hero">
    <!-- Ambient orbs -->
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <!-- Text content -->


        <h1 class="hero-h1">
            <span data-lang-nl="Vind sneller" data-lang-en="Find parking">Vind sneller</span>
            <br>
            <span class="gradient-text" data-lang-nl="een parkeerplaats." data-lang-en="faster than ever.">een parkeerplaats.</span>
        </h1>



        <div class="hero-cta">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary btn-primary-lg" data-lang-nl="Admin Dashboard →" data-lang-en="Admin Dashboard →">Admin Dashboard →</a>
                @else
                    <a href="{{ route('user.reserve') }}" class="btn-primary btn-primary-lg">
                        <span data-lang-nl="Parkeerplaats vinden" data-lang-en="Find parking">Parkeerplaats vinden</span>
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn-secondary" data-lang-nl="Meer info" data-lang-en="Learn more">Meer info</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-primary btn-primary-lg">
                    <span data-lang-nl="Gratis starten" data-lang-en="Get started free">Gratis starten</span>
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('login') }}" class="btn-secondary" data-lang-nl="Meer info" data-lang-en="Learn more">Meer info</a>
            @endauth
        </div>

        <div class="hero-social-proof">
            <div class="hero-avatars">
                <div class="hero-avatar">A</div>
                <div class="hero-avatar" style="background:linear-gradient(135deg,#10b981,#34d399)">S</div>
                <div class="hero-avatar" style="background:linear-gradient(135deg,#8b5cf6,#a78bfa)">S</div>
                <div class="hero-avatar" style="background:linear-gradient(135deg,#f97316,#fb923c)">M</div>
            </div>
            <div class="hero-sp-text">
                <span data-lang-nl="Al <strong>50.000+</strong> gebruikers parkeren slimmer" data-lang-en="Already <strong>50,000+</strong> users park smarter">Al <strong>50.000+</strong> gebruikers parkeren slimmer</span>
            </div>
        </div>
    </div>

    <!-- ── Hero image panel ──────────────────────────
         INSTRUCTIONS TO REPLACE IMAGE:
         Option A (real image):
           Replace the <div class="hero-image-placeholder"> block with:
           <img src="{{ asset('images/your-hero.jpg') }}" alt="SmartParking dashboard" class="hero-real-image" loading="lazy">

         Option B (storage image):
           <img src="{{ Storage::url('hero.jpg') }}" alt="SmartParking dashboard" class="hero-real-image" loading="lazy">

         Recommended: landscape image, min 1200×500px
    ─────────────────────────────────────────────── -->
    <div class="hero-visual-wrap">
        <div class="hero-panel">
            <!-- Browser chrome bar -->
            <div class="panel-topbar">
                <span class="panel-dot r"></span>
                <span class="panel-dot y"></span>
                <span class="panel-dot g"></span>
                <div class="panel-url-bar">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="#94a3b8" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <div class="panel-url-pill">smartparking.nl/dashboard</div>
                </div>
            </div>

            <!-- ↓ PLACEHOLDER — swap with <img> when you have a real image ↓ -->
<img src="{{ asset('images/hero.jpg') }}" 
     alt="SmartParking dashboard" 
     class="hero-real-image" 
     loading="lazy">
</section>


<!-- ═══════════════════════════════════════════════════
     TRUST BAR
═══════════════════════════════════════════════════ -->
<div class="trust-bar reveal">
    <div class="trust-inner">
        <div class="trust-item">
            <div class="trust-num">50K+</div>
            <div class="trust-label" data-lang-nl="Actieve gebruikers" data-lang-en="Active users">Actieve gebruikers</div>
        </div>
        <div class="trust-item">
            <div class="trust-num">10K+</div>
            <div class="trust-label" data-lang-nl="Reserveringen/maand" data-lang-en="Reservations/month">Reserveringen/maand</div>
        </div>
        <div class="trust-item">
            <div class="trust-num">99.9%</div>
            <div class="trust-label" data-lang-nl="Uptime garantie" data-lang-en="Uptime guarantee">Uptime garantie</div>
        </div>
        <div class="trust-item">
            <div class="trust-num">4.9★</div>
            <div class="trust-label" data-lang-nl="Gebruikersbeoordeling" data-lang-en="User rating">Gebruikersbeoordeling</div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════
     WHY CHOOSE US
═══════════════════════════════════════════════════ -->
<section class="section section-alt" id="features">
    <div class="section-header reveal">
        <div class="section-label" data-lang-nl="Voordelen" data-lang-en="Benefits">Voordelen</div>
        <h2 class="section-title" data-lang-nl="Waarom SmartParking?" data-lang-en="Why SmartParking?">Waarom SmartParking?</h2>
        <p class="section-sub" data-lang-nl="We maken parkeren niet alleen gemakkelijker, maar ook slimmer, sneller en veiliger dan ooit." data-lang-en="We make parking not just easier, but smarter, faster and safer than ever.">We maken parkeren niet alleen gemakkelijker, maar ook slimmer, sneller en veiliger dan ooit.</p>
    </div>

    <div class="cards-3">
        <div class="feat-card reveal delay-1">
            <div class="feat-icon-wrap">⚡</div>
            <h3 class="feat-title" data-lang-nl="Realtime Beschikbaarheid" data-lang-en="Real-time Availability">Realtime Beschikbaarheid</h3>
            <p class="feat-text" data-lang-nl="Weet altijd exact hoeveel plaatsen vrij zijn. Live updates elke seconde, geen wachten, geen stress." data-lang-en="Always know exactly how many spots are free. Live updates every second — no waiting, no stress.">Weet altijd exact hoeveel plaatsen vrij zijn. Live updates elke seconde, geen wachten, geen stress.</p>
        </div>
        <div class="feat-card reveal delay-2">
            <div class="feat-icon-wrap">🎯</div>
            <h3 class="feat-title" data-lang-nl="1 Klik Reserveren" data-lang-en="1-Click Booking">1 Klik Reserveren</h3>
            <p class="feat-text" data-lang-nl="Je plek is binnen enkele seconden gereserveerd. Geen gedoe, geen omslachtig proces — gewoon klikken en klaar." data-lang-en="Your spot is reserved within seconds. No hassle, no complicated process — just click and go.">Je plek is binnen enkele seconden gereserveerd. Geen gedoe, geen omslachtig proces — gewoon klikken en klaar.</p>
        </div>
        <div class="feat-card reveal delay-3">
            <div class="feat-icon-wrap">🔒</div>
            <h3 class="feat-title" data-lang-nl="Veilig & Secure" data-lang-en="Safe & Secure">Veilig & Secure</h3>
            <p class="feat-text" data-lang-nl="Enterprise-grade encryptie en multi-factor authenticatie. Je gegevens zijn altijd in veilige handen." data-lang-en="Enterprise-grade encryption and multi-factor authentication. Your data is always in safe hands.">Enterprise-grade encryptie en multi-factor authenticatie. Je gegevens zijn altijd in veilige handen.</p>
        </div>
        <div class="feat-card reveal delay-1">
            <div class="feat-icon-wrap">📱</div>
            <h3 class="feat-title" data-lang-nl="100% Responsive" data-lang-en="100% Responsive">100% Responsive</h3>
            <p class="feat-text" data-lang-nl="Perfecte ervaring op alle apparaten. Desktop, tablet, telefoon — elke pixel klopt." data-lang-en="Perfect experience on all devices. Desktop, tablet, phone — every pixel is right.">Perfecte ervaring op alle apparaten. Desktop, tablet, telefoon — elke pixel klopt.</p>
        </div>
        <div class="feat-card reveal delay-2">
            <div class="feat-icon-wrap">💳</div>
            <h3 class="feat-title" data-lang-nl="Veilige Betaling" data-lang-en="Secure Payment">Veilige Betaling</h3>
            <p class="feat-text" data-lang-nl="Integratie met toonaangevende betaalsystemen. Snel, veilig en PCI-compliant." data-lang-en="Integration with leading payment systems. Fast, secure and PCI-compliant.">Integratie met toonaangevende betaalsystemen. Snel, veilig en PCI-compliant.</p>
        </div>
        <div class="feat-card reveal delay-3">
            <div class="feat-icon-wrap">📊</div>
            <h3 class="feat-title" data-lang-nl="Volledig Beheer" data-lang-en="Full Management">Volledig Beheer</h3>
            <p class="feat-text" data-lang-nl="Manage al je reserveringen vanuit één dashboard. Wijzig, annuleer of bekijk je volledige geschiedenis." data-lang-en="Manage all your reservations from one dashboard. Modify, cancel or view your complete history.">Manage al je reserveringen vanuit één dashboard. Wijzig, annuleer of bekijk je volledige geschiedenis.</p>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     SPLIT SECTION A
═══════════════════════════════════════════════════ -->
<section class="split-section">
    <div class="split-inner">
        <div class="split-text reveal">
            <div class="section-label" data-lang-nl="Analytics" data-lang-en="Analytics">Analytics</div>
            <h2 class="section-title" data-lang-nl="Volledige inzichten op één plek" data-lang-en="Complete insights in one place">Volledige inzichten op één plek</h2>
            <p class="section-sub" data-lang-nl="Bekijk bezettingsgraad, piekuren en trends — zodat jij slimmer kunt plannen en beheren." data-lang-en="View occupancy rates, peak hours and trends — so you can plan and manage smarter.">Bekijk bezettingsgraad, piekuren en trends — zodat jij slimmer kunt plannen en beheren.</p>
            <ul class="split-checklist">
                <li>
                    <span class="check-icon"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Live bezettingsgraad per locatie" data-lang-en="Live occupancy rate per location">Live bezettingsgraad per locatie</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Historische data en trendanalyses" data-lang-en="Historical data and trend analyses">Historische data en trendanalyses</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Exporteerbare rapporten (PDF/CSV)" data-lang-en="Exportable reports (PDF/CSV)">Exporteerbare rapporten (PDF/CSV)</span>
                </li>
            </ul>
            @auth
                <a href="{{ route('user.dashboard') }}" class="btn-primary btn-primary-lg" data-lang-nl="Bekijk dashboard" data-lang-en="View dashboard">Bekijk dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary btn-primary-lg" data-lang-nl="Gratis proberen →" data-lang-en="Try for free →">Gratis proberen →</a>
            @endauth
        </div>

        <div class="split-img reveal delay-2">
            <div class="mini-dash">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="font-family:'Syne',sans-serif;font-size:.9rem;font-weight:700;color:var(--ink);" data-lang-nl="Bezetting deze week" data-lang-en="Occupancy this week">Bezetting deze week</div>
                    <div class="live-pill"><span class="live-dot"></span>Live</div>
                </div>
                <div class="mini-bar-row">
                    <div class="mini-bar-wrap"><div class="mini-bar b1"></div><div class="mini-bar-lbl" data-lang-nl="Ma" data-lang-en="Mon">Ma</div></div>
                    <div class="mini-bar-wrap"><div class="mini-bar b2"></div><div class="mini-bar-lbl" data-lang-nl="Di" data-lang-en="Tue">Di</div></div>
                    <div class="mini-bar-wrap"><div class="mini-bar b3"></div><div class="mini-bar-lbl" data-lang-nl="Wo" data-lang-en="Wed">Wo</div></div>
                    <div class="mini-bar-wrap"><div class="mini-bar b4"></div><div class="mini-bar-lbl" data-lang-nl="Do" data-lang-en="Thu">Do</div></div>
                    <div class="mini-bar-wrap"><div class="mini-bar b5"></div><div class="mini-bar-lbl" data-lang-nl="Vr" data-lang-en="Fri">Vr</div></div>
                    <div class="mini-bar-wrap"><div class="mini-bar b6"></div><div class="mini-bar-lbl" data-lang-nl="Za" data-lang-en="Sat">Za</div></div>
                    <div class="mini-bar-wrap"><div class="mini-bar b7"></div><div class="mini-bar-lbl" data-lang-nl="Zo" data-lang-en="Sun">Zo</div></div>
                </div>
                <div class="mini-kpi-row">
                    <div class="mini-kpi"><div class="mini-kpi-n">78%</div><div class="mini-kpi-l" data-lang-nl="Gem. bezetting" data-lang-en="Avg. occupancy">Gem. bezetting</div></div>
                    <div class="mini-kpi"><div class="mini-kpi-n">342</div><div class="mini-kpi-l" data-lang-nl="Reserveringen" data-lang-en="Reservations">Reserveringen</div></div>
                    <div class="mini-kpi"><div class="mini-kpi-n">€ 12K</div><div class="mini-kpi-l" data-lang-nl="Omzet" data-lang-en="Revenue">Omzet</div></div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     SPLIT SECTION B
═══════════════════════════════════════════════════ -->
<section class="split-section alt">
    <div class="split-inner reverse">
        <div class="split-text reveal delay-1">
            <div class="section-label" data-lang-nl="Locaties" data-lang-en="Locations">Locaties</div>
            <h2 class="section-title" data-lang-nl="Vind je plek op de kaart" data-lang-en="Find your spot on the map">Vind je plek op de kaart</h2>
            <p class="section-sub" data-lang-nl="Interactieve kaartweergave toont je alle beschikbare plekken in de buurt — realtime bijgewerkt." data-lang-en="Interactive map view shows all available spots nearby — updated in real time.">Interactieve kaartweergave toont je alle beschikbare plekken in de buurt — realtime bijgewerkt.</p>
            <ul class="split-checklist">
                <li>
                    <span class="check-icon"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="GPS-gebaseerde locaties in de buurt" data-lang-en="GPS-based nearby locations">GPS-gebaseerde locaties in de buurt</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Kleurcodering voor beschikbaarheid" data-lang-en="Color-coding for availability">Kleurcodering voor beschikbaarheid</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Prijsvergelijking per locatie" data-lang-en="Price comparison per location">Prijsvergelijking per locatie</span>
                </li>
            </ul>
            @auth
                <a href="{{ route('user.reserve') }}" class="btn-primary btn-primary-lg" data-lang-nl="Vind een plek →" data-lang-en="Find a spot →">Vind een plek →</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary btn-primary-lg" data-lang-nl="Probeer gratis →" data-lang-en="Try for free →">Probeer gratis →</a>
            @endauth
        </div>

        <div class="split-img reveal">
            <div class="map-mock">
                <div class="map-header">
                    <div class="map-title" data-lang-nl="📍 Parkeerlocaties — Centrum" data-lang-en="📍 Parking locations — City centre">📍 Parkeerlocaties — Centrum</div>
                    <div class="live-pill"><span class="live-dot"></span>Live</div>
                </div>
                <div class="map-body">
                    <div class="map-grid-lines"></div>
                    <div class="map-pins">
                        <div class="map-pin">
                            <div class="pin-circle g">12</div>
                            <div class="pin-lbl" data-lang-nl="Terrein A" data-lang-en="Lot A">Terrein A</div>
                        </div>
                        <div class="map-pin">
                            <div class="pin-circle r">0</div>
                            <div class="pin-lbl" data-lang-nl="Terrein B" data-lang-en="Lot B">Terrein B</div>
                        </div>
                        <div class="map-pin">
                            <div class="pin-circle y">4</div>
                            <div class="pin-lbl" data-lang-nl="Terrein C" data-lang-en="Lot C">Terrein C</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════════ -->
<section class="section" id="how">
    <div class="section-header reveal">
        <div class="section-label" data-lang-nl="Proces" data-lang-en="Process">Proces</div>
        <h2 class="section-title" data-lang-nl="Hoe werkt het?" data-lang-en="How does it work?">Hoe werkt het?</h2>
        <p class="section-sub" data-lang-nl="5 simpele stappen naar jouw gereserveerde parkeerplek." data-lang-en="5 simple steps to your reserved parking spot.">5 simpele stappen naar jouw gereserveerde parkeerplek.</p>
    </div>

    <div class="steps-row">
        <div class="step-card reveal delay-1">
            <div class="step-num">1</div>
            <h3 class="step-title" data-lang-nl="Account aanmaken" data-lang-en="Create account">Account aanmaken</h3>
            <p class="step-text" data-lang-nl="Registreer met je e-mailadres en maak een veilig account in 30 seconden." data-lang-en="Register with your email and create a secure account in 30 seconds.">Registreer met je e-mailadres en maak een veilig account in 30 seconden.</p>
        </div>
        <div class="step-card reveal delay-2">
            <div class="step-num">2</div>
            <h3 class="step-title" data-lang-nl="Beschikbaarheid zien" data-lang-en="Check availability">Beschikbaarheid zien</h3>
            <p class="step-text" data-lang-nl="Zie in realtime welke plekken vrij zijn op jouw gewenste locatie." data-lang-en="See in real time which spots are available at your desired location.">Zie in realtime welke plekken vrij zijn op jouw gewenste locatie.</p>
        </div>
        <div class="step-card reveal delay-3">
            <div class="step-num">3</div>
            <h3 class="step-title" data-lang-nl="Plek reserveren" data-lang-en="Reserve spot">Plek reserveren</h3>
            <p class="step-text" data-lang-nl="Kies je voorkeursplek en bevestig je reservering met één klik." data-lang-en="Choose your preferred spot and confirm your reservation with one click.">Kies je voorkeursplek en bevestig je reservering met één klik.</p>
        </div>
        <div class="step-card reveal delay-4">
            <div class="step-num">4</div>
            <h3 class="step-title" data-lang-nl="Veilig betalen" data-lang-en="Pay securely">Veilig betalen</h3>
            <p class="step-text" data-lang-nl="Betaal veilig via iDEAL, creditcard of andere betaalmethoden." data-lang-en="Pay securely via iDEAL, credit card or other payment methods.">Betaal veilig via iDEAL, creditcard of andere betaalmethoden.</p>
        </div>
        <div class="step-card reveal delay-5">
            <div class="step-num">5</div>
            <h3 class="step-title" data-lang-nl="Klaar & parkeer!" data-lang-en="Done & park!">Klaar & parkeer!</h3>
            <p class="step-text" data-lang-nl="Ontvang je bevestiging. Rijd naar je plek — die is van jou." data-lang-en="Receive your confirmation. Drive to your spot — it's yours.">Ontvang je bevestiging. Rijd naar je plek — die is van jou.</p>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     STATS BAND
═══════════════════════════════════════════════════ -->
<section class="stats-band reveal">
    <div class="stats-band-grid">
        <div>
            <div class="sb-num">50K+</div>
            <div class="sb-label" data-lang-nl="Gebruikers vertrouwen ons" data-lang-en="Users trust us">Gebruikers vertrouwen ons</div>
        </div>
        <div>
            <div class="sb-num">10K+</div>
            <div class="sb-label" data-lang-nl="Reserveringen per maand" data-lang-en="Reservations per month">Reserveringen per maand</div>
        </div>
        <div>
            <div class="sb-num">99.9%</div>
            <div class="sb-label" data-lang-nl="Uptime garantie" data-lang-en="Uptime guarantee">Uptime garantie</div>
        </div>
        <div>
            <div class="sb-num">24/7</div>
            <div class="sb-label" data-lang-nl="Support & monitoring" data-lang-en="Support & monitoring">Support & monitoring</div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════════════ -->
<section class="section section-alt">
    <div class="section-header reveal">
        <div class="section-label" data-lang-nl="Klanten" data-lang-en="Customers">Klanten</div>
        <h2 class="section-title" data-lang-nl="Wat gebruikers zeggen" data-lang-en="What users say">Wat gebruikers zeggen</h2>
        <p class="section-sub" data-lang-nl="Duizenden tevreden gebruikers parkeren dagelijks slimmer met SmartParking." data-lang-en="Thousands of satisfied users park smarter every day with SmartParking.">Duizenden tevreden gebruikers parkeren dagelijks slimmer met SmartParking.</p>
    </div>

    <div class="testi-grid">
        <div class="testi-card reveal delay-1">
            <div class="testi-stars">
                <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
            </div>
            <p class="testi-quote" data-lang-nl='"Nooit meer rondrijden op zoek naar een plek. SmartParking toont me direct waar ik terecht kan. Een echte game-changer!"' data-lang-en='"Never driving around looking for a spot again. SmartParking shows me immediately where to go. A real game-changer!"'>"Nooit meer rondrijden op zoek naar een plek. SmartParking toont me direct waar ik terecht kan. Een echte game-changer!"</p>
            <div class="testi-author">
                <div class="testi-avatar" style="background:linear-gradient(135deg,#2563eb,#3b82f6)">M</div>
                <div>
                    <div class="testi-name">Mark de Vries</div>
                    <div class="testi-role" data-lang-nl="Dagelijkse forens, Utrecht" data-lang-en="Daily commuter, Utrecht">Dagelijkse forens, Utrecht</div>
                </div>
            </div>
        </div>

        <div class="testi-card reveal delay-2">
            <div class="testi-stars">
                <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
            </div>
            <p class="testi-quote" data-lang-nl='"Als beheerder heb ik eindelijk volledig inzicht in de bezetting. De analytics zijn ongelooflijk waardevol voor onze planning."' data-lang-en='"As a manager I finally have full insight into occupancy. The analytics are incredibly valuable for our planning."'>"Als beheerder heb ik eindelijk volledig inzicht in de bezetting. De analytics zijn ongelooflijk waardevol voor onze planning."</p>
            <div class="testi-author">
                <div class="testi-avatar" style="background:linear-gradient(135deg,#10b981,#34d399)">S</div>
                <div>
                    <div class="testi-name">Sophie Janssen</div>
                    <div class="testi-role" data-lang-nl="Parkeerbeheeder, Amsterdam" data-lang-en="Parking manager, Amsterdam">Parkeerbeheeder, Amsterdam</div>
                </div>
            </div>
        </div>

        <div class="testi-card reveal delay-3">
            <div class="testi-stars">
                <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
            </div>
            <p class="testi-quote" data-lang-nl='"De app werkt perfect op mijn telefoon. Reserveren gaat zo snel — ik gebruik het elke dag voor het werk."' data-lang-en='"The app works perfectly on my phone. Booking is so fast — I use it every day for work."'>"De app werkt perfect op mijn telefoon. Reserveren gaat zo snel — ik gebruik het elke dag voor het werk."</p>
            <div class="testi-author">
                <div class="testi-avatar" style="background:linear-gradient(135deg,#f97316,#fb923c)">R</div>
                <div>
                    <div class="testi-name">Riad El Ouali</div>
                    <div class="testi-role" data-lang-nl="Ondernemer, Rotterdam" data-lang-en="Entrepreneur, Rotterdam">Ondernemer, Rotterdam</div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     CTA SECTION
═══════════════════════════════════════════════════ -->
<section class="cta-section">
    <div class="cta-box reveal">
        <h2 class="cta-title" data-lang-nl="Klaar voor slim parkeren?" data-lang-en="Ready for smart parking?">Klaar voor slim parkeren?</h2>
        <p class="cta-sub" data-lang-nl="Sluit je aan bij 50.000+ gebruikers die hun parkeerprobleem al hebben opgelost." data-lang-en="Join 50,000+ users who have already solved their parking problem.">Sluit je aan bij 50.000+ gebruikers die hun parkeerprobleem al hebben opgelost.</p>
        <div class="cta-btns">
            @auth
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('user.reserve') }}" class="btn-white" data-lang-nl="Nu reserveren →" data-lang-en="Reserve now →">Nu reserveren →</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-white" data-lang-nl="Gratis starten →" data-lang-en="Get started free →">Gratis starten →</a>
                <a href="{{ route('login') }}" class="btn-outline-white" data-lang-nl="Al lid? Log in" data-lang-en="Already a member? Log in">Al lid? Log in</a>
            @endauth
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     TEAM
═══════════════════════════════════════════════════ -->
<section class="section section-surface" id="team">
    <div class="section-header reveal">
        <div class="section-label" data-lang-nl="Team" data-lang-en="Team">Team</div>
        <h2 class="section-title" data-lang-nl="Bouwers van SmartParking" data-lang-en="Builders of SmartParking">Bouwers van SmartParking</h2>
        <p class="section-sub" data-lang-nl="Een getalenteerd team dat samen iets speciaals heeft gecreëerd." data-lang-en="A talented team that created something special together.">Een getalenteerd team dat samen iets speciaals heeft gecreëerd.</p>
    </div>

    <div class="team-grid">
        <div class="team-card reveal delay-1">
            <div class="team-avatar av-blue">A</div>
            <div class="team-name">Adem</div>
            <div class="team-role" data-lang-nl="Backend & Database" data-lang-en="Backend & Database">Backend & Database</div>
        </div>
        <div class="team-card reveal delay-2">
            <div class="team-avatar av-green">S</div>
            <div class="team-name">Salim</div>
            <div class="team-role" data-lang-nl="Frontend & Design" data-lang-en="Frontend & Design">Frontend & Design</div>
        </div>
        <div class="team-card reveal delay-3">
            <div class="team-avatar av-purple">S</div>
            <div class="team-name">Sjoerd</div>
            <div class="team-role" data-lang-nl="Frontend & Backend" data-lang-en="Frontend & Backend">Frontend & Backend</div>
        </div>
        <div class="team-card reveal delay-4">
            <div class="team-avatar av-orange">M</div>
            <div class="team-name">Mokhless</div>
            <div class="team-role" data-lang-nl="Frontend & Backend" data-lang-en="Frontend & Backend">Frontend & Backend</div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     ALL FEATURES BADGES
═══════════════════════════════════════════════════ -->
<section class="section">
    <div class="section-header reveal">
        <div class="section-label" data-lang-nl="Mogelijkheden" data-lang-en="Capabilities">Mogelijkheden</div>
        <h2 class="section-title" data-lang-nl="Alles inbegrepen" data-lang-en="Everything included">Alles inbegrepen</h2>
        <p class="section-sub" data-lang-nl="Volledig uitgerust met alles wat je nodig hebt voor slimmer parkeren." data-lang-en="Fully equipped with everything you need for smarter parking.">Volledig uitgerust met alles wat je nodig hebt voor slimmer parkeren.</p>
    </div>

    <div class="badges-wrap reveal delay-1">
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Realtime beschikbaarheid" data-lang-en="Real-time availability">Realtime beschikbaarheid</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Veilige authenticatie" data-lang-en="Secure authentication">Veilige authenticatie</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Admin dashboard" data-lang-en="Admin dashboard">Admin dashboard</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round" stroke-linejoin="round"/><line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round" stroke-linejoin="round"/><line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Reserveringssysteem" data-lang-en="Reservation system">Reserveringssysteem</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Responsief design" data-lang-en="Responsive design">Responsief design</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Veilig betaalsysteem" data-lang-en="Secure payment">Veilig betaalsysteem</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Reserveringsbeheer" data-lang-en="Booking management">Reserveringsbeheer</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Rol-gebaseerde toegang" data-lang-en="Role-based access">Rol-gebaseerde toegang</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Gebruikersbeheer" data-lang-en="User management">Gebruikersbeheer</span></span>
        <span class="feat-badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Multi-locatie beheer" data-lang-en="Multi-location management">Multi-locatie beheer</span></span>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════ -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-brand-col footer-col">
                <div class="footer-logo">
                    <div class="footer-logo-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    Smart<span>Parking</span>
                </div>
                <p class="footer-desc" data-lang-nl="De slimste manier om te parkeren. Realtime beschikbaarheid, instant reserveren, totale controle." data-lang-en="The smartest way to park. Real-time availability, instant booking, total control.">De slimste manier om te parkeren. Realtime beschikbaarheid, instant reserveren, totale controle.</p>
            </div>

            <div class="footer-col">
                <h4 data-lang-nl="Product" data-lang-en="Product">Product</h4>
                <ul>
                    <li><a href="#features" data-lang-nl="Functies" data-lang-en="Features">Functies</a></li>
                    <li><a href="#how" data-lang-nl="Hoe het werkt" data-lang-en="How it works">Hoe het werkt</a></li>
                    <li><a href="#team" data-lang-nl="Team" data-lang-en="Team">Team</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 data-lang-nl="Account" data-lang-en="Account">Account</h4>
                <ul>
                    <li><a href="{{ route('login') }}" data-lang-nl="Inloggen" data-lang-en="Log in">Inloggen</a></li>
                    <li><a href="{{ route('register') }}" data-lang-nl="Registreren" data-lang-en="Register">Registreren</a></li>
                    <li><a href="#" data-lang-nl="Contacteer ons" data-lang-en="Contact us">Contacteer ons</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 data-lang-nl="Over" data-lang-en="About">Over</h4>
                <ul>
                    <li><a href="#" data-lang-nl="Over SmartParking" data-lang-en="About SmartParking">Over SmartParking</a></li>
                    <li><a href="#" data-lang-nl="Privacy Policy" data-lang-en="Privacy Policy">Privacy Policy</a></li>
                    <li><a href="#" data-lang-nl="Gebruiksvoorwaarden" data-lang-en="Terms of Service">Gebruiksvoorwaarden</a></li>
                    <li><a href="#" data-lang-nl="Laravel" data-lang-en="Laravel">Laravel</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copy">
                <span data-lang-nl="&copy; {{ date('Y') }} SmartParking — Gebouwd door Adem, Salim, Sjoerd &amp; Mokhless. Alle rechten voorbehouden." data-lang-en="&copy; {{ date('Y') }} SmartParking — Built by Adem, Salim, Sjoerd &amp; Mokhless. All rights reserved.">&copy; {{ date('Y') }} SmartParking — Gebouwd door Adem, Salim, Sjoerd &amp; Mokhless. Alle rechten voorbehouden.</span>
            </div>
            <div class="footer-socials">
                <a href="#" class="social-btn" aria-label="GitHub">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                </a>
                <a href="#" class="social-btn" aria-label="Lightning">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </a>
                <a href="#" class="social-btn" aria-label="Email">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>


<!-- ═══════════════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════════════ -->
<script>
    /* ═══════════════════════════════════════════════
       LANGUAGE SWITCH — Full implementation
       - Reads/writes localStorage for persistence
       - Translates all data-lang-nl / data-lang-en attributes
       - Persists between page reloads and visits
    ═══════════════════════════════════════════════ */
    const LANG_KEY = 'sp_lang';

    function applyLang(lang) {
        const isEN = lang === 'en';

        /* Update button label */
        const btn = document.getElementById('langTxt');
        if (btn) btn.textContent = isEN ? '🇬🇧 EN' : '🇳🇱 NL';

        /* Translate every element with data-lang-nl / data-lang-en */
        const attrKey = isEN ? 'data-lang-en' : 'data-lang-nl';
        document.querySelectorAll('[data-lang-nl], [data-lang-en]').forEach(el => {
            const val = el.getAttribute(attrKey);
            if (val === null) return;

            /* For elements that only contain text (no children other than text nodes) */
            if (el.children.length === 0) {
                /* Use innerHTML so HTML entities like &rarr; and <strong> render */
                el.innerHTML = val;
            } else {
                /* Element has child elements — only swap if it also carries own text */
                /* Skip composite elements to avoid breaking icons/SVGs */
            }
        });

        /* Update <html lang=""> */
        document.documentElement.lang = isEN ? 'en' : 'nl';

        /* Persist */
        try { localStorage.setItem(LANG_KEY, lang); } catch(e) {}
    }

    function toggleLang() {
        const current = (function() {
            try { return localStorage.getItem(LANG_KEY) || 'nl'; } catch(e) { return 'nl'; }
        })();
        applyLang(current === 'nl' ? 'en' : 'nl');
    }

    /* Restore saved language on page load */
    (function init() {
        let saved = 'nl';
        try { saved = localStorage.getItem(LANG_KEY) || 'nl'; } catch(e) {}
        applyLang(saved);
    })();

    /* ═══════════════════════════════════════════════
       SCROLL REVEAL
    ═══════════════════════════════════════════════ */
    const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                revealObserver.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    /* ═══════════════════════════════════════════════
       SCROLLED NAVBAR
    ═══════════════════════════════════════════════ */
    const navbar = document.getElementById('navbar');
    const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 60);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
</script>

</body>
</html>