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
            ['id' => 'rot-11', 'name' => 'Parkeergarage Meent', 'lat' => 51.922, 'lng' => 4.482, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 2.50],
            ['id' => 'rot-12', 'name' => 'Parking Zuidplein', 'lat' => 51.884, 'lng' => 4.488, 'city' => 'Rotterdam', 'capacity' => 1500, 'price_per_hour' => 1.50],
            ['id' => 'rot-13', 'name' => 'Parkhaven P1', 'lat' => 51.906, 'lng' => 4.466, 'city' => 'Rotterdam', 'capacity' => 350, 'price_per_hour' => 2.00],
            ['id' => 'rot-14', 'name' => 'Kuip P2', 'lat' => 51.894, 'lng' => 4.520, 'city' => 'Rotterdam', 'capacity' => 800, 'price_per_hour' => 2.00],
            ['id' => 'rot-15', 'name' => 'Ahoy P1', 'lat' => 51.883, 'lng' => 4.489, 'city' => 'Rotterdam', 'capacity' => 1200, 'price_per_hour' => 3.00],
            ['id' => 'rot-16', 'name' => 'Delfshaven Parking', 'lat' => 51.910, 'lng' => 4.450, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 2.00],
            ['id' => 'rot-17', 'name' => 'Kralingse Zoom', 'lat' => 51.918, 'lng' => 4.530, 'city' => 'Rotterdam', 'capacity' => 600, 'price_per_hour' => 1.50],
            ['id' => 'rot-18', 'name' => 'Slinge Parking', 'lat' => 51.874, 'lng' => 4.482, 'city' => 'Rotterdam', 'capacity' => 850, 'price_per_hour' => 1.00],
            ['id' => 'rot-19', 'name' => 'Capelsebrug', 'lat' => 51.928, 'lng' => 4.550, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 1.50],
            ['id' => 'rot-20', 'name' => 'Meijersplein', 'lat' => 51.956, 'lng' => 4.476, 'city' => 'Rotterdam', 'capacity' => 350, 'price_per_hour' => 1.50],
            ['id' => 'rot-21', 'name' => 'Alexander', 'lat' => 51.956, 'lng' => 4.555, 'city' => 'Rotterdam', 'capacity' => 900, 'price_per_hour' => 1.80],
            ['id' => 'rot-22', 'name' => 'Nesselande P+R', 'lat' => 52.002, 'lng' => 4.582, 'city' => 'Rotterdam', 'capacity' => 500, 'price_per_hour' => 1.00],
            ['id' => 'rot-23', 'name' => 'Beverwaard P+R', 'lat' => 51.890, 'lng' => 4.552, 'city' => 'Rotterdam', 'capacity' => 400, 'price_per_hour' => 1.00],
            ['id' => 'rot-24', 'name' => 'Kralingse Bos N', 'lat' => 51.940, 'lng' => 4.515, 'city' => 'Rotterdam', 'capacity' => 200, 'price_per_hour' => 2.00],
            ['id' => 'rot-25', 'name' => 'Kralingse Bos Z', 'lat' => 51.930, 'lng' => 4.525, 'city' => 'Rotterdam', 'capacity' => 250, 'price_per_hour' => 2.00],
                        ['id' => 'rot-26', 'name' => 'Maassluis Centrum', 'lat' => 51.921, 'lng' => 4.255, 'city' => 'Maassluis', 'capacity' => 100, 'price_per_hour' => 1.50],
            ['id' => 'rot-27', 'name' => 'Maassluis West', 'lat' => 51.922, 'lng' => 4.240, 'city' => 'Maassluis', 'capacity' => 120, 'price_per_hour' => 1.50],
            ['id' => 'rot-28', 'name' => 'Maassluis Station', 'lat' => 51.919, 'lng' => 4.250, 'city' => 'Maassluis', 'capacity' => 150, 'price_per_hour' => 1.00],
            ['id' => 'rot-29', 'name' => 'Lely Maassluis', 'lat' => 51.925, 'lng' => 4.260, 'city' => 'Maassluis', 'capacity' => 80, 'price_per_hour' => 1.20],
            ['id' => 'rot-30', 'name' => 'Koningshoek Maassluis', 'lat' => 51.928, 'lng' => 4.245, 'city' => 'Maassluis', 'capacity' => 200, 'price_per_hour' => 2.00],
            ['id' => 'rot-31', 'name' => 'Steendijkpolder', 'lat' => 51.930, 'lng' => 4.250, 'city' => 'Maassluis', 'capacity' => 90, 'price_per_hour' => 1.00],
            ['id' => 'rot-32', 'name' => 'Maassluis Haven', 'lat' => 51.918, 'lng' => 4.252, 'city' => 'Maassluis', 'capacity' => 110, 'price_per_hour' => 1.50],
            ['id' => 'rot-33', 'name' => 'Maassluis Markt', 'lat' => 51.920, 'lng' => 4.254, 'city' => 'Maassluis', 'capacity' => 60, 'price_per_hour' => 1.50],
            ['id' => 'rot-34', 'name' => 'Burgemeesterwijk', 'lat' => 51.923, 'lng' => 4.258, 'city' => 'Maassluis', 'capacity' => 75, 'price_per_hour' => 1.20],
            ['id' => 'rot-35', 'name' => 'Sluispolder', 'lat' => 51.916, 'lng' => 4.248, 'city' => 'Maassluis', 'capacity' => 130, 'price_per_hour' => 1.00],
            ['id' => 'rot-36', 'name' => 'Maassluis Zuid', 'lat' => 51.915, 'lng' => 4.245, 'city' => 'Maassluis', 'capacity' => 140, 'price_per_hour' => 1.00],
            ['id' => 'rot-37', 'name' => 'Maassluis Oost', 'lat' => 51.917, 'lng' => 4.260, 'city' => 'Maassluis', 'capacity' => 100, 'price_per_hour' => 1.00],
            ['id' => 'rot-38', 'name' => 'Vogelwijk', 'lat' => 51.924, 'lng' => 4.242, 'city' => 'Maassluis', 'capacity' => 65, 'price_per_hour' => 1.00],
            ['id' => 'rot-39', 'name' => 'Kapelpolder', 'lat' => 51.926, 'lng' => 4.265, 'city' => 'Maassluis', 'capacity' => 85, 'price_per_hour' => 1.00],
            ['id' => 'rot-40', 'name' => 'Maassluis P1', 'lat' => 51.921, 'lng' => 4.253, 'city' => 'Maassluis', 'capacity' => 200, 'price_per_hour' => 1.50],
            ['id' => 'rot-41', 'name' => 'Maassluis P2', 'lat' => 51.922, 'lng' => 4.256, 'city' => 'Maassluis', 'capacity' => 180, 'price_per_hour' => 1.50],
            ['id' => 'rot-42', 'name' => 'Maassluis P3', 'lat' => 51.920, 'lng' => 4.251, 'city' => 'Maassluis', 'capacity' => 150, 'price_per_hour' => 1.20],
            ['id' => 'rot-43', 'name' => 'Maassluis P4', 'lat' => 51.919, 'lng' => 4.249, 'city' => 'Maassluis', 'capacity' => 120, 'price_per_hour' => 1.20],
            ['id' => 'rot-44', 'name' => 'Maassluis P5', 'lat' => 51.923, 'lng' => 4.246, 'city' => 'Maassluis', 'capacity' => 90, 'price_per_hour' => 1.00],
            ['id' => 'rot-45', 'name' => 'Maassluis P6', 'lat' => 51.924, 'lng' => 4.244, 'city' => 'Maassluis', 'capacity' => 110, 'price_per_hour' => 100],
            ['id' => 'rot-46', 'name' => 'Pyongyang Central', 'lat' => 39.019, 'lng' => 125.738, 'city' => 'North Korea', 'capacity' => 250, 'price_per_hour' => 500],
            ['id' => 'rot-47', 'name' => 'Kim Il Sung Square', 'lat' => 39.018, 'lng' => 125.753, 'city' => 'North Korea', 'capacity' => 500, 'price_per_hour' => 1000.00],
            ['id' => 'rot-48', 'name' => 'Rungrado 1st of May Stadium', 'lat' => 39.049, 'lng' => 125.775, 'city' => 'North Korea', 'capacity' => 400, 'price_per_hour' => 400],
            ['id' => 'rot-49', 'name' => 'Juche Tower Parking', 'lat' => 39.017, 'lng' => 125.763, 'city' => 'North Korea', 'capacity' => 150, 'price_per_hour' => 200],
            ['id' => 'rot-50', 'name' => 'Indie Central', 'lat' => 20.593, 'lng' => 78.962, 'city' => 'Indie', 'capacity' => 300, 'price_per_hour' => 150],
        ];
    }

    public function getSpotById($id)
    {
        $spot = $this->getRotterdamParkingSpots()->firstWhere('id', (string) $id);
        return $spot;
    }
}