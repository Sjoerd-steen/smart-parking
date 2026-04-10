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
        $spotsArray = Cache::remember('rotterdam_parking_spots_array_v4', 3600, function () {
            // Overpass API query for parking spots in Rotterdam limited to 50 results
            $query = '[out:json];
            area["name"="Rotterdam"]["admin_level"="8"]->.searchArea;
            (
              node["amenity"="parking"](area.searchArea);
              way["amenity"="parking"](area.searchArea);
            );
            out center 50;';

            $response = Http::get('https://overpass.kumi.systems/api/interpreter', [
                'data' => $query
            ]);

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
    }

    public function getSpotById($id)
    {
        $spot = $this->getRotterdamParkingSpots()->firstWhere('id', (string) $id);
        return $spot;
    }
}
