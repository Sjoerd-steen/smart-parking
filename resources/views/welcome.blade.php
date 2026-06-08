cat > /home/claude/welcome.blade.php << 'ENDOFFILE'
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartParking — De toekomst van parkeren</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Cabinet+Grotesk:wght@400;500;600;700;800&family=Satoshi:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ─── TOKENS ─── */
        :root {
            --ink:           #0a0f1e;
            --ink-2:         #1e2842;
            --ink-3:         #3d4f70;
            --ink-4:         #7b8eb5;
            --ink-5:         #b0bdd6;

            --surface:       #f4f6fb;
            --surface-2:     #edf0f9;
            --white:         #ffffff;
            --border:        rgba(30,40,66,.10);
            --border-2:      rgba(30,40,66,.06);

            --blue:          #1a56db;
            --blue-2:        #1e40af;
            --blue-light:    #3b82f6;
            --cyan:          #06b6d4;
            --cyan-2:        #0891b2;
            --indigo:        #4338ca;

            --grad:          linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            --grad-soft:     linear-gradient(135deg, rgba(26,86,219,.08) 0%, rgba(6,182,212,.06) 100%);
            --grad-hero-bg:  radial-gradient(ellipse 100% 80% at 50% -20%, rgba(26,86,219,.09) 0%, transparent 60%),
                             radial-gradient(ellipse 60% 50% at 90% 30%, rgba(6,182,212,.07) 0%, transparent 55%),
                             radial-gradient(ellipse 50% 60% at 10% 70%, rgba(67,56,202,.05) 0%, transparent 55%),
                             #f4f6fb;

            --sh-sm:   0 2px 8px rgba(10,15,30,.07);
            --sh-md:   0 8px 32px rgba(10,15,30,.10);
            --sh-lg:   0 24px 64px rgba(10,15,30,.14);
            --sh-xl:   0 40px 100px rgba(10,15,30,.16);
            --sh-blue: 0 8px 40px rgba(26,86,219,.30);

            --r-sm:  8px;
            --r-md:  14px;
            --r-lg:  20px;
            --r-xl:  28px;
            --r-2xl: 40px;

            --font-display: 'Cabinet Grotesk', sans-serif;
            --font-serif:   'Instrument Serif', serif;
            --font-body:    'Satoshi', sans-serif;

            --ease-spring: cubic-bezier(.22,1,.36,1);
        }

        /* ─── RESET ─── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-body);
            background: var(--surface);
            color: var(--ink);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
        }
        a { text-decoration: none; }
        img { display: block; max-width: 100%; }

        /* ─── PAGE BG ─── */
        body { background: var(--grad-hero-bg); }

        /* Grain */
        body::after {
            content: '';
            position: fixed; inset: 0; z-index: -1; pointer-events: none;
            opacity: .025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
        }

        /* ─── UTILITY ─── */
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 1.75rem; }

        .gradient-text {
            background: var(--grad);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ─── REVEAL ─── */
        .reveal {
            opacity: 0; transform: translateY(24px);
            transition: opacity .6s var(--ease-spring), transform .6s var(--ease-spring);
        }
        .reveal.visible { opacity: 1; transform: none; }
        .d1 { transition-delay: .06s; }
        .d2 { transition-delay: .12s; }
        .d3 { transition-delay: .18s; }
        .d4 { transition-delay: .24s; }
        .d5 { transition-delay: .30s; }

        /* ─── NAVBAR ─── */
        .nav {
            position: fixed; inset: 0 0 auto; z-index: 200;
            padding: .875rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            transition: background .25s, box-shadow .25s, backdrop-filter .25s;
        }
        .nav.scrolled {
            background: rgba(244,246,251,.85);
            backdrop-filter: blur(20px) saturate(1.8);
            box-shadow: 0 1px 0 var(--border), var(--sh-sm);
        }

        .nav-logo {
            font-family: var(--font-display); font-size: 1.25rem; font-weight: 800;
            color: var(--ink); letter-spacing: -.02em;
            display: flex; align-items: center; gap: .5rem;
        }
        .nav-logo-mark {
            width: 32px; height: 32px; border-radius: 9px;
            background: var(--grad);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(26,86,219,.35);
        }
        .nav-logo-mark svg { color: #fff; }
        .nav-logo .accent { color: var(--blue); }

        .nav-links {
            display: flex; gap: 2rem;
        }
        @media (max-width: 768px) { .nav-links { display: none; } }

        .nav-link {
            font-size: .875rem; font-weight: 500;
            color: var(--ink-3);
            transition: color .18s;
        }
        .nav-link:hover { color: var(--ink); }

        .nav-actions { display: flex; align-items: center; gap: .75rem; }

        .btn-lang {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .4rem .85rem;
            font-family: var(--font-body); font-size: .8rem; font-weight: 600;
            color: var(--ink-3); background: transparent;
            border: 1.5px solid var(--border); border-radius: var(--r-sm);
            cursor: pointer; transition: all .18s;
        }
        .btn-lang:hover { border-color: var(--blue); color: var(--blue); background: rgba(26,86,219,.05); }
        .btn-lang svg { width: 11px; height: 11px; }

        .btn-ghost {
            display: inline-flex; align-items: center;
            padding: .48rem 1.1rem;
            font-family: var(--font-body); font-size: .875rem; font-weight: 600;
            color: var(--ink-3); background: transparent;
            border: 1.5px solid var(--border); border-radius: var(--r-sm);
            cursor: pointer; transition: all .2s;
        }
        .btn-ghost:hover { background: var(--blue); color: #fff; border-color: var(--blue); }

        .btn-cta {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .55rem 1.3rem;
            font-family: var(--font-body); font-size: .875rem; font-weight: 700;
            color: #fff; background: var(--grad);
            border: none; border-radius: var(--r-sm);
            cursor: pointer; transition: all .25s var(--ease-spring);
            box-shadow: var(--sh-blue);
            position: relative; overflow: hidden;
        }
        .btn-cta::after {
            content: ''; position: absolute; inset: 0;
            background: rgba(255,255,255,0); transition: background .2s;
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 14px 48px rgba(26,86,219,.38); }
        .btn-cta:hover::after { background: rgba(255,255,255,.08); }

        /* ─── HERO ─── */
        .hero {
            position: relative;
            text-align: center;
            padding: 140px 1.75rem 0;
            overflow: hidden;
        }

        /* Dot grid */
        .hero::before {
            content: ''; position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(26,86,219,.08) 1.5px, transparent 1.5px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 40%, black 20%, transparent 100%);
            pointer-events: none; z-index: 0;
        }

        .hero-inner {
            position: relative;
            z-index: 10;
            max-width: 900px;
            margin: 0 auto;
            padding-bottom: 0;
            animation: heroIn .75s var(--ease-spring) .05s both;
        }

        @keyframes heroIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:none; } }

        .hero-bg-img {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 170%;
            z-index: 0;
            pointer-events: none;
            border-radius: var(--r-xl);
            overflow: hidden;
        }
        .hero-bg-img::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    to bottom,
                    rgba(244,246,251, 0.97)  0%,
                    rgba(244,246,251, 0.92) 20%,
                    rgba(244,246,251, 0.78) 40%,
                    rgba(244,246,251, 0.52) 58%,
                    rgba(244,246,251, 0.18) 72%,
                    rgba(244,246,251, 0.00) 100%
                );
        }

        .hero-inner > *:not(.hero-bg-img) {
            position: relative;
            z-index: 1;
        }

        .hero-content-wrap {
            position: relative;
            z-index: 1;
            padding: 2rem 2rem 3.5rem;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .38rem .9rem;
            font-family: var(--font-body); font-size: .72rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--blue);
            background: rgba(26,86,219,.08); border: 1px solid rgba(26,86,219,.18);
            border-radius: 100px; margin-bottom: 1.5rem;
        }
        .badge-dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--blue);
            animation: blink 2.2s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.25} }

        .hero-h1 {
            font-family: var(--font-display);
            font-size: clamp(3rem, 6vw, 5.25rem);
            font-weight: 800; letter-spacing: -.03em; line-height: 1.05;
            color: var(--ink); margin-bottom: 1.4rem;
            animation: heroIn .75s var(--ease-spring) .14s both;
        }

        .hero-h1 em {
            font-family: var(--font-serif);
            font-style: italic; font-weight: 400;
        }

        .hero-sub {
            font-size: 1.15rem; color: var(--ink-3); font-weight: 400; line-height: 1.75;
            max-width: 520px; margin: 0 auto 2.25rem;
            animation: heroIn .75s var(--ease-spring) .22s both;
        }

        .hero-buttons {
            display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
            animation: heroIn .75s var(--ease-spring) .30s both;
        }

        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: 1rem 2.2rem;
            font-family: var(--font-body); font-size: 1rem; font-weight: 700;
            color: #fff; background: var(--grad);
            border: none; border-radius: var(--r-md);
            cursor: pointer; transition: all .28s var(--ease-spring);
            box-shadow: var(--sh-blue);
            position: relative; overflow: hidden;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 18px 52px rgba(26,86,219,.40); }

        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: 1rem 2.2rem;
            font-family: var(--font-body); font-size: 1rem; font-weight: 600;
            color: var(--ink-2); background: var(--white);
            border: 1.5px solid var(--border); border-radius: var(--r-md);
            cursor: pointer; transition: all .28s var(--ease-spring);
            box-shadow: var(--sh-sm);
        }
        .btn-hero-secondary:hover {
            border-color: var(--blue); color: var(--blue);
             transform: translateY(-3px);
              box-shadow: 0 18px 52px rgba(114, 145, 212, 0.4); 
            background : rgba(103, 139, 218, 0.61);
     
          
          
        }

        .hero-proof {
            display: flex; align-items: center; justify-content: center; gap: 1.1rem;
            margin-top: 2.5rem;
            animation: heroIn .75s var(--ease-spring) .38s both;
        }
        .proof-avatars { display: flex; }
        .proof-av {
            width: 32px; height: 32px; border-radius: 50%;
            border: 2.5px solid var(--surface);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display); font-size: .68rem; font-weight: 800; color: #fff;
            margin-left: -7px; flex-shrink: 0;
        }
        .proof-av:first-child { margin-left: 0; }
        .proof-text { font-size: .85rem; color: var(--ink-3); }
        .proof-text strong { color: var(--ink); font-weight: 700; }

        .hero-img-wrap {
            position: relative;
            z-index: 1;
            width: calc(100% - 3.5rem);
            max-width: 1140px;
            margin: -3rem auto 0;
            padding-bottom: 3rem;
            animation: heroIn 1s var(--ease-spring) .46s both;
        }

        .hero-img-wrap::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 45%;
            background: linear-gradient(to bottom, var(--surface) 0%, rgba(244,246,251,.5) 50%, transparent 100%);
            z-index: 2;
            pointer-events: none;
            border-radius: 22px 22px 0 0;
        }

        .hero-img-wrap img {
            display: block; width: 100%;
            aspect-ratio: 16 / 7;
            object-fit: cover; object-position: center top;
            border-radius: 22px;
            box-shadow:
                0 0 0 1px rgba(30,40,66,.07),
                0 4px 12px rgba(10,15,30,.06),
                0 16px 40px rgba(10,15,30,.10),
                0 48px 100px rgba(10,15,30,.15),
                0 80px 160px rgba(10,15,30,.10);
        }

        /* ─── TRUST BAR ─── */
        .trust {
            background: var(--white);
            border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
            padding: 3rem 1.75rem;
        }
        .trust-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr);
        }
        @media (max-width: 768px) { .trust-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 400px) { .trust-grid { grid-template-columns: 1fr; } }

        .trust-item {
            display: flex; flex-direction: column; align-items: center; gap: .3rem;
            padding: 1rem 2rem;
            border-right: 1px solid var(--border);
        }
        .trust-item:last-child { border-right: none; }
        @media (max-width: 768px) {
            .trust-item:nth-child(2) { border-right: none; }
            .trust-item { border-bottom: 1px solid var(--border); }
            .trust-item:last-child { border-bottom: none; }
        }
        .trust-num {
            font-family: var(--font-display); font-size: 2rem; font-weight: 800;
            letter-spacing: -.03em; line-height: 1;
            background: var(--grad);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .trust-label { font-size: .78rem; font-weight: 500; color: var(--ink-4); text-align: center; }

        /* ─── SECTION WRAPPER ─── */
        .section { padding: 6.5rem 1.75rem; }
        .section-white { background: var(--white); }
        .section-surface { background: var(--surface); }

        .section-head { text-align: center; margin-bottom: 3.5rem; }
        .section-eyebrow {
            display: inline-block;
            font-family: var(--font-body); font-size: .7rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: var(--blue);
            background: rgba(26,86,219,.08); border: 1px solid rgba(26,86,219,.16);
            border-radius: 100px; padding: .28rem .85rem; margin-bottom: .9rem;
        }
        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 2.85rem);
            font-weight: 800; letter-spacing: -.025em; line-height: 1.1;
            color: var(--ink); margin-bottom: .85rem;
        }
        .section-sub {
            font-size: 1.05rem; color: var(--ink-3); font-weight: 400;
            line-height: 1.72; max-width: 520px; margin: 0 auto;
        }

        /* ─── FEATURE CARDS ─── */
        .cards-3 {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;
        }
        @media (max-width: 1024px) { .cards-3 { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 620px)  { .cards-3 { grid-template-columns: 1fr; } }

        .feat-card {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 2rem 1.75rem;
            transition: transform .3s var(--ease-spring), box-shadow .3s;
            position: relative; overflow: hidden;
        }
        .feat-card::before {
            content: ''; position: absolute; inset: 0; border-radius: inherit;
            background: linear-gradient(145deg, rgba(26,86,219,.04), rgba(6,182,212,.03));
            opacity: 0; transition: opacity .3s;
        }
        .feat-card:hover { transform: translateY(-7px); box-shadow: var(--sh-lg); }
        .feat-card:hover::before { opacity: 1; }

        .feat-icon {
            width: 52px; height: 52px; border-radius: var(--r-sm);
            background: var(--grad-soft); border: 1px solid rgba(26,86,219,.12);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.3rem;
            transition: transform .3s var(--ease-spring);
        }
        .feat-icon svg {
            width: 24px; height: 24px;
            color: var(--blue);
            flex-shrink: 0;
        }
        .feat-card:hover .feat-icon { transform: scale(1.08) rotate(-4deg); }
        .feat-h { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--ink); margin-bottom: .55rem; letter-spacing: -.01em; }
        .feat-p { font-size: .875rem; color: var(--ink-3); line-height: 1.65; }

        /* ─── HOW IT WORKS ─── */
        .steps {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;
            position: relative;
        }
        .steps::before {
            content: ''; position: absolute;
            top: 24px; left: calc(10% + 24px); right: calc(10% + 24px);
            height: 1.5px;
            background: linear-gradient(90deg, var(--blue), var(--cyan));
            opacity: .2; z-index: 0;
        }
        @media (max-width: 1024px) { .steps { grid-template-columns: repeat(3, 1fr); } .steps::before { display: none; } }
        @media (max-width: 600px)  { .steps { grid-template-columns: 1fr; } }

        .step {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-lg); padding: 1.6rem 1.25rem;
            text-align: center; position: relative; z-index: 1;
            transition: all .3s var(--ease-spring);
        }
        .step:hover { border-color: var(--blue); box-shadow: 0 12px 36px rgba(26,86,219,.13); transform: translateY(-6px); }

        .step-num {
            width: 48px; height: 48px; margin: 0 auto 1.2rem;
            background: var(--grad); color: #fff;
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display); font-size: 1.3rem; font-weight: 800;
            transition: transform .3s var(--ease-spring);
        }
        .step:hover .step-num { transform: scale(1.1) rotate(6deg); }
        .step-h { font-family: var(--font-display); font-size: .92rem; font-weight: 700; color: var(--ink); margin-bottom: .45rem; }
        .step-p { font-size: .82rem; color: var(--ink-3); line-height: 1.6; }

        /* ─── STATS BAND ─── */
        .stats {
            background: var(--ink); padding: 5rem 1.75rem; position: relative; overflow: hidden;
        }
        .stats::before {
            content: ''; position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.06) 1.5px, transparent 1.5px);
            background-size: 44px 44px;
        }
        .stats-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 2rem; position: relative; z-index: 1; text-align: center;
        }
        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px)  { .stats-grid { grid-template-columns: 1fr; } }

        .stat-num {
            font-family: var(--font-display); font-size: 3rem; font-weight: 800;
            letter-spacing: -.03em; line-height: 1; margin-bottom: .4rem;
            background: var(--grad);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .stat-label { font-size: .9rem; font-weight: 500; color: rgba(255,255,255,.6); }

        /* ─── SPLIT SECTIONS ─── */
        .split { padding: 6rem 1.75rem; }
        .split-bg { background: var(--white); }

        .split-inner {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
        }
        @media (max-width: 1024px) {
            .split-inner { grid-template-columns: 1fr; gap: 3rem; }
            .split-inner.rev .split-text { order: 1; }
            .split-inner.rev .split-vis  { order: 2; }
        }
        .split-inner.rev .split-text { order: 2; }
        .split-inner.rev .split-vis  { order: 1; }

        .split-text .section-eyebrow { display: inline-block; }
        .split-text .section-title { text-align: left; font-size: clamp(1.75rem, 2.8vw, 2.3rem); }
        .split-text .section-sub   { text-align: left; margin: 0 0 2rem; }

        .check-list { list-style: none; display: flex; flex-direction: column; gap: .8rem; margin-bottom: 2rem; }
        .check-list li { display: flex; align-items: flex-start; gap: .7rem; font-size: .92rem; color: var(--ink-2); }
        .check-icon {
            width: 20px; height: 20px; border-radius: 6px;
            background: rgba(26,86,219,.1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: .15rem;
        }
        .check-icon svg { color: var(--blue); }

        /* Mini dashboard illustration */
        .mini-dash {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 1.75rem;
            box-shadow: var(--sh-lg); position: relative;
        }
        .mini-dash::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: var(--grad); border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
        .dash-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: .3rem; }
        .dash-title { font-family: var(--font-display); font-size: .9rem; font-weight: 700; color: var(--ink); }

        .live-pill {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .28rem .7rem;
            background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.22);
            border-radius: 100px;
            font-size: .68rem; font-weight: 700; color: #10b981;
            text-transform: uppercase; letter-spacing: .05em;
        }
        .live-dot { width: 6px; height: 6px; border-radius: 50%; background: #10b981; animation: pulse 1.8s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.35;transform:scale(.85)} }

        .bar-row { display: flex; justify-content: space-between; align-items: flex-end; gap: .55rem; height: 110px; margin: 1.1rem 0 0; }
        .bar-col { display: flex; flex-direction: column; align-items: center; gap: .35rem; flex: 1; }
        .bar { width: 100%; border-radius: 5px 5px 0 0; }
        .bar-lbl { font-size: .65rem; font-weight: 600; color: var(--ink-4); }
        .b1 { height: 58%; background: rgba(26,86,219,.75); }
        .b2 { height: 82%; background: var(--grad); }
        .b3 { height: 44%; background: rgba(26,86,219,.5); }
        .b4 { height: 92%; background: var(--grad); }
        .b5 { height: 68%; background: rgba(26,86,219,.65); }
        .b6 { height: 52%; background: rgba(26,86,219,.45); }
        .b7 { height: 78%; background: var(--grad); }

        .kpi-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; margin-top: 1.1rem; }
        .kpi { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-sm); padding: .75rem; text-align: center; }
        .kpi-n { font-family: var(--font-display); font-size: 1.25rem; font-weight: 800; letter-spacing: -.02em; color: var(--blue); }
        .kpi-l { font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-4); margin-top: .18rem; }

        /* Map illustration */
        .map-mock {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--sh-lg);
        }
        .map-head { padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .map-title { font-family: var(--font-display); font-size: .9rem; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: .5rem; }
        .map-title svg { width: 16px; height: 16px; color: var(--blue); flex-shrink: 0; }
        .map-body { height: 240px; background: linear-gradient(135deg, #eef4ff 0%, #e9f9ff 100%); position: relative; display: flex; align-items: center; justify-content: center; }
        .map-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(26,86,219,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(26,86,219,.06) 1px, transparent 1px); background-size: 28px 28px; }
        .map-pins { position: relative; z-index: 1; display: flex; gap: 2.5rem; }
        .map-pin { display: flex; flex-direction: column; align-items: center; gap: .4rem; cursor: pointer; transition: transform .2s var(--ease-spring); }
        .map-pin:hover { transform: scale(1.1) translateY(-5px); }
        .pin-circle { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-size: .78rem; font-weight: 800; color: #fff; box-shadow: 0 6px 18px rgba(0,0,0,.14); }
        .pin-g { background: #10b981; }
        .pin-r { background: #ef4444; }
        .pin-y { background: #f59e0b; }
        .pin-lbl { font-size: .7rem; font-weight: 700; color: var(--ink-2); background: #fff; padding: .2rem .5rem; border-radius: 6px; box-shadow: var(--sh-sm); }

        /* ─── TESTIMONIALS ─── */
        .testi-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;
        }
        @media (max-width: 1024px) { .testi-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 620px)  { .testi-grid { grid-template-columns: 1fr; } }

        .testi {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 1.9rem;
            transition: transform .3s var(--ease-spring), box-shadow .3s;
        }
        .testi:hover { transform: translateY(-6px); box-shadow: var(--sh-md); }
        .stars { display: flex; gap: .2rem; margin-bottom: .9rem; }
        .stars svg { width: 15px; height: 15px; color: #f59e0b; fill: #f59e0b; }
        .testi-q { font-size: .92rem; color: var(--ink-2); line-height: 1.72; margin-bottom: 1.4rem; font-style: italic; }
        .testi-auth { display: flex; align-items: center; gap: .8rem; }
        .testi-av { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-size: .85rem; font-weight: 800; color: #fff; flex-shrink: 0; }
        .testi-name { font-family: var(--font-display); font-size: .9rem; font-weight: 700; color: var(--ink); }
        .testi-role { font-size: .76rem; color: var(--ink-4); }

        /* ─── CTA BOX ─── */
        .cta-section { padding: 6.5rem 1.75rem; background: var(--white); }
        .cta-box {
            max-width: 880px; margin: 0 auto;
            background: var(--ink); border-radius: var(--r-2xl);
            padding: 5.5rem 2.5rem; text-align: center; position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute;
            top: -50%; left: -20%;
            width: 550px; height: 550px;
            background: radial-gradient(circle, rgba(26,86,219,.35) 0%, transparent 65%);
            border-radius: 50%; animation: float1 9s ease-in-out infinite;
        }
        .cta-box::after {
            content: ''; position: absolute;
            bottom: -40%; right: -10%;
            width: 380px; height: 380px;
            background: radial-gradient(circle, rgba(6,182,212,.22) 0%, transparent 65%);
            border-radius: 50%; animation: float2 11s ease-in-out infinite;
        }
        .cta-box > * { position: relative; z-index: 1; }
        .cta-title { font-family: var(--font-display); font-size: clamp(2rem, 4vw, 2.9rem); font-weight: 800; letter-spacing: -.025em; color: #fff; margin-bottom: .7rem; }
        .cta-sub { font-size: 1.1rem; color: rgba(255,255,255,.65); margin-bottom: 2.5rem; font-weight: 400; }
        .cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

        .btn-white {
            display: inline-flex; align-items: center; gap: .55rem;
            padding: .95rem 2.2rem; background: #fff; color: var(--blue);
            font-family: var(--font-body); font-weight: 700; font-size: 1rem;
            border-radius: var(--r-md); border: none; cursor: pointer;
            transition: all .3s var(--ease-spring);
        }
        .btn-white:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,.22); }

        .btn-outline-white {
            display: inline-flex; align-items: center; gap: .55rem;
            padding: .95rem 2.2rem; background: transparent; color: #fff;
            font-family: var(--font-body); font-weight: 700; font-size: 1rem;
            border-radius: var(--r-md); border: 1.5px solid rgba(255,255,255,.28);
            cursor: pointer; transition: all .3s;
        }
        .btn-outline-white:hover { background: rgba(255,255,255,.1); border-color: #fff; }

        /* ─── TEAM ─── */
        .team-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem;
        }
        @media (max-width: 1024px) { .team-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 620px)  { .team-grid { grid-template-columns: 1fr; } }

        .team-card {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 2rem 1.5rem;
            text-align: center; transition: all .32s var(--ease-spring); overflow: hidden; position: relative;
        }
        .team-card::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px; background: var(--grad);
            transform: scaleX(0); transition: transform .3s; transform-origin: left;
        }
        .team-card:hover::after { transform: scaleX(1); }
        .team-card:hover { transform: translateY(-7px); box-shadow: var(--sh-lg); }
        .team-av {
            width: 72px; height: 72px; margin: 0 auto 1.2rem; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display); font-size: 1.75rem; font-weight: 800; color: #fff;
        }
        .av-a { background: linear-gradient(135deg, #1a56db, #3b82f6); }
        .av-s { background: linear-gradient(135deg, #10b981, #34d399); }
        .av-s2 { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
        .av-m { background: linear-gradient(135deg, #f97316, #fb923c); }
        .team-name { font-family: var(--font-display); font-size: 1.05rem; font-weight: 700; color: var(--ink); margin-bottom: .5rem; }
        .team-role { display: inline-block; font-size: .76rem; font-weight: 700; background: rgba(26,86,219,.09); color: var(--blue); padding: .28rem .8rem; border-radius: 100px; }

        /* ─── BADGES ─── */
        .badges {
            max-width: 1200px; margin: 0 auto;
            display: flex; flex-wrap: wrap; gap: .75rem; justify-content: center;
        }
        .badge {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .65rem 1.2rem;
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            font-family: var(--font-body); font-size: .85rem; font-weight: 600;
            color: var(--ink-2); transition: all .2s;
        }
        .badge:hover { border-color: var(--blue); background: rgba(26,86,219,.04); color: var(--blue); transform: translateY(-2px); }
        .badge svg { color: var(--blue); }

        /* ─── FOOTER ─── */
        .footer { background: var(--ink); padding: 5rem 1.75rem 0; }
        .footer-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 1.6fr 1fr 1fr 1fr; gap: 3rem;
            padding-bottom: 3rem; border-bottom: 1px solid rgba(255,255,255,.06);
        }
        @media (max-width: 1024px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 620px)  { .footer-grid { grid-template-columns: 1fr; } }

        .footer-logo-wrap {
            font-family: var(--font-display); font-size: 1.35rem; font-weight: 800;
            color: #fff; display: flex; align-items: center; gap: .45rem; margin-bottom: 1rem;
        }
        .footer-logo-mark { width: 28px; height: 28px; border-radius: 8px; background: var(--grad); display: flex; align-items: center; justify-content: center; }
        .footer-logo-mark svg { width: 14px; height: 14px; }
        .footer-logo-wrap .accent { color: var(--blue-light); }
        .footer-desc { font-size: .875rem; color: #556;  line-height: 1.7; max-width: 265px; color: rgba(255,255,255,.38); }
        .footer-col h4 { font-family: var(--font-display); font-size: .875rem; font-weight: 700; color: rgba(255,255,255,.85); margin-bottom: 1.25rem; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: .65rem; }
        .footer-col a { font-size: .875rem; color: rgba(255,255,255,.38); transition: color .18s; }
        .footer-col a:hover { color: rgba(255,255,255,.9); }

        .footer-bottom {
            max-width: 1200px; margin: 0 auto;
            padding: 2rem 0;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
        }
        .footer-copy { font-size: .78rem; color: rgba(255,255,255,.28); }
        .footer-socials { display: flex; gap: .65rem; }
        .social-btn {
            width: 34px; height: 34px;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.35); transition: all .2s;
        }
        .social-btn:hover { background: var(--blue); border-color: var(--blue); color: #fff; }

        /* ─── LANG TOGGLE ─── */
        [data-lang-nl], [data-lang-en] { transition: none; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="nav" id="nav">
    <a href="/" class="nav-logo">
        <div class="nav-logo-mark">
            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        Smart<span class="accent">Parking</span>
    </a>

    <nav class="nav-links">
        <a href="#features" class="nav-link" data-lang-nl="Functies" data-lang-en="Features">Functies</a>
        <a href="#how"      class="nav-link" data-lang-nl="Hoe het werkt" data-lang-en="How it works">Hoe het werkt</a>
        <a href="#team"     class="nav-link" data-lang-nl="Team" data-lang-en="Team">Team</a>
    </nav>

    <div class="nav-actions">
        <button class="btn-lang" id="langToggle" onclick="toggleLang()" aria-label="Toggle language">
            <span id="langTxt">🇳🇱 NL</span>
            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
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
                <a href="{{ route('register') }}" class="btn-cta" data-lang-nl="Begin nu →" data-lang-en="Get started →">Begin nu →</a>
            @endif
        @endauth
    </div>
</nav>


<!-- HERO -->
<section class="hero">
    <div class="hero-inner">

        <div class="hero-bg-img" aria-hidden="true">
            <img src="{{ asset('images/hero.jpg') }}" alt="" loading="eager">
        </div>

        <div class="hero-content-wrap">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                <span data-lang-nl="Slimme parkeeroplossing" data-lang-en="Smart parking solution">Slimme parkeeroplossing</span>
            </div>

            <h1 class="hero-h1">
                <span data-lang-nl="Parkeren, maar dan" data-lang-en="Parking, but">Parkeren, maar dan</span><br>
                <em class="gradient-text" data-lang-nl="echt slim." data-lang-en="actually smart.">echt slim.</em>
            </h1>

            <p class="hero-sub" data-lang-nl="Vind en reserveer je parkeerplaats in seconden. Realtime beschikbaarheid, veilige betaling — altijd en overal." data-lang-en="Find and reserve your parking spot in seconds. Real-time availability, secure payment — anywhere, anytime.">Vind en reserveer je parkeerplaats in seconden. Realtime beschikbaarheid, veilige betaling — altijd en overal.</p>

            <div class="hero-buttons">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-hero-primary" data-lang-nl="Admin Dashboard →" data-lang-en="Admin Dashboard →">Admin Dashboard →</a>
                    @else
                        <a href="{{ route('user.reserve') }}" class="btn-hero-primary">
                            <span data-lang-nl="Parkeerplaats vinden" data-lang-en="Find parking">Parkeerplaats vinden</span>
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn-hero-secondary" data-lang-nl="Meer info" data-lang-en="Learn more">Meer info</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-hero-primary">
                        <span data-lang-nl="Gratis starten" data-lang-en="Get started free">Gratis starten</span>
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn-hero-secondary" data-lang-nl="Meer info" data-lang-en="Learn more">Meer info</a>
                @endauth
            </div>

            <div class="hero-proof">
                <div class="proof-avatars">
                    <div class="proof-av" style="background:linear-gradient(135deg,#1a56db,#3b82f6)">A</div>
                    <div class="proof-av" style="background:linear-gradient(135deg,#10b981,#34d399)">S</div>
                    <div class="proof-av" style="background:linear-gradient(135deg,#8b5cf6,#a78bfa)">S</div>
                    <div class="proof-av" style="background:linear-gradient(135deg,#f97316,#fb923c)">M</div>
                </div>
                <div class="proof-text">
                    <span data-lang-nl="Al <strong>50.000+</strong> gebruikers parkeren slimmer" data-lang-en="Already <strong>50,000+</strong> users park smarter">Al <strong>50.000+</strong> gebruikers parkeren slimmer</span>
                </div>
            </div>
        </div>

    </div>
    
    <br>
    <br>

</section>


<!-- TRUST BAR -->
<div class="trust reveal">
    <div class="trust-grid">
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


<!-- FEATURES -->
<section class="section section-white" id="features">
    <div class="section-head reveal">
        <div class="section-eyebrow" data-lang-nl="Voordelen" data-lang-en="Benefits">Voordelen</div>
        <h2 class="section-title" data-lang-nl="Waarom SmartParking?" data-lang-en="Why SmartParking?">Waarom SmartParking?</h2>
        <p class="section-sub" data-lang-nl="We maken parkeren niet alleen gemakkelijker, maar ook slimmer, sneller en veiliger dan ooit." data-lang-en="We make parking not just easier, but smarter, faster and safer than ever.">We maken parkeren niet alleen gemakkelijker, maar ook slimmer, sneller en veiliger dan ooit.</p>
    </div>
    <div class="cards-3">
        <!-- Realtime — Lucide: zap -->
        <div class="feat-card reveal d1">
            <div class="feat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
            </div>
            <h3 class="feat-h" data-lang-nl="Realtime Beschikbaarheid" data-lang-en="Real-time Availability">Realtime Beschikbaarheid</h3>
            <p class="feat-p" data-lang-nl="Live updates elke seconde. Weet altijd exact hoeveel plekken vrij zijn — geen wachten, geen stress." data-lang-en="Live updates every second. Always know exactly how many spots are free — no waiting, no stress.">Live updates elke seconde. Weet altijd exact hoeveel plekken vrij zijn — geen wachten, geen stress.</p>
        </div>
        <!-- 1-Click — Lucide: mouse-pointer-click -->
        <div class="feat-card reveal d2">
            <div class="feat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 4.5a.5.5 0 011 0V12h4.5a.5.5 0 010 1H10v4.5a.5.5 0 01-1 0V4.5z"/>
                    <path d="M14.5 14.5l2.5 5"/>
                    <path d="M9 12L4 7"/>
                    <circle cx="9" cy="12" r="7"/>
                </svg>
            </div>
            <h3 class="feat-h" data-lang-nl="1 Klik Reserveren" data-lang-en="1-Click Booking">1 Klik Reserveren</h3>
            <p class="feat-p" data-lang-nl="Je plek is in seconden gereserveerd. Geen gedoe, geen omslachtig proces — gewoon klikken en klaar." data-lang-en="Your spot reserved in seconds. No hassle, no complicated process — just click and go.">Je plek is in seconden gereserveerd. Geen gedoe, geen omslachtig proces — gewoon klikken en klaar.</p>
        </div>
        <!-- Security — Lucide: shield-check -->
        <div class="feat-card reveal d3">
            <div class="feat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <polyline points="9 12 11 14 15 10"/>
                </svg>
            </div>
            <h3 class="feat-h" data-lang-nl="Veilig & Secure" data-lang-en="Safe & Secure">Veilig & Secure</h3>
            <p class="feat-p" data-lang-nl="Enterprise-grade encryptie en multi-factor authenticatie. Je gegevens altijd in veilige handen." data-lang-en="Enterprise-grade encryption and multi-factor authentication. Your data always in safe hands.">Enterprise-grade encryptie en multi-factor authenticatie. Je gegevens altijd in veilige handen.</p>
        </div>
        <!-- Responsive — Lucide: smartphone -->
        <div class="feat-card reveal d1">
            <div class="feat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                    <line x1="12" y1="18" x2="12.01" y2="18"/>
                </svg>
            </div>
            <h3 class="feat-h" data-lang-nl="100% Responsive" data-lang-en="100% Responsive">100% Responsive</h3>
            <p class="feat-p" data-lang-nl="Perfecte ervaring op elk apparaat. Desktop, tablet, telefoon — elke pixel klopt." data-lang-en="Perfect experience on every device. Desktop, tablet, phone — every pixel is right.">Perfecte ervaring op elk apparaat. Desktop, tablet, telefoon — elke pixel klopt.</p>
        </div>
        <!-- Payment — Lucide: credit-card -->
        <div class="feat-card reveal d2">
            <div class="feat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
            </div>
            <h3 class="feat-h" data-lang-nl="Veilige Betaling" data-lang-en="Secure Payment">Veilige Betaling</h3>
            <p class="feat-p" data-lang-nl="Integratie met toonaangevende betaalsystemen. Snel, veilig en PCI-compliant." data-lang-en="Integration with leading payment systems. Fast, secure and PCI-compliant.">Integratie met toonaangevende betaalsystemen. Snel, veilig en PCI-compliant.</p>
        </div>
        <!-- Management — Lucide: layout-dashboard -->
        <div class="feat-card reveal d3">
            <div class="feat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9"/>
                    <rect x="14" y="3" width="7" height="5"/>
                    <rect x="14" y="12" width="7" height="9"/>
                    <rect x="3" y="16" width="7" height="5"/>
                </svg>
            </div>
            <h3 class="feat-h" data-lang-nl="Volledig Beheer" data-lang-en="Full Management">Volledig Beheer</h3>
            <p class="feat-p" data-lang-nl="Manage al je reserveringen vanuit één dashboard. Wijzig, annuleer of bekijk je volledige geschiedenis." data-lang-en="Manage all reservations from one dashboard. Modify, cancel or view your complete history.">Manage al je reserveringen vanuit één dashboard. Wijzig, annuleer of bekijk je volledige geschiedenis.</p>
        </div>
    </div>
</section>


<!-- SPLIT A — Analytics -->
<section class="split section-surface">
    <div class="split-inner">
        <div class="split-text reveal">
            <div class="section-eyebrow" data-lang-nl="Analytics" data-lang-en="Analytics">Analytics</div>
            <h2 class="section-title" data-lang-nl="Volledige inzichten op één plek" data-lang-en="Complete insights in one place">Volledige inzichten op één plek</h2>
            <p class="section-sub" data-lang-nl="Bekijk bezettingsgraad, piekuren en trends — plan en beheer slimmer." data-lang-en="View occupancy rates, peak hours and trends — plan and manage smarter.">Bekijk bezettingsgraad, piekuren en trends — plan en beheer slimmer.</p>
            <ul class="check-list">
                <li>
                    <span class="check-icon"><svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Live bezettingsgraad per locatie" data-lang-en="Live occupancy rate per location">Live bezettingsgraad per locatie</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Historische data en trendanalyses" data-lang-en="Historical data and trend analyses">Historische data en trendanalyses</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Exporteerbare rapporten (PDF/CSV)" data-lang-en="Exportable reports (PDF/CSV)">Exporteerbare rapporten (PDF/CSV)</span>
                </li>
            </ul>
            @auth
                <a href="{{ route('user.dashboard') }}" class="btn-hero-primary" data-lang-nl="Bekijk dashboard" data-lang-en="View dashboard">Bekijk dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-hero-primary" data-lang-nl="Gratis proberen →" data-lang-en="Try for free →">Gratis proberen →</a>
            @endauth
        </div>

        <div class="split-vis reveal d2">
            <div class="mini-dash">
                <div class="dash-head">
                    <div class="dash-title" data-lang-nl="Bezetting deze week" data-lang-en="Occupancy this week">Bezetting deze week</div>
                    <div class="live-pill"><span class="live-dot"></span>Live</div>
                </div>
                <div class="bar-row">
                    <div class="bar-col"><div class="bar b1"></div><div class="bar-lbl" data-lang-nl="Ma" data-lang-en="Mon">Ma</div></div>
                    <div class="bar-col"><div class="bar b2"></div><div class="bar-lbl" data-lang-nl="Di" data-lang-en="Tue">Di</div></div>
                    <div class="bar-col"><div class="bar b3"></div><div class="bar-lbl" data-lang-nl="Wo" data-lang-en="Wed">Wo</div></div>
                    <div class="bar-col"><div class="bar b4"></div><div class="bar-lbl" data-lang-nl="Do" data-lang-en="Thu">Do</div></div>
                    <div class="bar-col"><div class="bar b5"></div><div class="bar-lbl" data-lang-nl="Vr" data-lang-en="Fri">Vr</div></div>
                    <div class="bar-col"><div class="bar b6"></div><div class="bar-lbl" data-lang-nl="Za" data-lang-en="Sat">Za</div></div>
                    <div class="bar-col"><div class="bar b7"></div><div class="bar-lbl" data-lang-nl="Zo" data-lang-en="Sun">Zo</div></div>
                </div>
                <div class="kpi-row">
                    <div class="kpi"><div class="kpi-n">78%</div><div class="kpi-l" data-lang-nl="Gem. bezetting" data-lang-en="Avg. occupancy">Gem. bezetting</div></div>
                    <div class="kpi"><div class="kpi-n">342</div><div class="kpi-l" data-lang-nl="Reserveringen" data-lang-en="Reservations">Reserveringen</div></div>
                    <div class="kpi"><div class="kpi-n">€12K</div><div class="kpi-l" data-lang-nl="Omzet" data-lang-en="Revenue">Omzet</div></div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- SPLIT B — Map -->
<section class="split split-bg">
    <div class="split-inner rev">
        <div class="split-text reveal d1">
            <div class="section-eyebrow" data-lang-nl="Locaties" data-lang-en="Locations">Locaties</div>
            <h2 class="section-title" data-lang-nl="Vind je plek op de kaart" data-lang-en="Find your spot on the map">Vind je plek op de kaart</h2>
            <p class="section-sub" data-lang-nl="Interactieve kaartweergave toont alle beschikbare plekken in de buurt — realtime bijgewerkt." data-lang-en="Interactive map view shows all available spots nearby — updated in real time.">Interactieve kaartweergave toont alle beschikbare plekken in de buurt — realtime bijgewerkt.</p>
            <ul class="check-list">
                <li>
                    <span class="check-icon"><svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="GPS-gebaseerde locaties in de buurt" data-lang-en="GPS-based nearby locations">GPS-gebaseerde locaties in de buurt</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Kleurcodering voor beschikbaarheid" data-lang-en="Color-coding for availability">Kleurcodering voor beschikbaarheid</span>
                </li>
                <li>
                    <span class="check-icon"><svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                    <span data-lang-nl="Prijsvergelijking per locatie" data-lang-en="Price comparison per location">Prijsvergelijking per locatie</span>
                </li>
            </ul>
            @auth
                <a href="{{ route('user.reserve') }}" class="btn-hero-primary" data-lang-nl="Vind een plek →" data-lang-en="Find a spot →">Vind een plek →</a>
            @else
                <a href="{{ route('register') }}" class="btn-hero-primary" data-lang-nl="Probeer gratis →" data-lang-en="Try for free →">Probeer gratis →</a>
            @endauth
        </div>

        <div class="split-vis reveal">
            <div class="map-mock">
                <div class="map-head">
                    <div class="map-title">
                        <!-- Lucide: map-pin -->
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span data-lang-nl="Parkeerlocaties — Centrum" data-lang-en="Parking locations — City centre">Parkeerlocaties — Centrum</span>
                    </div>
                    <div class="live-pill"><span class="live-dot"></span>Live</div>
                </div>
                <div class="map-body">
                    <div class="map-grid"></div>
                    <div class="map-pins">
                        <div class="map-pin">
                            <div class="pin-circle pin-g">12</div>
                            <div class="pin-lbl" data-lang-nl="Terrein A" data-lang-en="Lot A">Terrein A</div>
                        </div>
                        <div class="map-pin">
                            <div class="pin-circle pin-r">0</div>
                            <div class="pin-lbl" data-lang-nl="Terrein B" data-lang-en="Lot B">Terrein B</div>
                        </div>
                        <div class="map-pin">
                            <div class="pin-circle pin-y">4</div>
                            <div class="pin-lbl" data-lang-nl="Terrein C" data-lang-en="Lot C">Terrein C</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- HOW IT WORKS -->
<section class="section section-surface" id="how">
    <div class="section-head reveal">
        <div class="section-eyebrow" data-lang-nl="Proces" data-lang-en="Process">Proces</div>
        <h2 class="section-title" data-lang-nl="Hoe werkt het?" data-lang-en="How does it work?">Hoe werkt het?</h2>
        <p class="section-sub" data-lang-nl="5 simpele stappen naar jouw gereserveerde parkeerplek." data-lang-en="5 simple steps to your reserved parking spot.">5 simpele stappen naar jouw gereserveerde parkeerplek.</p>
    </div>
    <div class="steps">
        <div class="step reveal d1">
            <div class="step-num">1</div>
            <h3 class="step-h" data-lang-nl="Account aanmaken" data-lang-en="Create account">Account aanmaken</h3>
            <p class="step-p" data-lang-nl="Registreer met je e-mail in 30 seconden." data-lang-en="Register with your email in 30 seconds.">Registreer met je e-mail in 30 seconden.</p>
        </div>
        <div class="step reveal d2">
            <div class="step-num">2</div>
            <h3 class="step-h" data-lang-nl="Beschikbaarheid zien" data-lang-en="Check availability">Beschikbaarheid zien</h3>
            <p class="step-p" data-lang-nl="Realtime vrije plekken op jouw locatie." data-lang-en="Real-time free spots at your location.">Realtime vrije plekken op jouw locatie.</p>
        </div>
        <div class="step reveal d3">
            <div class="step-num">3</div>
            <h3 class="step-h" data-lang-nl="Plek reserveren" data-lang-en="Reserve spot">Plek reserveren</h3>
            <p class="step-p" data-lang-nl="Bevestig je reservering met één klik." data-lang-en="Confirm your reservation with one click.">Bevestig je reservering met één klik.</p>
        </div>
        <div class="step reveal d4">
            <div class="step-num">4</div>
            <h3 class="step-h" data-lang-nl="Veilig betalen" data-lang-en="Pay securely">Veilig betalen</h3>
            <p class="step-p" data-lang-nl="iDEAL, creditcard of andere methoden." data-lang-en="iDEAL, credit card or other methods.">iDEAL, creditcard of andere methoden.</p>
        </div>
        <div class="step reveal d5">
            <div class="step-num">5</div>
            <h3 class="step-h" data-lang-nl="Klaar & parkeer!" data-lang-en="Done & park!">Klaar & parkeer!</h3>
            <p class="step-p" data-lang-nl="Ontvang bevestiging. De plek is van jou." data-lang-en="Receive confirmation. The spot is yours.">Ontvang bevestiging. De plek is van jou.</p>
        </div>
    </div>
</section>


<!-- STATS BAND -->
<section class="stats reveal">
    <div class="stats-grid">
        <div>
            <div class="stat-num">50K+</div>
            <div class="stat-label" data-lang-nl="Gebruikers vertrouwen ons" data-lang-en="Users trust us">Gebruikers vertrouwen ons</div>
        </div>
        <div>
            <div class="stat-num">10K+</div>
            <div class="stat-label" data-lang-nl="Reserveringen per maand" data-lang-en="Reservations per month">Reserveringen per maand</div>
        </div>
        <div>
            <div class="stat-num">99.9%</div>
            <div class="stat-label" data-lang-nl="Uptime garantie" data-lang-en="Uptime guarantee">Uptime garantie</div>
        </div>
        <div>
            <div class="stat-num">24/7</div>
            <div class="stat-label" data-lang-nl="Support & monitoring" data-lang-en="Support & monitoring">Support & monitoring</div>
        </div>
    </div>
</section>


<!-- TESTIMONIALS -->
<section class="section section-white">
    <div class="section-head reveal">
        <div class="section-eyebrow" data-lang-nl="Klanten" data-lang-en="Customers">Klanten</div>
        <h2 class="section-title" data-lang-nl="Wat gebruikers zeggen" data-lang-en="What users say">Wat gebruikers zeggen</h2>
        <p class="section-sub" data-lang-nl="Duizenden tevreden gebruikers parkeren dagelijks slimmer met SmartParking." data-lang-en="Thousands of satisfied users park smarter every day with SmartParking.">Duizenden tevreden gebruikers parkeren dagelijks slimmer met SmartParking.</p>
    </div>
    <div class="testi-grid">
        <div class="testi reveal d1">
            <div class="stars">
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <p class="testi-q" data-lang-nl='"Nooit meer rondrijden op zoek naar een plek. SmartParking toont me direct waar ik terecht kan. Een echte game-changer!"' data-lang-en='"Never driving around looking for a spot again. SmartParking shows me immediately where to go. A real game-changer!"'>"Nooit meer rondrijden op zoek naar een plek. SmartParking toont me direct waar ik terecht kan. Een echte game-changer!"</p>
            <div class="testi-auth">
                <div class="testi-av" style="background:linear-gradient(135deg,#1a56db,#3b82f6)">M</div>
                <div>
                    <div class="testi-name">Mark de Vries</div>
                    <div class="testi-role" data-lang-nl="Dagelijkse forens, Utrecht" data-lang-en="Daily commuter, Utrecht">Dagelijkse forens, Utrecht</div>
                </div>
            </div>
        </div>
        <div class="testi reveal d2">
            <div class="stars">
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <p class="testi-q" data-lang-nl='"Als beheerder heb ik eindelijk volledig inzicht in de bezetting. De analytics zijn ongelooflijk waardevol voor onze planning."' data-lang-en='"As a manager I finally have full insight into occupancy. The analytics are incredibly valuable for our planning."'>"Als beheerder heb ik eindelijk volledig inzicht in de bezetting. De analytics zijn ongelooflijk waardevol voor onze planning."</p>
            <div class="testi-auth">
                <div class="testi-av" style="background:linear-gradient(135deg,#10b981,#34d399)">S</div>
                <div>
                    <div class="testi-name">Sophie Janssen</div>
                    <div class="testi-role" data-lang-nl="Parkeerbeheeder, Amsterdam" data-lang-en="Parking manager, Amsterdam">Parkeerbeheeder, Amsterdam</div>
                </div>
            </div>
        </div>
        <div class="testi reveal d3">
            <div class="stars">
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <p class="testi-q" data-lang-nl='"De app werkt perfect op mijn telefoon. Reserveren gaat zo snel — ik gebruik het elke dag voor het werk."' data-lang-en='"The app works perfectly on my phone. Booking is so fast — I use it every day for work."'>"De app werkt perfect op mijn telefoon. Reserveren gaat zo snel — ik gebruik het elke dag voor het werk."</p>
            <div class="testi-auth">
                <div class="testi-av" style="background:linear-gradient(135deg,#f97316,#fb923c)">R</div>
                <div>
                    <div class="testi-name">Riad El Ouali</div>
                    <div class="testi-role" data-lang-nl="Ondernemer, Rotterdam" data-lang-en="Entrepreneur, Rotterdam">Ondernemer, Rotterdam</div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- CTA -->
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


<!-- TEAM -->
<section class="section section-surface" id="team">
    <div class="section-head reveal">
        <div class="section-eyebrow" data-lang-nl="Team" data-lang-en="Team">Team</div>
        <h2 class="section-title" data-lang-nl="Bouwers van SmartParking" data-lang-en="Builders of SmartParking">Bouwers van SmartParking</h2>
        <p class="section-sub" data-lang-nl="Een getalenteerd team dat samen iets speciaals heeft gecreëerd." data-lang-en="A talented team that created something special together.">Een getalenteerd team dat samen iets speciaals heeft gecreëerd.</p>
    </div>
    <div class="team-grid">
        <div class="team-card reveal d1">
            <div class="team-av av-a">A</div>
            <div class="team-name">Adem</div>
            <div class="team-role" data-lang-nl="Backend & Database" data-lang-en="Backend & Database">Backend & Database</div>
        </div>
        <div class="team-card reveal d2">
            <div class="team-av av-s">S</div>
            <div class="team-name">Salim</div>
            <div class="team-role" data-lang-nl="Frontend & Design" data-lang-en="Frontend & Design">Frontend & Design</div>
        </div>
        <div class="team-card reveal d3">
            <div class="team-av av-s2">S</div>
            <div class="team-name">Sjoerd</div>
            <div class="team-role" data-lang-nl="Frontend & Backend" data-lang-en="Frontend & Backend">Frontend & Backend</div>
        </div>
        <div class="team-card reveal d4">
            <div class="team-av av-m">M</div>
            <div class="team-name">Mokhless</div>
            <div class="team-role" data-lang-nl="Frontend & Backend" data-lang-en="Frontend & Backend">Frontend & Backend</div>
        </div>
    </div>
</section>


<!-- ALL FEATURES -->
<section class="section section-white">
    <div class="section-head reveal">
        <div class="section-eyebrow" data-lang-nl="Mogelijkheden" data-lang-en="Capabilities">Mogelijkheden</div>
        <h2 class="section-title" data-lang-nl="Alles inbegrepen" data-lang-en="Everything included">Alles inbegrepen</h2>
        <p class="section-sub" data-lang-nl="Volledig uitgerust met alles wat je nodig hebt voor slimmer parkeren." data-lang-en="Fully equipped with everything you need for smarter parking.">Volledig uitgerust met alles wat je nodig hebt voor slimmer parkeren.</p>
    </div>
    <div class="badges reveal d1">
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Realtime beschikbaarheid" data-lang-en="Real-time availability">Realtime beschikbaarheid</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Veilige authenticatie" data-lang-en="Secure authentication">Veilige authenticatie</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Admin dashboard" data-lang-en="Admin dashboard">Admin dashboard</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round" stroke-linejoin="round"/><line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round" stroke-linejoin="round"/><line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Reserveringssysteem" data-lang-en="Reservation system">Reserveringssysteem</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Responsief design" data-lang-en="Responsive design">Responsief design</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Veilig betaalsysteem" data-lang-en="Secure payment">Veilig betaalsysteem</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Reserveringsbeheer" data-lang-en="Booking management">Reserveringsbeheer</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Rol-gebaseerde toegang" data-lang-en="Role-based access">Rol-gebaseerde toegang</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Gebruikersbeheer" data-lang-en="User management">Gebruikersbeheer</span></span>
        <span class="badge"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-lang-nl="Multi-locatie beheer" data-lang-en="Multi-location management">Multi-locatie beheer</span></span>
    </div>
</section>


<!-- FOOTER -->
<footer class="footer">
    <div class="footer-grid">
        <div class="footer-col">
            <div class="footer-logo-wrap">
                <div class="footer-logo-mark">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                Smart<span class="accent">Parking</span>
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
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-copy">
            <span data-lang-nl="&copy; {{ date('Y') }} SmartParking — Gebouwd door Adem, Salim, Sjoerd &amp; Mokhless." data-lang-en="&copy; {{ date('Y') }} SmartParking — Built by Adem, Salim, Sjoerd &amp; Mokhless.">&copy; {{ date('Y') }} SmartParking — Gebouwd door Adem, Salim, Sjoerd &amp; Mokhless.</span>
        </div>
        <div class="footer-socials">
            <a href="#" class="social-btn" aria-label="GitHub">
                <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
            </a>
            <a href="#" class="social-btn" aria-label="Speed">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </a>
            <a href="#" class="social-btn" aria-label="Email">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </a>
        </div>
    </div>
</footer>


<script>
    /* ── LANGUAGE ── */
    const LANG_KEY = 'sp_lang';

    function applyLang(lang) {
        const isEN = lang === 'en';
        const btn = document.getElementById('langTxt');
        if (btn) btn.textContent = isEN ? '🇬🇧 EN' : '🇳🇱 NL';
        const attrKey = isEN ? 'data-lang-en' : 'data-lang-nl';
        document.querySelectorAll('[data-lang-nl],[data-lang-en]').forEach(el => {
            const val = el.getAttribute(attrKey);
            if (val === null) return;
            if (el.children.length === 0) el.innerHTML = val;
        });
        document.documentElement.lang = isEN ? 'en' : 'nl';
        try { localStorage.setItem(LANG_KEY, lang); } catch(e) {}
    }

    function toggleLang() {
        let cur = 'nl';
        try { cur = localStorage.getItem(LANG_KEY) || 'nl'; } catch(e) {}
        applyLang(cur === 'nl' ? 'en' : 'nl');
    }

    (function() {
        let saved = 'nl';
        try { saved = localStorage.getItem(LANG_KEY) || 'nl'; } catch(e) {}
        applyLang(saved);
    })();

    /* ── SCROLL REVEAL ── */
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* ── SCROLLED NAV ── */
    const nav = document.getElementById('nav');
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 50);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
</script>

</body>
</html>
ENDOFFILE
echo "Done"