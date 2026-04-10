<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Reservation};
use App\Services\ParkingApiService;

class AdminDashboardController extends Controller {

    protected $parkingService;

    public function __construct(ParkingApiService $parkingService) {
        $this->parkingService = $parkingService;
    }

    public function index() {
        $totalUsers        = User::where('role', 'user')->count();
        $totalReservations = Reservation::count();
        $actief            = Reservation::where('status', 'actief')->count();
        $omzet             = Reservation::where('betaald', true)->sum('totaal_prijs');
        
        $spots = $this->parkingService->getRotterdamParkingSpots();
        $totalSpots = $spots->count();
        
        // Calculate available spots based on active reservations
        $activeReservationsCount = Reservation::where('status', 'actief')
            ->distinct('external_parking_id')
            ->count('external_parking_id');
            
        $beschikbaar       = $totalSpots - $activeReservationsCount;
        $bezettingsgraad   = $totalSpots > 0
            ? round(($activeReservationsCount / $totalSpots) * 100)
            : 0;

        $recentReservations = Reservation::with(['user'])
            ->latest()->take(5)->get();
            
        // Append API data to recent reservations
        $recentReservations->transform(function ($reservation) {
            $reservation->spot_details = $this->parkingService->getSpotById($reservation->external_parking_id);
            return $reservation;
        });

        return view('admin.dashboard', compact(
            'totalUsers','totalSpots','beschikbaar','totalReservations',
            'actief','omzet','bezettingsgraad','recentReservations'
        ));
    }
}
