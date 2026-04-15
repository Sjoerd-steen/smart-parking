import re

with open('app/Http/Controllers/User/ReservationController.php', 'r') as f:
    content = f.read()

# Modify apiStatus
pattern_api = r'''    public function apiStatus\(\) \{
        \$this->updateExpiredReservations\(\);

        \$now = Carbon::now\(\);
        \$currentDate = \$now->toDateString\(\);
        \$currentTime = \$now->toTimeString\(\);

        \$reservations = Reservation::where\('status', 'actief'\)
            ->where\('datum', \$currentDate\)
            ->where\('start_tijd', '<=', \$currentTime\)
            ->where\('eind_tijd', '>', \$currentTime\)
            ->pluck\('external_parking_id'\);

        return response\(\)->json\(\['reserved_spots' => \$reservations\]\);
    \}'''

replacement_api = '''    public function apiStatus() {
        $this->updateExpiredReservations();

        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->toTimeString();

        $currentlyActive = Reservation::where('status', 'actief')
            ->where('datum', $currentDate)
            ->where('start_tijd', '<=', $currentTime)
            ->where('eind_tijd', '>', $currentTime)
            ->pluck('external_parking_id');
            
        $upcomingToday = Reservation::where('status', 'actief')
            ->where('datum', $currentDate)
            ->where('start_tijd', '>', $currentTime)
            ->pluck('external_parking_id');

        return response()->json([
            'reserved_spots' => $currentlyActive,
            'upcoming_spots' => $upcomingToday
        ]);
    }'''

content = re.sub(pattern_api, replacement_api, content)

# Modify create
pattern_create = r'''    // Overzicht van beschikbare parkeerplaatsen om te reserveren \(Map view\)
    public function create\(Request \$request\) \{
        \$this->updateExpiredReservations\(\);

        \$spots = \$this->parkingService->getRotterdamParkingSpots\(\);
        
        \$now = Carbon::now\(\);
        \$currentDate = \$now->toDateString\(\);
        \$currentTime = \$now->toTimeString\(\);

        // Find existing non-cancelled reservations to mark spots as reserved
        \$reservations = Reservation::where\('status', 'actief'\)
            ->where\('datum', \$currentDate\)
            ->where\('start_tijd', '<=', \$currentTime\)
            ->where\('eind_tijd', '>', \$currentTime\)
            ->get\(\)->keyBy\('external_parking_id'\);
        
        // Map spots with reservation status
        \$spotsWithStatus = \$spots->map\(function\(\$spot\) use \(\$reservations\) \{
            \$spot\['reserved'\] = \$reservations->has\(\$spot\['id'\]\);
            return \$spot;
        \}\);'''

replacement_create = '''    // Overzicht van beschikbare parkeerplaatsen om te reserveren (Map view)
    public function create(Request $request) {
        $this->updateExpiredReservations();

        $spots = $this->parkingService->getRotterdamParkingSpots();
        
        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->toTimeString();

        // Find existing non-cancelled reservations to mark spots as reserved
        $activeReservations = Reservation::where('status', 'actief')
            ->where('datum', $currentDate)
            ->where('start_tijd', '<=', $currentTime)
            ->where('eind_tijd', '>', $currentTime)
            ->get()->keyBy('external_parking_id');
            
        $upcomingReservations = Reservation::where('status', 'actief')
            ->where('datum', $currentDate)
            ->where('start_tijd', '>', $currentTime)
            ->get()->keyBy('external_parking_id');
        
        // Map spots with reservation status
        $spotsWithStatus = $spots->map(function($spot) use ($activeReservations, $upcomingReservations) {
            if ($activeReservations->has($spot['id'])) {
                $spot['reserved_status'] = 'active';
            } elseif ($upcomingReservations->has($spot['id'])) {
                $spot['reserved_status'] = 'upcoming';
            } else {
                $spot['reserved_status'] = 'available';
            }
            return $spot;
        });'''

content = re.sub(pattern_create, replacement_create, content)

with open('app/Http/Controllers/User/ReservationController.php', 'w') as f:
    f.write(content)
