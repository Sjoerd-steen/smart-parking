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
        $spotsArray = Cache::rememberForever('rotterdam_parking_spots_fresh', function () {
            // 2. Fetch from API
            $query = '[out:json];
            area["name"="Rotterdam"]["admin_level"="8"]->.searchArea;
            (
              node["amenity"="parking"](area.searchArea);
              way["amenity"="parking"](area.searchArea);
            );
            out center 50;';

            $spots = [];

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
                    }
                }
            } catch (\Exception $e) {
                // Ignore the exception
            }

            if (count($spots) > 0) {
                // Cache the backup in case future requests fail after this cache expires
                Cache::put('rotterdam_parking_spots_backup', $spots, now()->addDays(30));
                return $spots;
            }

            // 4. If API failed, check for the long-term 30-day backup cache
            $backupSpots = Cache::get('rotterdam_parking_spots_backup');
            if ($backupSpots) {
                // If the cached backup is a collection, convert it to an array
                return is_array($backupSpots) ? $backupSpots : (method_exists($backupSpots, 'toArray') ? $backupSpots->toArray() : (array)$backupSpots);
            }

            // 5. If there is absolutely no backup cache (first ever run & API is down), use the local mock fallback
            return self::getFallbackSpots();
        });

        // Ensure we always return a collection, even if it was cached as an array or object
        return collect(is_object($spotsArray) && method_exists($spotsArray, 'toArray') ? $spotsArray->toArray() : $spotsArray);
    }

        private static function getFallbackSpots()
    {
        return [
            ['id' => 'rot-1', 'name' => 'Interparking Markthal', 'lat' => 51.920, 'lng' => 4.485, 'city' => 'Rotterdam', 'capacity' => 1200, 'price_per_hour' => 3.50],
            ['id' => 'rot-2', 'name' => 'Q-Park Koopgoot', 'lat' => 51.921, 'lng' => 4.481, 'city' => 'Rotterdam', 'capacity' => 850, 'price_per_hour' => 4.00],
            ['id' => 'rot-3', 'name' => 'Q-Park Weena', 'lat' => 51.923, 'lng' => 4.473, 'city' => 'Rotterdam', 'capacity' => 480, 'price_per_hour' => 3.50],
            ['id' => 'rot-4', 'name' => 'Parkeergarage Schouwburgplein', 'lat' => 51.920, 'lng' => 4.475, 'city' => 'Rotterdam', 'capacity' => 760, 'price_per_hour' => 2.50],
            ['id' => 'rot-5', 'name' => 'Interparking Lijnbaan', 'lat' => 51.921, 'lng' => 4.476, 'city' => 'Rotterdam', 'capacity' => 540, 'price_per_hour' => 3.00],
            ['id' => 'rot-6', 'name' => 'Parkeergarage Kruisplein', 'lat' => 51.920, 'lng' => 4.472, 'city' => 'Rotterdam', 'capacity' => 1300, 'price_per_hour' => 2.80],
            ['id' => 'rot-7', 'name' => 'ParkBee Witte de With', 'lat' => 51.916, 'lng' => 4.478, 'city' => 'Rotterdam', 'capacity' => 150, 'price_per_hour' => 2.00],
            ['id' => 'rot-8', 'name' => 'Q-Park De Doelen', 'lat' => 51.921, 'lng' => 4.473, 'city' => 'Rotterdam', 'capacity' => 600, 'price_per_hour' => 3.00],
            ['id' => 'rot-9', 'name' => 'Interparking Erasmusbrug', 'lat' => 51.912, 'lng' => 4.481, 'city' => 'Rotterdam', 'capacity' => 320, 'price_per_hour' => 3.20],
            ['id' => 'rot-10', 'name' => 'Parkeergarage Oude Haven', 'lat' => 51.919, 'lng' => 4.490, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 2.30],
        ];
    }

    public function getSpotById($id)
    {
        $spot = $this->getRotterdamParkingSpots()->firstWhere('id', (string) $id);
        return $spot;
    }
}