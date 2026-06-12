<?php

namespace App\Support;

class InvoiceHelper
{
    public static function betaalLabel(?string $method): string
    {
        return match ($method) {
            'ideal'   => 'iDEAL',
            'paypal'  => 'PayPal',
            'tikkie'  => 'Tikkie',
            'maestro' => 'Maestro / Creditcard',
            default   => $method ?? '–',
        };
    }

    public static function statusLabel(string $status): string
    {
        return ucfirst($status);
    }

    public static function invoiceNumber(int $id): string
    {
        return str_pad((string) $id, 6, '0', STR_PAD_LEFT);
    }

    public static function formatTime(string $time): string
    {
        return \Carbon\Carbon::parse($time)->format('H:i');
    }
}
