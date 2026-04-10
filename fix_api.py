with open('app/Services/ParkingApiService.php', 'r') as f:
    content = f.read()

old_code = """
            try {
                $response = Http::timeout(5)->get('https://overpass-api.de/api/interpreter', [
                    'data' => $query
                ]);
            } catch (\Exception $e) {
                return []; // Fallback empty map on api fail
            }

            if ($response->successful()) {
                $elements = $response->json()['elements'] ?? [];
                
                $spots = [];
                foreach($elements as $el) {
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
                return $spots;
            }
            
            return [];
        });

        return collect($spotsArray);
    }"""

new_code = """
            try {
                $response = Http::timeout(5)->get('https://overpass-api.de/api/interpreter', [
                    'data' => $query
                ]);
            } catch (\Exception $e) {
                return self::getFallbackSpots(); // Fallback on api fail
            }

            if ($response->successful()) {
                $data = $response->json();
                if (!isset($data['elements'])) {
                    return self::getFallbackSpots();
                }
                
                $spots = [];
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
                return count($spots) > 0 ? $spots : self::getFallbackSpots();
            }
            
            return self::getFallbackSpots();
        });

        return collect($spotsArray);
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
    }"""

content = content.replace(old_code, new_code)

with open('app/Services/ParkingApiService.php', 'w') as f:
    f.write(content)

