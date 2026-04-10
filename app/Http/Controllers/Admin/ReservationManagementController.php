<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\ParkingApiService;
use Illuminate\Http\Request;

class ReservationManagementController extends Controller {

    protected $parkingService;

    public function __construct(ParkingApiService $parkingService) {
        $this->parkingService = $parkingService;
    }

    public function index(Request $request) {
        $query = Reservation::with(['user']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
        }

        $reservations = $query->latest()->paginate(15);
        
        $reservations->getCollection()->transform(function ($reservation) {
            $reservation->spot_details = $this->parkingService->getSpotById($reservation->external_parking_id);
            return $reservation;
        });
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function update(Request $request, Reservation $reservation) {
        $request->validate([
            'status' => 'required|in:actief,geannuleerd,voltooid',
        ]);
        $reservation->update(['status' => $request->status]);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservering bijgewerkt.');
    }

    public function destroy(Reservation $reservation) {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservering verwijderd.');
    }
}
