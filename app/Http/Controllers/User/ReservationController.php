<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ParkingApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller {

    protected $parkingService;

    public function __construct(ParkingApiService $parkingService) {
        $this->parkingService = $parkingService;
    }

    // Overzicht van beschikbare parkeerplaatsen om te reserveren (Map view)
    public function create(Request $request) {
        $spots = $this->parkingService->getRotterdamParkingSpots();
        
        // Find existing non-cancelled reservations to mark spots as reserved
        $reservations = Reservation::whereIn('status', ['actief'])->get()->keyBy('external_parking_id');
        
        // Map spots with reservation status
        $spotsWithStatus = $spots->map(function($spot) use ($reservations) {
            $spot['reserved'] = $reservations->has($spot['id']);
            return $spot;
        });

        $selectedSpotId = $request->query('spot_id');
        $vehicles = Auth::user()->vehicles;
        return view('user.reserve', compact('spotsWithStatus', 'selectedSpotId', 'vehicles'));
    }

    // Betaalpagina tonen
    public function betaalForm(Request $request) {
        $request->validate([
            'external_parking_id' => 'required',
            'datum'           => 'required|date|after_or_equal:today',
            'start_tijd'      => 'required',
            'eind_tijd'       => 'required|after:start_tijd',
            'voertuig'        => 'required|string|max:50',
            'kenteken'        => 'nullable|string|max:10',
        ]);

        $spot = $this->parkingService->getSpotById($request->external_parking_id);
        if (!$spot) {
            return back()->with('error', 'Parkeerplaats niet gevonden.');
        }

        // Bereken prijs
        $start = \Carbon\Carbon::parse($request->start_tijd);
        $eind  = \Carbon\Carbon::parse($request->eind_tijd);
        $uren  = max(1, $start->diffInHours($eind));
        $prijs = $uren * ($spot['price_per_hour'] ?? 2.00);

        return view('user.betaal', compact('spot', 'prijs', 'uren'))->with([
            'formData' => $request->all()
        ]);
    }

    // Reservering opslaan na betaling
    public function store(Request $request) {
        $request->validate([
            'external_parking_id' => 'required',
            'datum'           => 'required|date',
            'start_tijd'      => 'required',
            'eind_tijd'       => 'required',
            'voertuig'        => 'required',
            'betaal_methode'  => 'required|in:ideal,paypal,tikkie,maestro',
            'kenteken'        => 'nullable|string|max:10',
            'agree'           => 'required|accepted',
        ]);

        $spot = $this->parkingService->getSpotById($request->external_parking_id);
        if (!$spot) {
            return back()->with('error', 'Parkeerplaats niet gevonden.');
        }

        // Prevent double booking
        $existing = Reservation::where('external_parking_id', $request->external_parking_id)
            ->where('status', 'actief')
            ->exists();
        if ($existing) {
             return redirect()->route('user.reservations.create')->with('error', 'Deze parkeerplaats is al gereserveerd.');
        }

        $start = \Carbon\Carbon::parse($request->start_tijd);
        $eind  = \Carbon\Carbon::parse($request->eind_tijd);
        $uren  = max(1, $start->diffInHours($eind));
        $prijs = $uren * ($spot['price_per_hour'] ?? 2.00);

        Reservation::create([
            'user_id'             => Auth::id(),
            'external_parking_id' => $request->external_parking_id,
            'datum'               => $request->datum,
            'start_tijd'          => $request->start_tijd,
            'eind_tijd'           => $request->eind_tijd,
            'voertuig'            => $request->voertuig,
            'kenteken'            => $request->kenteken,
            'totaal_prijs'        => $prijs,
            'betaald'             => true,
            'betaal_methode'      => $request->betaal_methode,
            'status'              => 'actief',
        ]);

        return redirect()->route('user.reservations')
            ->with('success', "Reservering bevestigd! Parkeerplaats {$spot['name']} gereserveerd voor €{$prijs}.");
    }

    // Overzicht eigen reserveringen
    public function index() {
        $reservations = Reservation::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        // Append API data
        $reservations->getCollection()->transform(function ($reservation) {
            $reservation->spot_details = $this->parkingService->getSpotById($reservation->external_parking_id);
            return $reservation;
        });

        return view('user.reservations', compact('reservations'));
    }

    // Reservering annuleren
    public function destroy(Reservation $reservation) {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Geen toegang.');
        }

        $reservation->update(['status' => 'geannuleerd']);

        return redirect()->route('user.reservations')
            ->with('success', 'Reservering geannuleerd.');
    }
}
