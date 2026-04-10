<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ParkingApiService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    protected $parkingService;

    public function __construct(ParkingApiService $parkingService) {
        $this->parkingService = $parkingService;
    }

    public function index() {
        $apiSpots = $this->parkingService->getRotterdamParkingSpots();
        $totalSpots  = $apiSpots->count();
        
        // Active reservations to check which spots are reserved
        $activeReservations = Reservation::where('status', 'actief')->get()->keyBy('external_parking_id');
        $activeReservationsCount = $activeReservations->count();
            
        $beschikbaar = max(0, $totalSpots - $activeReservationsCount);
        $bezet       = 0; 
        $gereserveerd = $activeReservationsCount;
        
        $bezettingsgraad = $totalSpots > 0 ? round((($bezet + $gereserveerd) / $totalSpots) * 100) : 0;

        $spots = $apiSpots->map(function($spot) use ($activeReservations) {
            $spot['status'] = $activeReservations->has($spot['id']) ? 'gereserveerd' : 'beschikbaar';
            return $spot;
        });

        $user = Auth::user();

        $mijnReservaties = Reservation::where('user_id', $user->id)
            ->where('status', 'actief')
            ->latest()
            ->take(3)
            ->get();
            
        // Append API data to reservations
        $mijnReservaties->transform(function ($reservation) {
            $reservation->spot_details = $this->parkingService->getSpotById($reservation->external_parking_id);
            return $reservation;
        });

        $vehicles = $user->vehicles;

        return view('user.dashboard', compact(
            'spots', 'beschikbaar', 'bezet', 'gereserveerd',
            'bezettingsgraad', 'mijnReservaties', 'totalSpots', 'vehicles'
        ));
    }
}
