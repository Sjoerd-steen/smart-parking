<?php
$file = 'app/Services/ParkingApiService.php';
$content = file_get_contents($file);

$newContent = <<<PHP
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ParkingApiService
{
    /**
     * Fetch parking spots in Rotterdam using OpenStreetMap Overpass API
     */
    public function getRotterdamParkingSpots()
    {
        // 1. Check if we have a fresh 1-hour cache
        \$spots = Cache::get('rotterdam_parking_spots_fresh');
        if (\$spots) {
            return collect(\$spots);
        }

        // 2. Fetch from API
        \$query = '[out:json];
        area["name"="Rotterdam"]["admin_level"="8"]->.searchArea;
        (
          node["amenity"="parking"](area.searchArea);
          way["amenity"="parking"](area.searchArea);
        );
        out center 50;';

        \$apiSuccess = false;
        \$spots = [];

        try {
            \$response = Http::timeout(5)->get('https://overpass-api.de/api/interpreter', [
                'data' => \$query
            ]);

            if (\$response->successful()) {
                \$data = \$response->json();
                if (isset(\$data['elements'])) {
                    foreach(\$data['elements'] as \$el) {
                        \$lat = \$el['lat'] ?? \$el['center']['lat'] ?? null;
                        \$lon = \$el['lon'] ?? \$el['center']['lon'] ?? null;
                        if (!\$lat || !\$lon) continue;

                        \$spots[] = [
                            'id' => (string) \$el['id'],
                            'name' => \$el['tags']['name'] ?? 'Parking ' . \$el['id'],
                            'lat' => \$lat,
                            'lng' => \$lon,
                            'city' => 'Rotterdam',
                            'capacity' => \$el['tags']['capacity'] ?? rand(20, 200),
                            'price_per_hour' => 2.00, // Default mock price
                        ];
                    }
                    if (count(\$spots) > 0) {
                        \$apiSuccess = true;
                    }
                }
            }
        } catch (\Exception \$e) {
            \$apiSuccess = false;
        }

        // 3. If API was successful, cache it both short-term (1hr) and long-term (30 days backup)
        if (\$apiSuccess) {
            Cache::put('rotterdam_parking_spots_fresh', \$spots, 3600);
            Cache::put('rotterdam_parking_spots_backup', \$spots, now()->addDays(30));
            return collect(\$spots);
        }

        // 4. If API failed, check for the long-term 30-day backup cache
        \$backupSpots = Cache::get('rotterdam_parking_spots_backup');
        if (\$backupSpots) {
            return collect(\$backupSpots);
        }

        // 5. If there is absolutely no backup cache (first ever run & API is down), use the local mock fallback
        return collect(self::getFallbackSpots());
    }

    private static function getFallbackSpots()
    {
        return [
            [
                'id' => 'mock-1',
                'name' => 'Parking Markthal',
                'lat' => 51.920,
                'lng' => 4.485,
                'city' => 'Rotterdam',
                'capacity' => 150,
                'price_per_hour' => 2.50,
            ],
            [
                'id' => 'mock-2',
                'name' => 'Parking Erasmusbrug',
                'lat' => 51.912,
                'lng' => 4.481,
                'city' => 'Rotterdam',
                'capacity' => 200,
                'price_per_hour' => 3.00,
            ],
            [
                'id' => 'mock-3',
                'name' => 'Parking Centraal Station',
                'lat' => 51.925,
                'lng' => 4.469,
                'city' => 'Rotterdam',
                'capacity' => 300,
                'price_per_hour' => 2.00,
            ]
        ];
    }

    public function getSpotById(\$id)
    {
        \$spot = \$this->getRotterdamParkingSpots()->firstWhere('id', (string) \$id);
        return \$spot;
    }
}
PHP;

file_put_contents($file, $newContent);
echo "File updated successfully.";
?>
