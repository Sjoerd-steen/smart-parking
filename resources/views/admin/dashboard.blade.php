@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    .dash {
        font-family: 'DM Sans', sans-serif;
        color: #0f172a;
    }

    /* ── PAGE HEADER ── */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .dash-eyebrow {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #2563eb;
        margin-bottom: 0.35rem;
    }

    .dash-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.25rem;
    }

    .dash-sub {
        font-size: 0.825rem;
        color: #64748b;
        font-weight: 300;
    }

    .live-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.8rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #2563eb;
    }

    .live-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #2563eb;
        animation: pulse 1.8s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.7); }
    }

    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 500px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        border-radius: 16px 16px 0 0;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.07); }
    .stat-card:hover::before { opacity: 1; }

    .stat-card.blue::before   { background: linear-gradient(90deg, #2563eb, #06b6d4); }
    .stat-card.indigo::before { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
    .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #ec4899); }
    .stat-card.green::before  { background: linear-gradient(90deg, #10b981, #34d399); }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg { width: 18px; height: 18px; }

    .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon.indigo { background: #eef2ff; color: #6366f1; }
    .stat-icon.purple { background: #faf5ff; color: #8b5cf6; }
    .stat-icon.green  { background: #f0fdf4; color: #10b981; }

    .stat-live {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .stat-live-dot {
        width: 5px; height: 5px;
        border-radius: 50%;
        background: #10b981;
        animation: pulse 2s ease infinite;
    }

    .stat-value {
        font-family: 'Syne', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    /* ── MAIN GRID ── */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }

    /* ── PANEL (shared card style) ── */
    .panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
    }

    .panel-title {
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1.25rem;
        padding-bottom: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .panel-title-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel-title-icon svg { width: 14px; height: 14px; color: #2563eb; }

    /* ── QUICK LINKS ── */
    .quick-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.825rem;
        font-weight: 500;
        color: #334155;
        transition: all 0.18s;
        margin-bottom: 0.5rem;
    }

    .quick-link:last-child { margin-bottom: 0; }

    .quick-link:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
        transform: translateX(3px);
    }

    .quick-link-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.18s;
    }

    .quick-link:hover .quick-link-icon { transform: scale(1.1); }

    .quick-link-icon.purple { background: #faf5ff; color: #8b5cf6; }
    .quick-link-icon.blue   { background: #eff6ff; color: #2563eb; }
    .quick-link-icon svg { width: 15px; height: 15px; }

    .quick-link-arrow {
        margin-left: auto;
        color: #cbd5e1;
        transition: transform 0.18s, color 0.18s;
    }

    .quick-link:hover .quick-link-arrow { transform: translateX(2px); color: #2563eb; }

    /* ── OCCUPANCY ── */
    .occ-number {
        font-family: 'Syne', sans-serif;
        font-size: 3.5rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        line-height: 1;
        margin-bottom: 0.25rem;
        text-align: center;
    }

    .occ-number.low    { color: #2563eb; }
    .occ-number.medium { color: #f59e0b; }
    .occ-number.high   { color: #ef4444; }

    .occ-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #94a3b8;
        text-align: center;
        margin-bottom: 1.25rem;
    }

    .occ-bar-track {
        height: 8px;
        background: #f1f5f9;
        border-radius: 100px;
        overflow: hidden;
        margin-bottom: 0.75rem;
    }

    .occ-bar-fill {
        height: 100%;
        border-radius: 100px;
        transition: width 0.8s ease;
    }

    .occ-bar-fill.low    { background: linear-gradient(90deg, #2563eb, #06b6d4); }
    .occ-bar-fill.medium { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .occ-bar-fill.high   { background: linear-gradient(90deg, #ef4444, #f97316); }

    .occ-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* ── LIVE OVERVIEW ── */
    .live-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        margin-bottom: 0.5rem;
    }

    .live-row:last-child { margin-bottom: 0; }

    .live-row.green { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .live-row.blue  { background: #eff6ff; border: 1px solid #bfdbfe; }

    .live-row-label {
        font-size: 0.825rem;
        font-weight: 500;
    }

    .live-row.green .live-row-label { color: #166534; }
    .live-row.blue  .live-row-label { color: #1e40af; }

    .live-row-value {
        font-family: 'Syne', sans-serif;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .live-row.green .live-row-value { color: #15803d; }
    .live-row.blue  .live-row-value { color: #1d4ed8; }

    /* ── TABLE ── */
    .table-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-header-left {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-title {
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
    }

    .table-link {
        font-size: 0.775rem;
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: gap 0.15s;
    }

    .table-link:hover { gap: 0.5rem; }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.825rem;
    }

    .data-table thead tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .data-table th {
        padding: 0 0 0.75rem;
        text-align: left;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }

    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #f8fafc; }

    .data-table td {
        padding: 0.875rem 0;
        color: #334155;
        vertical-align: middle;
    }

    .data-table td:first-child { font-weight: 500; color: #0f172a; }

    .td-muted { color: #94a3b8 !important; font-weight: 400 !important; }
    .td-price { font-family: 'Syne', sans-serif; font-weight: 700; color: #0f172a !important; }

    /* User avatar inline */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .user-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-family: 'Syne', sans-serif;
        font-size: 0.65rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.6rem;
        border-radius: 100px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .badge-actief     { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-geannuleerd { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-afgelopen  { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
    .badge-default    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
</style>

<div class="dash">

    {{-- PAGE HEADER --}}
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">Beheerder</div>
            <h1 class="dash-title">Beheerderspaneel</h1>
            <p class="dash-sub">Real-time inzicht in SmartParking prestaties</p>
        </div>
        <div class="live-badge">
            <span class="live-dot"></span>
            Live data
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-top">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Gebruikers</div>
        </div>

        <div class="stat-card indigo">
            <div class="stat-top">
                <div class="stat-icon indigo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $totalSpots }}</div>
            <div class="stat-label">Parkeerplaatsen</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-top">
                <div class="stat-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $totalReservations }}</div>
            <div class="stat-label">Reserveringen</div>
        </div>

        <div class="stat-card green">
            <div class="stat-top">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">€{{ number_format($omzet, 2) }}</div>
            <div class="stat-label">Omzet</div>
        </div>
    </div>

    {{-- MIDDLE ROW --}}
    <div class="main-grid">

        {{-- Quick Links --}}
        <div class="panel">
            <div class="panel-title">
                <div class="panel-title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                Snel navigeren
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="quick-link">
                <div class="quick-link-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                Reserveringen beheren
                <span class="quick-link-arrow">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="quick-link">
                <div class="quick-link-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                Gebruikers beheren
                <span class="quick-link-arrow">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
        </div>

        {{-- Occupancy --}}
        <div class="panel">
            <div class="panel-title">
                <div class="panel-title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                Bezettingsgraad
            </div>
            <div class="occ-number {{ $bezettingsgraad > 80 ? 'high' : ($bezettingsgraad > 50 ? 'medium' : 'low') }}">
                {{ $bezettingsgraad }}%
            </div>
            <div class="occ-label">van alle plaatsen bezet</div>
            <div class="occ-bar-track">
                <div class="occ-bar-fill {{ $bezettingsgraad > 80 ? 'high' : ($bezettingsgraad > 50 ? 'medium' : 'low') }}"
                     style="width: {{ $bezettingsgraad }}%"></div>
            </div>
            <div class="occ-meta">
                <span>{{ $beschikbaar }} beschikbaar</span>
                <span>{{ $totalSpots - $beschikbaar }} bezet</span>
            </div>
        </div>

        {{-- Live overview --}}
        <div class="panel">
            <div class="panel-title">
                <div class="panel-title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                Live overzicht
            </div>
            <div class="live-row green">
                <span class="live-row-label">Beschikbaar</span>
                <span class="live-row-value">{{ $beschikbaar }}</span>
            </div>
            <div class="live-row blue">
                <span class="live-row-label">Actieve reserveringen</span>
                <span class="live-row-value">{{ $actief }}</span>
            </div>
        </div>

    </div>

    {{-- RECENT RESERVATIONS TABLE --}}
    <div class="table-panel">
        <div class="table-header">
            <div class="table-header-left">
                <div class="panel-title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="table-title">Recente reserveringen</span>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="table-link">
                Alles bekijken
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Gebruiker</th>
                        <th>Parkeerplaats</th>
                        <th>Datum</th>
                        <th>Prijs</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentReservations as $res)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($res->user->name, 0, 2)) }}</div>
                                    {{ $res->user->name }}
                                </div>
                            </td>
                            <td>{{ $res->spot_details["name"] ?? "Onbekend" }}</td>
                            <td class="td-muted">{{ $res->datum->format('d-m-Y') }}</td>
                            <td class="td-price">€{{ number_format($res->totaal_prijs, 2) }}</td>
                            <td>
                                @php $s = $res->status; @endphp
                                <span class="badge {{ $s === 'actief' ? 'badge-actief' : ($s === 'geannuleerd' ? 'badge-geannuleerd' : ($s === 'afgelopen' ? 'badge-afgelopen' : 'badge-default')) }}">
                                    {{ ucfirst($s) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection