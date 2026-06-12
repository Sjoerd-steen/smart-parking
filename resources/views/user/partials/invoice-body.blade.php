@php
    use App\Support\InvoiceHelper;
    $invoiceNo = InvoiceHelper::invoiceNumber($reservation->id);
@endphp

<div class="invoice-header">
    <div>
        <div class="invoice-brand">
            SmartParking
            <span>Parkeerreserveringen Rotterdam</span>
        </div>
    </div>
    <div class="invoice-meta">
        <strong>Factuur #{{ $invoiceNo }}</strong>
        <div>Datum: {{ $reservation->created_at->format('d-m-Y H:i') }}</div>
        <div class="paid-badge">Betaald</div>
    </div>
</div>

<div class="invoice-body">
    <div class="invoice-grid">
        <div>
            <div class="invoice-section-title">Klantgegevens</div>
            <div class="invoice-box">
                <p><span class="label">Naam</span><br>{{ $reservation->user->name }}</p>
                <p><span class="label">E-mail</span><br>{{ $reservation->user->email }}</p>
            </div>
        </div>
        <div>
            <div class="invoice-section-title">Betaalgegevens</div>
            <div class="invoice-box">
                <p><span class="label">Betaalmethode</span><br>{{ InvoiceHelper::betaalLabel($reservation->betaal_methode) }}</p>
                <p><span class="label">Reservering</span><br>#{{ $invoiceNo }}</p>
                <p><span class="label">Parkeer-ID</span><br>{{ $reservation->external_parking_id }}</p>
            </div>
        </div>
    </div>

    <div class="invoice-section-title">Huidige reservering</div>

    <div class="table-wrap">
        <table class="invoice-table">
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
                    <td data-label="Parkeerplaats">
                        {{ $spot['name'] ?? 'Onbekend' }}
                        <br><small class="sub">{{ $spot['city'] ?? 'Rotterdam' }}</small>
                    </td>
                    <td data-label="Datum">{{ $reservation->datum->format('d-m-Y') }}</td>
                    <td data-label="Tijd">{{ InvoiceHelper::formatTime($reservation->start_tijd) }} – {{ InvoiceHelper::formatTime($reservation->eind_tijd) }}</td>
                    <td data-label="Voertuig">{{ $reservation->voertuig }}</td>
                    <td data-label="Kenteken">{{ $reservation->kenteken ?: '–' }}</td>
                    <td data-label="Status">{{ InvoiceHelper::statusLabel($reservation->status) }}</td>
                    <td data-label="Bedrag" class="text-right">€{{ number_format($reservation->totaal_prijs, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="invoice-total">
        <div class="invoice-total-box">
            <div class="label">Totaal betaald</div>
            <div class="amount">€{{ number_format($reservation->totaal_prijs, 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="invoice-section-title">Voltooide reserveringen</div>

    <div class="table-wrap">
        <table class="invoice-table invoice-table-history">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Parkeerplaats</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Voertuig</th>
                    <th>Kenteken</th>
                    <th>Betaalmethode</th>
                    <th>Status</th>
                    <th class="text-right">Bedrag</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allReservations as $res)
                    <tr @class(['highlight' => $res->id === $reservation->id])>
                        <td data-label="#">#{{ InvoiceHelper::invoiceNumber($res->id) }}</td>
                        <td data-label="Parkeerplaats">{{ $res->spot_details['name'] ?? 'Onbekend' }}</td>
                        <td data-label="Datum">{{ $res->datum->format('d-m-Y') }}</td>
                        <td data-label="Tijd">{{ InvoiceHelper::formatTime($res->start_tijd) }} – {{ InvoiceHelper::formatTime($res->eind_tijd) }}</td>
                        <td data-label="Voertuig">{{ $res->voertuig }}</td>
                        <td data-label="Kenteken">{{ $res->kenteken ?: '–' }}</td>
                        <td data-label="Betaalmethode">{{ InvoiceHelper::betaalLabel($res->betaal_methode) }}</td>
                        <td data-label="Status">{{ InvoiceHelper::statusLabel($res->status) }}</td>
                        <td data-label="Bedrag" class="text-right">€{{ number_format($res->totaal_prijs, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-row">Geen voltooide reserveringen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="invoice-footer">
    Bedankt voor uw reservering bij SmartParking. Voor vragen kunt u contact opnemen via info@smartparking.nl
</div>
