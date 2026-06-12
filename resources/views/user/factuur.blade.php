@extends('layouts.app')
@section('title', 'Factuur')

@section('content')
<style>
    .factuur-page {
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
        overflow-x: visible;
    }

    .factuur-actions {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .factuur-actions a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s;
        white-space: nowrap;
    }

    .btn-download {
        background: linear-gradient(135deg, #1a56db, #06b6d4);
        color: #fff !important;
        border: none;
    }

    .btn-download:hover { opacity: 0.9; }

    .btn-back {
        background: #fff;
        color: #0f172a !important;
        border: 1px solid #e2e8f0;
    }

    html.dark .btn-back {
        background: #1e293b;
        color: #f1f5f9 !important;
        border-color: #334155;
    }

    .invoice-paper {
        background: #fff;
        color: #0f172a;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 32px rgba(10, 15, 30, 0.08);
        overflow: visible;
        width: 100%;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1.5rem;
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
        color: #fff;
        border-radius: 16px 16px 0 0;
    }

    .invoice-brand {
        font-family: 'Cabinet Grotesk', sans-serif;
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #fff;
    }

    .invoice-brand span {
        opacity: 0.85;
        font-weight: 500;
        font-size: 0.85rem;
        display: block;
        margin-top: 0.25rem;
    }

    .invoice-meta {
        text-align: right;
        font-size: 0.875rem;
        color: #fff;
        flex-shrink: 0;
    }

    .invoice-meta strong {
        display: block;
        font-size: 1.05rem;
        margin-bottom: 0.25rem;
        color: #fff;
    }

    .invoice-body { padding: 1.75rem 2rem; }

    .invoice-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 0.75rem;
    }

    .invoice-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .invoice-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.15rem;
        min-height: 100px;
    }

    .invoice-box p {
        margin: 0 0 0.75rem;
        font-size: 0.9rem;
        color: #0f172a;
        word-break: break-word;
    }

    .invoice-box p:last-child { margin-bottom: 0; }

    .invoice-box .label {
        color: #64748b;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 0.15rem;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .invoice-table {
        width: 100%;
        min-width: 640px;
        border-collapse: collapse;
        font-size: 0.875rem;
        background: #fff;
    }

    .invoice-table-history { min-width: 900px; }

    .invoice-table th {
        text-align: left;
        padding: 0.75rem 0.875rem;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .invoice-table td {
        padding: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
        color: #0f172a;
        word-break: break-word;
    }

    .invoice-table tr:last-child td { border-bottom: none; }

    .invoice-table tr.highlight td {
        background: #eff6ff;
        font-weight: 600;
    }

    .invoice-table .sub { color: #64748b; font-size: 0.78rem; }
    .invoice-table .text-right { text-align: right; white-space: nowrap; }
    .invoice-table .empty-row { text-align: center; color: #64748b; padding: 1.5rem; }

    .invoice-total {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.75rem;
    }

    .invoice-total-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        min-width: 200px;
    }

    .invoice-total-box .label {
        color: #64748b;
        font-size: 0.72rem;
        text-transform: uppercase;
    }

    .invoice-total-box .amount {
        font-size: 1.6rem;
        font-weight: 800;
        color: #15803d;
    }

    .invoice-footer {
        padding: 1.25rem 2rem 1.75rem;
        border-top: 1px solid #e2e8f0;
        font-size: 0.8rem;
        color: #64748b;
        text-align: center;
        background: #fff;
        border-radius: 0 0 16px 16px;
    }

    .paid-badge {
        display: inline-flex;
        align-items: center;
        background: #dcfce7;
        color: #15803d;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        .invoice-header {
            flex-direction: column;
            padding: 1.25rem;
        }

        .invoice-meta { text-align: left; }

        .invoice-body,
        .invoice-footer { padding: 1.25rem; }

        .invoice-grid { grid-template-columns: 1fr; }

        .table-wrap {
            border: none;
            overflow-x: visible;
        }

        .invoice-table,
        .invoice-table-history {
            min-width: 0;
        }

        .invoice-table thead { display: none; }

        .invoice-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .invoice-table tbody tr.highlight {
            border-color: #93c5fd;
            box-shadow: 0 0 0 1px #bfdbfe;
        }

        .invoice-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.65rem 0.875rem;
            border-bottom: 1px solid #f1f5f9;
            text-align: right;
        }

        .invoice-table tbody td:last-child { border-bottom: none; }

        .invoice-table tbody td::before {
            content: attr(data-label);
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            text-align: left;
            flex-shrink: 0;
        }

        .invoice-table tbody td.text-right {
            justify-content: space-between;
        }
    }
</style>

<div class="factuur-page">
    <div class="factuur-actions">
        <a href="{{ route('user.reservations.factuur.pdf', $reservation) }}" class="btn-download">
            PDF downloaden
        </a>
        <a href="{{ route('user.reservations') }}" class="btn-back">Terug naar reserveringen</a>
    </div>

    <div class="invoice-paper">
        @include('user.partials.invoice-body')
    </div>
</div>
@endsection
