@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    .dash { font-family: 'DM Sans', sans-serif; color: #0f172a; }

    .dash-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; }
    .dash-eyebrow { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #2563eb; margin-bottom: 0.35rem; }
    .dash-title { font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a; line-height: 1.1; margin-bottom: 0.25rem; }
    .dash-sub { font-size: 0.825rem; color: #64748b; font-weight: 300; }

    .live-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.8rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 100px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: #2563eb; }
    .live-dot { width: 6px; height: 6px; border-radius: 50%; background: #2563eb; animation: pulse 1.8s ease-in-out infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.3; transform: scale(0.7); } }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 500px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 1.5rem; position: relative; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; border-radius: 16px 16px 0 0; opacity: 0; transition: opacity 0.2s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.07); }
    .stat-card:hover::before { opacity: 1; }
    .stat-card.green::before  { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.red::before    { background: linear-gradient(90deg, #ef4444, #f97316); }
    .stat-card.blue::before   { background: linear-gradient(90deg, #2563eb, #06b6d4); }
    .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #ec4899); }

    .stat-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .stat-icon svg { width: 18px; height: 18px; }
    .stat-icon.green  { background: #f0fdf4; color: #10b981; }
    .stat-icon.red    { background: #fef2f2; color: #ef4444; }
    .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon.purple { background: #faf5ff; color: #8b5cf6; }

    .stat-live { display: flex; align-items: center; gap: 4px; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: #94a3b8; }
    .stat-live-dot { width: 5px; height: 5px; border-radius: 50%; background: #10b981; animation: pulse 2s ease infinite; }
    .stat-value { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a; line-height: 1; margin-bottom: 0.25rem; }
    .stat-label { font-size: 0.72rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: #94a3b8; }

    .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }

    .panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 1.5rem; }
    .panel-title { font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700; color: #0f172a; margin-bottom: 1.25rem; padding-bottom: 0.875rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 0.5rem; }
    .panel-title-icon { width: 28px; height: 28px; border-radius: 7px; background: #eff6ff; display: flex; align-items: center; justify-content: center; }
    .panel-title-icon svg { width: 14px; height: 14px; color: #2563eb; }

    .occ-label { font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #94a3b8; display: flex; justify-content: space-between; margin-bottom: 0.4rem; }
    .occ-bar-track { height: 8px; background: #f1f5f9; border-radius: 100px; overflow: hidden; margin-bottom: 1.25rem; }
    .occ-bar-fill { height: 100%; border-radius: 100px; transition: width 0.8s ease; }
    .occ-bar-fill.low    { background: linear-gradient(90deg, #2563eb, #06b6d4); }
    .occ-bar-fill.medium { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .occ-bar-fill.high   { background: linear-gradient(90deg, #ef4444, #f97316); }

    .map-legend { display: flex; gap: 1.5rem; justify-content: center; padding: 0.6rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.75rem; color: #64748b; font-weight: 500; margin-top: 1rem; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 4px; vertical-align: middle; }

    .quick-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; text-decoration: none; font-size: 0.825rem; font-weight: 500; color: #334155; transition: all 0.18s; margin-bottom: 0.5rem; }
    .quick-link:last-child { margin-bottom: 0; }
    .quick-link:hover { background: #eff6ff; border-color: #bfdbfe; color: #2563eb; transform: translateX(3px); }
    .quick-link-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .quick-link-icon svg { width: 15px; height: 15px; }
    .quick-link-icon.purple { background: #faf5ff; color: #8b5cf6; }
    .quick-link-icon.blue   { background: #eff6ff; color: #2563eb; }
    .quick-link-arrow { margin-left: auto; color: #cbd5e1; }
    .quick-link:hover .quick-link-arrow { color: #2563eb; }

    .res-card { padding: 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 0.5rem; transition: border-color 0.15s; }
    .res-card:hover { border-color: #bfdbfe; }
    .res-card:last-child { margin-bottom: 0; }
    .res-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 800; color: #0f172a; }
    .res-meta { display: flex; gap: 0.75rem; font-size: 0.75rem; color: #64748b; margin: 0.35rem 0; }
    .res-meta svg { width: 14px; height: 14px; flex-shrink: 0; }
    .res-footer { border-top: 1px solid #e2e8f0; padding-top: 0.6rem; margin-top: 0.6rem; display: flex; justify-content: space-between; align-items: center; }
    .res-price { font-family: 'Syne', sans-serif; font-weight: 800; color: #10b981; font-size: 1rem; }
    .res-empty { text-align: center; padding: 2rem 0; color: #94a3b8; font-size: 0.85rem; }
    .res-empty svg { width: 40px; height: 40px; margin: 0 auto 0.75rem; display: block; }

    .badge { display: inline-flex; align-items: center; padding: 0.25rem 0.6rem; border-radius: 100px; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; }
    .badge-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    .btn-primary-block { display: block; text-align: center; padding: 0.8rem 1rem; background: #2563eb; color: #fff !important; border-radius: 10px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none; margin-top: 1rem; transition: background 0.15s; }
    .btn-primary-block:hover { background: #1d4ed8; }

    .map-footer { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 1rem; font-size: 0.72rem; color: #94a3b8; }
    .map-refresh { color: #2563eb; font-weight: 600; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.25rem; }
    .map-refresh:hover { text-decoration: underline; }

    html.dark .dash { color: var(--text-main); }
    html.dark .dash-title { color: var(--text-main); }
    html.dark .stat-card { background: var(--card-bg); border-color: var(--card-border); }
    html.dark .stat-value { color: var(--text-main); }
    html.dark .stat-label { color: var(--text-muted); }
    html.dark .panel { background: var(--card-bg); border-color: var(--card-border); }
    html.dark .panel-title { color: var(--text-main); border-bottom-color: var(--border); }
    html.dark .occ-bar-track { background: var(--surface-2); }
    html.dark .map-legend { background: var(--surface); border-color: var(--border); color: var(--text-muted); }
    html.dark .quick-link { background: var(--surface); border-color: var(--border); color: var(--ink-3); }
    html.dark .res-card { background: var(--surface); border-color: var(--border); }
    html.dark .res-title { color: var(--text-main); }
    html.dark .res-meta { color: var(--text-muted); }
    html.dark .res-price { color: #6ee7b7; }
    html.dark .dash-sub { color: var(--text-muted); }
    html.dark .res-empty { color: var(--text-muted); }
</style>

<div class="dash">

    {{-- PAGE HEADER --}}
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">Gebruiker</div>
            <h1 class="dash-title">Mijn Dashboard</h1>
            <p class="dash-sub">Real-time overzicht van uw parkeeractiviteit</p>
        </div>
        <div class="live-badge">
            <span class="live-dot"></span>
            Live data
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-top">
                <div class="stat-icon green">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $beschikbaar }}</div>
            <div class="stat-label">Beschikbaar</div>
        </div>

        <div class="stat-card red">
            <div class="stat-top">
                <div class="stat-icon red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $bezet + $gereserveerd }}</div>
            <div class="stat-label">Bezet</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-top">
                <div class="stat-icon blue">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $totalSpots }}</div>
            <div class="stat-label">Totaal</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-top">
                <div class="stat-icon purple">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div class="stat-live"><span class="stat-live-dot"></span> Live</div>
            </div>
            <div class="stat-value">{{ $bezettingsgraad }}%</div>
            <div class="stat-label">Bezettingsgraad</div>
        </div>
    </div>

    {{-- MAIN GRID: Kaart + Sidebar --}}
    <div class="main-grid">

        {{-- PARKEERKAART --}}
        <div class="panel">
            <div class="panel-title" style="justify-content: space-between;">
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <div class="panel-title-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    Parkeermap
                </div>
                <a href="{{ route('user.reserve') }}" style="font-size:0.775rem; font-weight:700; color:#2563eb; text-decoration:none; display:flex; align-items:center; gap:0.25rem;">
                    Nieuwe reservering
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="occ-label">
                <span>Bezettingsgraad</span>
                <span>{{ $bezettingsgraad }}%</span>
            </div>
            <div class="occ-bar-track">
                <div class="occ-bar-fill {{ $bezettingsgraad > 80 ? 'high' : ($bezettingsgraad > 50 ? 'medium' : 'low') }}"
                     style="width: {{ $bezettingsgraad }}%"></div>
            </div>

            <div id="map" style="width:100%; height:500px; border-radius:10px; border:1px solid #e2e8f0; z-index:1;"></div>

            <div class="map-legend" style="margin-top:1rem;">
                <span><span class="legend-dot" style="background:#10b981;"></span>Beschikbaar</span>
                <span><span class="legend-dot" style="background:#f59e0b;"></span>Gereserveerd</span>
                <span><span class="legend-dot" style="background:#ef4444;"></span>Bezet</span>
            </div>

            <div class="map-footer">
                <span id="lastUpdate"></span>
                <button class="map-refresh" onclick="location.reload()">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Vernieuwen
                </button>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div style="display:flex; flex-direction:column; gap:1rem;">

            {{-- Snel navigeren --}}
            <div class="panel">
                <div class="panel-title">
                    <div class="panel-title-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    Snel navigeren
                </div>
                <a href="{{ route('user.reserve') }}" class="quick-link">
                    <div class="quick-link-icon purple">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    Nieuwe reservering
                    <span class="quick-link-arrow">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
                <a href="{{ route('user.vehicles.index') }}" class="quick-link">
                    <div class="quick-link-icon blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 11h8m-8 4h8m-10 4h12l1-5H5l1 5z"/></svg>
                    </div>
                    Mijn voertuigen
                    <span class="quick-link-arrow">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
            </div>

            {{-- Recente reserveringen --}}
            <div class="panel">
                <div class="panel-title">
                    <div class="panel-title-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    Recente reserveringen
                </div>

                @if($mijnReservaties->isEmpty())
                    <div class="res-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Geen actieve reserveringen
                    </div>
                @else
                    @foreach($mijnReservaties as $res)
                        <div class="res-card">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <span class="res-title">{{ $res->spot_details["name"] ?? "Onbekend" }}</span>
                                <span class="badge badge-blue">{{ $res->voertuig }}</span>
                            </div>
                            <div class="res-meta">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $res->datum->format('d-m-Y') }}
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($res->start_tijd)->format('H:i') }} – {{ \Carbon\Carbon::parse($res->eind_tijd)->format('H:i') }}
                            </div>
                            @if($res->kenteken)
                                <span style="font-size:0.72rem; font-family:monospace; letter-spacing:0.1em; background:#f1f5f9; border:1px solid #e2e8f0; padding:0.2rem 0.5rem; border-radius:4px; color:#64748b;">{{ $res->kenteken }}</span>
                            @endif
                            <div class="res-footer">
                                <span style="font-size:0.72rem; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em;">Totaal</span>
                                <span class="res-price">€{{ number_format($res->totaal_prijs, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif

                <a href="{{ route('user.reservations') }}" class="btn-primary-block">Alle reserveringen bekijken</a>
            </div>

        </div>
    </div>

</div>

<script>
    document.getElementById('lastUpdate').textContent = 'Bijgewerkt: ' + new Date().toLocaleTimeString('nl-NL');

    var map = L.map('map').setView([51.9225, 4.47917], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var spots = @json($spots);
    Object.values(spots).forEach(function(spot) {
        var statusColor = spot.status === 'beschikbaar' ? '#10b981' : (spot.status === 'gereserveerd' ? '#f59e0b' : '#ef4444');

        L.circleMarker([spot.lat, spot.lng], {
            radius: 8,
            fillColor: statusColor,
            color: '#ffffff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.85
        }).addTo(map).bindPopup(`
            <div style="font-family:'DM Sans',sans-serif; font-size:13px; color:#0f172a;">
                <strong style="font-size:14px;">${spot.name}</strong><br>
                <span style="display:inline-block; margin-top:4px; padding:2px 8px; border-radius:100px; background:${statusColor}; color:#fff; font-size:11px; font-weight:700; text-transform:uppercase;">
                    ${spot.status.charAt(0).toUpperCase() + spot.status.slice(1)}
                </span><br>
                <span style="color:#64748b; margin-top:4px; display:block;">€${Number(spot.price_per_hour).toFixed(2)} / uur</span>
            </div>
            ${spot.status === 'beschikbaar' ? `<a href="/user/reserveren?spot_id=${spot.id}" style="display:block; margin-top:8px; text-align:center; background:#2563eb; color:#fff; font-weight:700; font-size:12px; padding:6px 12px; border-radius:8px; text-decoration:none;">Reserveer →</a>` : ''}
        `);
    });

    setTimeout(() => location.reload(), 30000);
</script>
@endsection
