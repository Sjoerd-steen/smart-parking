@php
    use App\Support\InvoiceHelper;
    $invoiceNo = InvoiceHelper::invoiceNumber($reservation->id);
@endphp
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur #{{ $invoiceNo }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #0f172a;
            line-height: 1.45;
            padding: 24px;
        }
        .header {
            background: #1a56db;
            color: #fff;
            padding: 20px 24px;
            margin-bottom: 24px;
        }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; color: #fff; }
        .brand { font-size: 20px; font-weight: bold; }
        .brand-sub { font-size: 10px; opacity: 0.85; margin-top: 4px; }
        .meta { text-align: right; font-size: 11px; }
        .meta strong { display: block; font-size: 14px; margin-bottom: 4px; }
        .badge {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            margin-top: 6px;
        }
        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin: 18px 0 8px;
        }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .info-table td { width: 50%; vertical-align: top; padding-right: 12px; }
        .box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            margin-bottom: 8px;
        }
        .label { color: #64748b; font-size: 8px; text-transform: uppercase; }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 9px;
        }
        .data-table th {
            background: #f1f5f9;
            color: #475569;
            text-align: left;
            padding: 8px 6px;
            border-bottom: 2px solid #e2e8f0;
            font-size: 8px;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 8px 6px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .data-table tr.highlight td { background: #eff6ff; font-weight: bold; }
        .text-right { text-align: right; }
        .sub { color: #64748b; font-size: 8px; }
        .total-wrap { text-align: right; margin: 12px 0 20px; }
        .total-box {
            display: inline-block;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 10px 16px;
            text-align: left;
        }
        .total-label { color: #64748b; font-size: 8px; text-transform: uppercase; }
        .total-amount { font-size: 18px; font-weight: bold; color: #15803d; }
        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 9px;
        }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="brand">SmartParking</div>
                    <div class="brand-sub">Parkeerreserveringen Rotterdam</div>
                </td>
                <td class="meta">
                    <strong>Factuur #{{ $invoiceNo }}</strong>
                    Datum: {{ $reservation->created_at->format('d-m-Y H:i') }}<br>
                    <span class="badge">Betaald</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <div class="section-title">Klantgegevens</div>
                <div class="box">
                    <div class="label">Naam</div>
                    {{ $reservation->user->name }}<br><br>
                    <div class="label">E-mail</div>
                    {{ $reservation->user->email }}
                </div>
            </td>
            <td>
                <div class="section-title">Betaalgegevens</div>
                <div class="box">
                    <div class="label">Betaalmethode</div>
                    {{ InvoiceHelper::betaalLabel($reservation->betaal_methode) }}<br><br>
                    <div class="label">Reservering</div>
                    #{{ $invoiceNo }}<br><br>
                    <div class="label">Parkeer-ID</div>
                    {{ $reservation->external_parking_id }}
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Huidige reservering</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Parkeerplaats</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Voertuig</th>
                <th>Kenteken</th>
                <th>Status</th>
                <th class="text-right">Bedrag</th>
            </tr>
        </thead>
        <tbody>
            <tr class="highlight">
                <td>
                    {{ $spot['name'] ?? 'Onbekend' }}<br>
                    <span class="sub">{{ $spot['city'] ?? 'Rotterdam' }}</span>
                </td>
                <td>{{ $reservation->datum->format('d-m-Y') }}</td>
                <td>{{ InvoiceHelper::formatTime($reservation->start_tijd) }} – {{ InvoiceHelper::formatTime($reservation->eind_tijd) }}</td>
                <td>{{ $reservation->voertuig }}</td>
                <td>{{ $reservation->kenteken ?: '–' }}</td>
                <td>{{ InvoiceHelper::statusLabel($reservation->status) }}</td>
                <td class="text-right">€{{ number_format($reservation->totaal_prijs, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-wrap">
        <div class="total-box">
            <div class="total-label">Totaal betaald</div>
            <div class="total-amount">€{{ number_format($reservation->totaal_prijs, 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="section-title">Voltooide reserveringen</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Parkeerplaats</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Voertuig</th>
                <th>Kenteken</th>
                <th>Betaal</th>
                <th>Status</th>
                <th class="text-right">Bedrag</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allReservations as $res)
                <tr @class(['highlight' => $res->id === $reservation->id])>
                    <td>#{{ InvoiceHelper::invoiceNumber($res->id) }}</td>
                    <td>{{ $res->spot_details['name'] ?? 'Onbekend' }}</td>
                    <td>{{ $res->datum->format('d-m-Y') }}</td>
                    <td>{{ InvoiceHelper::formatTime($res->start_tijd) }} – {{ InvoiceHelper::formatTime($res->eind_tijd) }}</td>
                    <td>{{ $res->voertuig }}</td>
                    <td>{{ $res->kenteken ?: '–' }}</td>
                    <td>{{ InvoiceHelper::betaalLabel($res->betaal_methode) }}</td>
                    <td>{{ InvoiceHelper::statusLabel($res->status) }}</td>
                    <td class="text-right">€{{ number_format($res->totaal_prijs, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Bedankt voor uw reservering bij SmartParking. Voor vragen kunt u contact opnemen via info@smartparking.nl
    </div>
</body>
</html>
