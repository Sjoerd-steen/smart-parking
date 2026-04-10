<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'external_parking_id', 'datum', 'start_tijd',
        'eind_tijd', 'voertuig', 'kenteken', 'totaal_prijs',
        'betaald', 'betaal_methode', 'status'
    ];

    protected $casts = [
        'datum' => 'date',
        'betaald' => 'boolean',
    ];

    // Relaties
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Bereken totaalprijs op basis van uren
    public function berekenPrijs(float $pricePerHour = 2.00): float {
        $start = \Carbon\Carbon::parse($this->start_tijd);
        $eind  = \Carbon\Carbon::parse($this->eind_tijd);
        $uren  = $start->diffInHours($eind);
        return $uren * $pricePerHour;
    }
}
