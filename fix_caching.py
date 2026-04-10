with open('app/Services/ParkingApiService.php', 'r') as f:
    content = f.read()

# We want to replace the whole getRotterdamParkingSpots method.
import re

pattern = r'public function getRotterdamParkingSpots\(\).*?private static function getFallbackSpots\(\)'
replacement = """public function getRotterdamParkingSpots()
    {
        // Try to get fresh cache (e.g. 1 hour)
        $cachedSpots = Cache::get('rotterdam_parking_spots_fresh');
        if ($cachedSpots) {
            return collect($cachedSpots);
        }

        // Overpass API query for parking spots in Rotterdam limited to 50 results
        $query = '[out:json];
        area["name"="Rotterdam"]["admin_level"="8"]->.searchArea;
        (
          node["amenity"="parking"](area.searchArea);
          way["amenity"="parking"](area.searchArea);
        );
        out center 50;';

        $spots = [];
        $apiSuccess = false;

        try {
            $response = Http::timeout(5)->get('https://overpass-api.de/api/interpreter', [
                'data' => $query
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['elements'])) {
                    foreach($data['elements'] as $el) {
                        $lat = $el['lat'] ?? $el['center']['lat'] ?? null;
                        $lon = $el['lon'] ?? $el['center']['lon'] ?? null;
                        if (!$lat || !$lon) continue;

                        $spots[] = [
                            'id' => (string) $el['id'],
                            'name' => $el['tags']['name'] ?? 'Parking ' . $el['id'],
                            'lat' => $lat,
                            'lng' => $lon,
                            'city' => 'Rotterdam',
                            'capacity' => $el['tags']['capacity'] ?? rand(20, 200),
                            'price_per_hour' => 2.00, // Default mock price
                        ];
                    }
                    if (count($spots) > 0) {
                        $apiSuccess = true;
                    }
                }
            }
        } catch (\Exception $e) {
            $apiSuccess = false;
        }

        if ($apiSuccess) {
            // Save to fresh cache for 1 hour
            Cache::put('rotterdam_parking_spots_fresh', $spots, 3600);
            // Save to backup cache for 30 days
            Cache::put('rotterdam_parking_spots_backup', $spots, now()->addDays(30));
            
            return collect($spots);
        }

        // If API failed, try to use backup cache
        $backupSpots = Cache::get('rotterdam_parking_spots_backup');
        if ($backupSpots) {
            return collect($backupSpots);
        }

        // If no backup exists, use the hardcoded fallback
        return collect(self::getFallbackSpots());
    }

    private static function getFallbackSpots()"""

new_content = re.sub(pattern, replacement, content, flags=re.DOTALL)

with open('app/Services/ParkingApiService.php', 'w') as f:
    f.write(new_content)

