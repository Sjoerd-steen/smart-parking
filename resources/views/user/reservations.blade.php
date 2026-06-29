@extends('layouts.app')
@section('title', 'Mijn Reserveringen')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    :root {
        --bg-primary: #fff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #eff6ff;
        --text-primary: #0f172a;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-light: #e2e8f0;
        --border-lighter: #f1f5f9;
        --accent-blue: #2563eb;
        --accent-blue-dark: #1d4ed8;
    }

    html.dark {
        --bg-primary: #1a2338;
        --bg-secondary: #141a2e;
        --bg-tertiary: #1e3a8a;
        --text-primary: #e8edf5;
        --text-secondary: #8fa3c8;
        --text-muted: #5a7299;
        --border-light: #243050;
        --border-lighter: #2d3f60;
        --accent-blue: #4d8ef0;
        --accent-blue-dark: #6ba3f5;
    }

    .dash {
        font-family: 'DM Sans', sans-serif;
        color: var(--text-primary);
    }

    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-light);
    }

    .dash-eyebrow {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--accent-blue);
        margin-bottom: 0.35rem;
    }

    .dash-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-primary);
        line-height: 1.1;
        margin-bottom: 0.25rem;
    }

    .dash-sub {
        font-size: 0.825rem;
        color: var(--text-secondary);
        font-weight: 300;
    }

    .search-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-light);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .search-title {
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        padding-bottom: 0.875rem;
        border-bottom: 1px solid var(--border-lighter);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-title-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: var(--bg-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-title-icon svg { width: 14px; height: 14px; color: var(--accent-blue); }

    .search-form {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .search-input-group {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .search-label {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .search-input, .search-select {
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-light);
        border-radius: 10px;
        font-size: 0.875rem;
        color: var(--text-primary);
        background: var(--bg-primary);
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
    }

    .search-input:focus, .search-select:focus {
        outline: none;
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .search-input::placeholder {
        color: #cbd5e1;
    }

    .search-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, var(--accent-blue), var(--accent-blue-dark));
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
    }

    .search-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .search-button svg { width: 16px; height: 16px; }

    .clear-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: var(--bg-secondary);
        color: var(--text-secondary);
        border: 1px solid var(--border-light);
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
    }

    .clear-button:hover {
        background: var(--bg-tertiary);
        border-color: var(--border-light);
        transform: translateY(-2px);
    }

    .clear-button svg { width: 14px; height: 14px; }

    .reservations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .reservation-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.18s;
    }

    .reservation-card:hover {
        border-color: var(--accent-blue);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.1);
    }

    .reservation-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-lighter);
    }

    .reservation-title {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .reservation-location {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
    }

    .status-badge {
        display: inline-flex;
        padding: 0.4rem 0.75rem;
        border-radius: 100px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1px solid transparent;
    }

    .status-actief { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .status-geannuleerd { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .status-voltooid { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }

    html.dark .status-actief { background: #1e3a8a; color: #60a5fa; border-color: #3b82f6; }
    html.dark .status-geannuleerd { background: #7f1d1d; color: #fca5a5; border-color: #dc2626; }
    html.dark .status-voltooid { background: #1b4332; color: #6ee7b7; border-color: #10b981; }

    .reservation-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        background: var(--bg-secondary);
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--border-light);
    }

    .detail-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: 0.4rem;
    }

    .detail-value {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .detail-sub {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
        font-family: 'Courier New', monospace;
    }

    .reservation-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--border-lighter);
    }

    .price-section {
        text-align: right;
    }

    .price-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-secondary);
    }

    .price-value {
        font-family: 'Syne', sans-serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--accent-blue);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
    }

    .btn-cancel svg { width: 14px; height: 14px; }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: var(--bg-primary);
        border: 1px solid var(--border-light);
        border-radius: 16px;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    .btn-reserve {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--accent-blue), var(--accent-blue-dark));
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
    }

    .btn-reserve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    @media (max-width: 768px) {
        .reservations-grid {
            grid-template-columns: 1fr;
        }

        .search-form {
            flex-direction: column;
        }

        .search-input-group {
            min-width: 100%;
        }

        .reservation-details {
            grid-template-columns: 1fr;
        }

        .reservation-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .price-section {
            text-align: left;
        }
    }
</style>

<div class="dash">

    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">Gebruiker</div>
            <h1 class="dash-title">Mijn Reserveringen</h1>
            <p class="dash-sub">Beheer en bekijk al uw parkeerreserveringen</p>
        </div>
    </div>

    @if($reservations->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🅿</div>
            <div class="empty-title">Nog geen reserveringen</div>
            <p class="empty-text">U hebt nog geen parkeerplaatsen gereserveerd. Begin nu met uw eerste reservering!</p>
            <a href="{{ route('user.reserve') }}" class="btn-reserve">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Reserveer nu
            </a>
        </div>
    @else
        <div class="search-section" style="margin-bottom: 2rem;">
            <div class="search-title">
                <div class="search-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                Zoeken
            </div>
            <form method="GET" class="search-form">
                <div class="search-input-group">
                    <label class="search-label">Parkeerplaats</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Zoek op locatie..."
                           class="search-input">
                </div>
                <button type="submit" class="search-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Zoeken
                </button>
                @if(request('search'))
                    <a href="{{ route('user.reservations') }}" class="clear-button">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Wissen
                    </a>
                @endif
            </form>
        </div>

        <div class="reservations-grid">
            @foreach($reservations as $res)
                <div class="reservation-card">
                    <div class="reservation-header">
                        <div>
                            <div class="reservation-title">{{ $res->spot_details["name"] ?? "Onbekend" }}</div>
                            <div class="reservation-location">Rotterdam</div>
                        </div>
                        <span class="status-badge status-{{ $res->status }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </div>

                    <div class="reservation-details">
                        <div class="detail-item">
                            <div class="detail-label">Datum</div>
                            <div class="detail-value">{{ $res->datum->format('d-m-Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Tijdslot</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($res->start_tijd)->format('H:i') }} – {{ \Carbon\Carbon::parse($res->eind_tijd)->format('H:i') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Voertuig</div>
                            <div class="detail-value">{{ $res->voertuig }}</div>
                            @if($res->kenteken)
                                <div class="detail-sub">{{ $res->kenteken }}</div>
                            @endif
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Betaalstatus</div>
                            <div class="detail-value">
                                @if($res->betaald)
                                    <span style="color: #15803d;">✓ Betaald</span>
                                @else
                                    <span style="color: #b91c1c;">Niet betaald</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="reservation-footer">
                        <div class="price-section">
                            <div class="price-label">Totaal</div>
                            <div class="price-value">€{{ number_format($res->totaal_prijs, 2) }}</div>
                        </div>

                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            @if($res->betaald)
                                <a href="{{ route('user.reservations.factuur', $res) }}" class="btn-cancel" style="background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; text-decoration: none;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Factuur
                                </a>
                            @endif

                            @if($res->status === 'actief')
                                <form method="POST" action="{{ route('user.reservations.destroy', $res) }}"
                                      onsubmit="return confirm('Weet u zeker dat u deze reservering wilt annuleren?')" style="display: contents;">
                                    @csrf @method('DELETE')
                                    <button class="btn-cancel">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Annuleren
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $reservations->links() }}
        </div>
    @endif

</div>
@endsection
