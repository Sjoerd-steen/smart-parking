@extends('layouts.app')
@section('title', 'Reservations')
@section('page-title', 'Reservations')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>
    :root {
        --sp-blue: #2563eb;
        --sp-blue-dim: #dbeafe;
        --sp-ink: #0f172a;
        --sp-ink-mid: #334155;
        --sp-ink-soft: #64748b;
        --sp-surface: #f8fafc;
        --sp-white: #ffffff;
        --sp-border: #e2e8f0;
    }

    .sp-page { font-family: 'DM Sans', sans-serif; }

    /* ── Header ── */
    .sp-page-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
    .sp-page-title { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.03em; color: var(--sp-ink); margin: 0; }
    .sp-page-title span { color: var(--sp-blue); }
    .sp-live-badge { display: inline-flex; align-items: center; gap: 6px; padding: 0.3rem 0.8rem; background: var(--sp-blue-dim); color: var(--sp-blue); border-radius: 100px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; }
    .sp-live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--sp-blue); animation: sp-pulse 1.8s ease infinite; }
    @keyframes sp-pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

    /* ── Filter card ── */
    .sp-filter-card { background: var(--sp-white); border: 1px solid var(--sp-border); border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1.25rem; display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; }
    .sp-input { flex: 1; min-width: 180px; height: 38px; padding: 0 0.875rem; border: 1px solid var(--sp-border); border-radius: 8px; font-family: inherit; font-size: 0.85rem; color: var(--sp-ink); background: var(--sp-surface); outline: none; transition: border-color .2s; }
    .sp-input:focus { border-color: var(--sp-blue); }
    .sp-select { height: 38px; padding: 0 0.875rem; border: 1px solid var(--sp-border); border-radius: 8px; font-family: inherit; font-size: 0.85rem; color: var(--sp-ink); background: var(--sp-surface); outline: none; cursor: pointer; }
    .sp-btn { display: inline-flex; align-items: center; gap: 6px; height: 38px; padding: 0 1.1rem; border-radius: 8px; font-family: inherit; font-size: 0.82rem; font-weight: 600; cursor: pointer; border: none; transition: all .2s; white-space: nowrap; text-decoration: none; }
    .sp-btn-primary { background: var(--sp-blue); color: #fff; }
    .sp-btn-primary:hover { background: #1d4ed8; }
    .sp-btn-secondary { background: transparent; color: var(--sp-ink-soft); border: 1px solid var(--sp-border) !important; }
    .sp-btn-secondary:hover { border-color: var(--sp-blue) !important; color: var(--sp-blue); }

    /* ── Table card ── */
    .sp-table-card { background: var(--sp-white); border: 1px solid var(--sp-border); border-radius: 16px; overflow: hidden; }
    .sp-table-scroll { overflow-x: auto; }
    .sp-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
    .sp-table thead tr { border-bottom: 1.5px solid var(--sp-border); }
    .sp-table th { padding: 0.9rem 1rem; text-align: left; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--sp-ink-soft); white-space: nowrap; }
    .sp-table tbody tr { border-bottom: 1px solid var(--sp-border); transition: background .15s; }
    .sp-table tbody tr:last-child { border-bottom: none; }
    .sp-table tbody tr:hover { background: var(--sp-surface); }
    .sp-table td { padding: 0.85rem 1rem; vertical-align: middle; }

    /* ── User cell ── */
    .sp-user-cell { display: flex; align-items: center; gap: 10px; }
    .sp-avatar { width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-size: 0.75rem; font-weight: 800; color: var(--sp-blue); background: var(--sp-blue-dim); flex-shrink: 0; }
    .sp-user-name { font-weight: 500; color: var(--sp-ink); margin-bottom: 2px; }
    .sp-user-email { font-size: 0.73rem; color: var(--sp-ink-soft); }
    .sp-price { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--sp-ink); }

    /* ── Badges ── */
    .sp-badge { display: inline-flex; align-items: center; padding: 0.25rem 0.65rem; border-radius: 100px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.04em; }
    .sp-badge-paid      { background: #dcfce7; color: #15803d; }
    .sp-badge-unpaid    { background: #fee2e2; color: #dc2626; }

    /* ── Delete button ── */
    .sp-btn-delete { display: inline-flex; align-items: center; gap: 4px; height: 30px; padding: 0 0.75rem; background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; border-radius: 8px; font-family: inherit; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all .2s; white-space: nowrap; }
    .sp-btn-delete:hover { background: #fecaca; border-color: #f87171; }

    /* ── Custom dropdown ── */
    .sp-dd-wrap { position: relative; display: inline-block; }
    .sp-dd-trigger {
        display: inline-flex; align-items: center; gap: 8px;
        height: 30px; padding: 0 10px 0 8px;
        border: 1px solid var(--sp-border); border-radius: 8px;
        font-family: inherit; font-size: 0.75rem; font-weight: 600;
        cursor: pointer; background: var(--sp-surface); color: var(--sp-ink);
        transition: border-color .15s; user-select: none; white-space: nowrap;
    }
    .sp-dd-trigger:hover { border-color: #94a3b8; }
    .sp-dd-trigger.open  { border-color: var(--sp-blue); }
    .sp-dd-dot     { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .sp-dd-chevron { font-size: 12px; color: var(--sp-ink-soft); transition: transform .2s; margin-left: 2px; }
    .sp-dd-trigger.open .sp-dd-chevron { transform: rotate(180deg); }

    .sp-dd-menu {
        position: absolute; top: calc(100% + 6px); left: 0; z-index: 50;
        background: var(--sp-white); border: 1px solid var(--sp-border); border-radius: 10px;
        min-width: 160px; overflow: hidden;
        animation: ddIn .12s ease both;
    }
    @keyframes ddIn { from{opacity:0;transform:translateY(-4px)} to{opacity:1;transform:translateY(0)} }
    .sp-dd-item {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 12px; font-size: 0.78rem; font-weight: 500;
        cursor: pointer; color: var(--sp-ink); border-bottom: 1px solid var(--sp-border);
        transition: background .1s; font-family: inherit;
    }
    .sp-dd-item:last-child { border-bottom: none; }
    .sp-dd-item:hover    { background: var(--sp-surface); }
    .sp-dd-item.selected { background: var(--sp-blue-dim); color: var(--sp-blue); }
    .sp-dd-check { font-size: 13px; margin-left: auto; color: var(--sp-blue); opacity: 0; }
    .sp-dd-item.selected .sp-dd-check { opacity: 1; }
    .dot-actief      { background: #3b82f6; }
    .dot-geannuleerd { background: #94a3b8; }
    .dot-voltooid    { background: #10b981; }

    /* ── Pagination ── */
    .sp-pagination { padding: 1rem 1.25rem; border-top: 1px solid var(--sp-border); }
    .sp-pagination nav { display: flex; align-items: center; justify-content: between; gap: 4px; }
    .sp-pagination .pagination { display: flex; gap: 4px; list-style: none; padding: 0; margin: 0; }
    .sp-pagination .page-link { display: flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; border: 1px solid var(--sp-border); border-radius: 8px; font-size: 0.8rem; color: var(--sp-ink-mid); text-decoration: none; transition: all .2s; padding: 0 8px; background: var(--sp-white); }
    .sp-pagination .page-link:hover { background: var(--sp-blue); color: #fff; border-color: var(--sp-blue); }
    .sp-pagination .page-item.active .page-link { background: var(--sp-blue); color: #fff; border-color: var(--sp-blue); }
    .sp-pagination .page-item.disabled .page-link { opacity: 0.4; pointer-events: none; }

    /* ── Dark mode ── */
    .dark .sp-page-title { color: #f1f5f9; }
    .dark .sp-user-name  { color: #e2e8f0; }
    .dark .sp-price      { color: #e2e8f0; }
    .dark .sp-filter-card, .dark .sp-table-card { background: #0f1a35; border-color: #1e293b; }
    .dark .sp-input, .dark .sp-select { background: #0d1526; border-color: #1e293b; color: #e2e8f0; }
    .dark .sp-table thead tr { border-color: #1e293b; }
    .dark .sp-table tbody tr { border-color: #1e293b; }
    .dark .sp-table tbody tr:hover { background: #0d1526; }
    .dark .sp-pagination { border-color: #1e293b; }
    .dark .sp-pagination .page-link { background: #0f1a35; border-color: #1e293b; color: #94a3b8; }
    .dark .sp-badge-paid   { background: #052e16; color: #4ade80; }
    .dark .sp-badge-unpaid { background: #450a0a; color: #f87171; }
    .dark .sp-btn-delete { background: #450a0a; color: #f87171; border-color: #991b1b; }
    .dark .sp-btn-delete:hover { background: #7f1d1d; }
    .dark .sp-dd-trigger { background: #0d1526; border-color: #1e293b; color: #e2e8f0; }
    .dark .sp-dd-menu { background: #0f1a35; border-color: #1e293b; }
    .dark .sp-dd-item { color: #e2e8f0; border-color: #1e293b; }
    .dark .sp-dd-item:hover { background: #0d1526; }
    .dark .sp-dd-item.selected { background: rgba(37,99,235,0.15); color: #93c5fd; }
    .dark .sp-dd-check { color: #93c5fd; }
    .dark .sp-live-badge { background: rgba(37,99,235,0.15); color: #93c5fd; }
    .dark .sp-live-dot { background: #93c5fd; }
</style>

<div class="sp-page">

    {{-- Header --}}
    <div class="sp-page-head">
        <h1 class="sp-page-title">Smart<span>Parking</span> — Reservations</h1>
        <div class="sp-live-badge">
            <span class="sp-live-dot"></span>
            {{ $reservations->total() }} total
        </div>
    </div>

    {{-- Filters --}}
    <div class="sp-filter-card">
        <form method="GET" style="display:contents">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or email…" class="sp-input">
            <select name="status" class="sp-select">
                <option value="">All statuses</option>
                <option value="actief"      {{ request('status') === 'actief'      ? 'selected' : '' }}>Active</option>
                <option value="geannuleerd" {{ request('status') === 'geannuleerd' ? 'selected' : '' }}>Cancelled</option>
                <option value="voltooid"    {{ request('status') === 'voltooid'    ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="sp-btn sp-btn-primary">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Filter
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.reservations.index') }}" class="sp-btn sp-btn-secondary">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="sp-table-card">
        <div class="sp-table-scroll">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Spot</th>
                        <th>Date</th>
                        <th>Time slot</th>
                        <th>Price</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td>
                            <div class="sp-user-cell">
                                <div class="sp-avatar">{{ strtoupper(substr($res->user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="sp-user-name">{{ $res->user->name }}</div>
                                    <div class="sp-user-email">{{ $res->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $res->spot_details['name'] ?? 'Unknown' }}</td>
                        <td>{{ $res->datum->format('d-m-Y') }}</td>
                        <td style="color:var(--sp-ink-soft)">{{ $res->start_tijd }} – {{ $res->eind_tijd }}</td>
                        <td><span class="sp-price">€{{ number_format($res->totaal_prijs, 2) }}</span></td>
                        <td>
                            <span class="sp-badge {{ $res->betaald ? 'sp-badge-paid' : 'sp-badge-unpaid' }}">
                                {{ $res->betaald ? '✓ Paid' : 'Unpaid' }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.reservations.update', $res) }}" class="sp-status-form">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="{{ $res->status }}" class="sp-status-val">
                                <div class="sp-dd-wrap" data-current="{{ $res->status }}">
                                    <div class="sp-dd-trigger">
                                        <span class="sp-dd-dot"></span>
                                        <span class="sp-dd-text"></span>
                                        <svg class="sp-dd-chevron" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                    <div class="sp-dd-menu" style="display:none"></div>
                                </div>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.reservations.destroy', $res) }}"
                                  onsubmit="return confirm('Delete this reservation?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="sp-btn-delete">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:3rem; color:var(--sp-ink-soft); font-size:0.9rem;">
                            No reservations found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="sp-pagination">
            {{ $reservations->appends(request()->query())->links() }}
        </div>
    </div>

</div>

<script>
const SP_STATUSES = [
    { val: 'actief',      label: 'Active',    dot: 'dot-actief' },
    { val: 'geannuleerd', label: 'Cancelled', dot: 'dot-geannuleerd' },
    { val: 'voltooid',    label: 'Completed', dot: 'dot-voltooid' },
];

document.querySelectorAll('.sp-dd-wrap').forEach(wrap => {
    let current = wrap.dataset.current;
    const trigger     = wrap.querySelector('.sp-dd-trigger');
    const menu        = wrap.querySelector('.sp-dd-menu');
    const hiddenInput = wrap.closest('form').querySelector('.sp-status-val');

    function render() {
        const s = SP_STATUSES.find(x => x.val === current) || SP_STATUSES[0];
        wrap.querySelector('.sp-dd-dot').className  = 'sp-dd-dot ' + s.dot;
        wrap.querySelector('.sp-dd-text').textContent = s.label;

        menu.innerHTML = '';
        SP_STATUSES.forEach(opt => {
            const item = document.createElement('div');
            item.className = 'sp-dd-item' + (opt.val === current ? ' selected' : '');
            item.innerHTML =
                `<span class="sp-dd-dot ${opt.dot}"></span>` +
                `<span>${opt.label}</span>` +
                `<svg class="sp-dd-check" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`;
            item.addEventListener('click', () => {
                current = opt.val;
                hiddenInput.value = opt.val;
                closeAll();
                render();
                wrap.closest('form').submit();
            });
            menu.appendChild(item);
        });
    }

    trigger.addEventListener('click', e => {
        e.stopPropagation();
        const isOpen = menu.style.display === 'block';
        closeAll();
        if (!isOpen) {
            menu.style.display = 'block';
            trigger.classList.add('open');
        }
    });

    render();
});

function closeAll() {
    document.querySelectorAll('.sp-dd-menu').forEach(m => m.style.display = 'none');
    document.querySelectorAll('.sp-dd-trigger').forEach(t => t.classList.remove('open'));
}

document.addEventListener('click', closeAll);
</script>
@endsection