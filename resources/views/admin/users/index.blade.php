@extends('layouts.app')
@section('title', 'Gebruikersbeheer')
@section('page-title', 'Gebruikersbeheer')

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

    /* ── SEARCH SECTION ── */
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

    .search-input {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #0f172a;
        font-family: 'DM Sans', sans-serif;
        transition: all 0.15s;
    }

    .search-input:focus {
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

    .search-button:active {
        transform: translateY(0);
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

    /* ── TABLE PANEL ── */
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

    .data-table td:first-child { font-weight: 500; color: #0f172a; }

    .td-muted { color: #94a3b8 !important; font-weight: 400 !important; }

    /* User avatar inline */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .user-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-size: 0.7rem;
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
        padding: 0.35rem 0.75rem;
        border-radius: 100px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .badge-admin    { background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; }
    .badge-user     { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-actief   { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-geblokkeerd { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.875rem;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
    }

    .btn-edit {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        border-color: #2563eb;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
    }

    .btn-ban {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border-color: #ef4444;
    }

    .btn-ban:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
    }

    .btn-unban {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        border-color: #10b981;
    }

    .btn-unban:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
    }

    /* Pagination */
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

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>

<div class="dash">

    {{-- PAGE HEADER --}}
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">Beheerder</div>
            <h1 class="dash-title">Gebruikersbeheer</h1>
            <p class="dash-sub">Beheer en monitor alle gebruikers van SmartParking</p>
        </div>
    </div>

    {{-- SEARCH SECTION --}}
    <div class="search-section">
        <div class="search-title">
            <div class="search-title-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            Zoeken en filteren
        </div>
        <form method="GET" class="search-form">
            <div class="search-input-group">
                <label class="search-label">Gebruiker</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Zoek op naam of e-mail..."
                       class="search-input">
            </div>
            <button type="submit" class="search-button">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Zoeken
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="clear-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Wissen
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE PANEL --}}
    <div class="table-panel">
        <div class="table-header">
            <div class="table-header-left">
                <div class="panel-title-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="table-title">Alle gebruikers ({{ $users->total() }})</span>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>E-mail</th>
                        <th>Rol</th>
                        <th>Reserveringen</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="td-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->reservations_count }}</td>
                            <td>
                                <span class="badge {{ $user->is_banned ? 'badge-geblokkeerd' : 'badge-actief' }}">
                                    {{ $user->is_banned ? '🚫 Geblokkeerd' : '✓ Actief' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit">
                                        Bewerken
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.ban', $user) }}" style="display: contents;">
                                        @csrf
                                        <button class="btn-action {{ $user->is_banned ? 'btn-unban' : 'btn-ban' }}" type="submit">
                                            {{ $user->is_banned ? 'Deblokkeer' : 'Blokkeer' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">{{ $users->appends(request()->query())->links() }}</div>
    </div>

</div>
@endsection
