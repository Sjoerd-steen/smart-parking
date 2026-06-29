@extends('layouts.app')
@section('title', 'Reservations')
@section('page-title', 'Reservations')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

    .dash {
        font-family: 'DM Sans', sans-serif;
        color: #0f172a;
    }

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

    .search-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .search-title {
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        padding-bottom: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-title-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-title-icon svg { width: 14px; height: 14px; color: #2563eb; }

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
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .search-input, .search-select {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #0f172a;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
    }

    .search-input:focus, .search-select:focus {
        outline: none;
        border-color: #2563eb;
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
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
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
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
    }

    .clear-button:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .clear-button svg { width: 14px; height: 14px; }

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

    .panel-title-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel-title-icon svg { width: 14px; height: 14px; color: #2563eb; }

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

    .td-muted { color: #94a3b8; font-weight: 400; }
    .td-bold { font-weight: 600; color: #0f172a; }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 100px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border: 1px solid transparent;
    }

    .badge-paid { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
    .badge-unpaid { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

    .status-select {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all 0.15s;
    }

    .status-select:hover {
        border-color: #2563eb;
    }

    .status-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-delete {
        padding: 0.5rem 0.875rem;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
    }

    .pagination-wrapper {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .search-form {
            flex-direction: column;
        }

        .search-input-group {
            min-width: 100%;
        }

        .data-table {
            font-size: 0.75rem;
        }
    }

    html.dark .dash { color: var(--text-main); }
    html.dark .dash-title { color: var(--text-main); }
    html.dark .dash-sub { color: var(--text-muted); }
    html.dark .search-section { background: var(--card-bg); border-color: var(--card-border); }
    html.dark .search-title { color: var(--text-main); border-bottom-color: var(--border); }
    html.dark .search-input,
    html.dark .search-select { background: var(--form-bg); color: var(--form-text); border-color: var(--form-border); }
    html.dark .clear-button { background: var(--surface); color: var(--text-muted); border-color: var(--border); }
    html.dark .clear-button:hover { background: var(--surface-2); }
    html.dark .table-panel { background: var(--card-bg); border-color: var(--card-border); }
    html.dark .table-title { color: var(--text-main); }
    html.dark .table-header { border-bottom-color: var(--border); }
    html.dark .data-table td { color: var(--ink-3); }
    html.dark .data-table td:first-child,
    html.dark .td-bold { color: var(--text-main); }
    html.dark .data-table th { color: var(--text-muted); border-bottom-color: var(--border-2); }
    html.dark .data-table tbody tr { border-bottom-color: var(--border-2); }
    html.dark .data-table tbody tr:hover { background: var(--surface-2); }
</style>

<div class="dash">

    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">Beheerder</div>
            <h1 class="dash-title">Reserveringen Beheren</h1>
            <p class="dash-sub">Controleer en beheer alle parkeerreserveringen</p>
        </div>
    </div>

    <div class="search-section">
        <div class="search-title">
            <div class="search-title-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            Zoeken en filteren
        </div>
        <form method="GET" class="search-form">
            <div class="search-input-group">
                <label class="search-label">Gebruikersnaam</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Zoek op gebruikersnaam..."
                       class="search-input">
            </div>
            <div class="search-input-group">
                <label class="search-label">Status</label>
                <select name="status" class="search-select">
                    <option value="">Alle statussen</option>
                    <option value="actief" {{ request('status') === 'actief' ? 'selected' : '' }}>Actief</option>
                    <option value="geannuleerd" {{ request('status') === 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                    <option value="voltooid" {{ request('status') === 'voltooid' ? 'selected' : '' }}>Voltooid</option>
                </select>
            </div>
            <button type="submit" class="search-button">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Filteren
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.reservations.index') }}" class="clear-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="table-panel">
        <div class="table-header">
            <div class="table-header-left">
                <div class="panel-title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="table-title">Alle reserveringen</span>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Gebruiker</th>
                        <th>Parkeerplaats</th>
                        <th>Datum</th>
                        <th>Tijdslot</th>
                        <th>Prijs</th>
                        <th>Betaald</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                        <tr>
                            <td>
                                <p class="td-bold">{{ $res->user->name }}</p>
                                <p class="td-muted text-xs">{{ $res->user->email }}</p>
                            </td>
                            <td class="td-bold">{{ $res->spot_details["name"] ?? "Onbekend" }}</td>
                            <td>{{ $res->datum->format('d-m-Y') }}</td>
                            <td class="td-muted">{{ $res->start_tijd }} – {{ $res->eind_tijd }}</td>
                            <td class="td-bold">€{{ number_format($res->totaal_prijs, 2) }}</td>
                            <td>
                                <span class="badge {{ $res->betaald ? 'badge-paid' : 'badge-unpaid' }}">
                                    {{ $res->betaald ? '✓ Ja' : '✕ Nee' }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.reservations.update', $res) }}" style="display: contents;">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="status-select">
                                        <option value="actief" {{ $res->status === 'actief' ? 'selected' : '' }}>Actief</option>
                                        <option value="geannuleerd" {{ $res->status === 'geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                                        <option value="voltooid" {{ $res->status === 'voltooid' ? 'selected' : '' }}>Voltooid</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.reservations.destroy', $res) }}"
                                      onsubmit="return confirm('Reservering verwijderen?')" style="display: contents;">
                                    @csrf @method('DELETE')
                                    <button class="btn-delete">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">{{ $reservations->appends(request()->query())->links() }}</div>
    </div>

</div>
@endsection