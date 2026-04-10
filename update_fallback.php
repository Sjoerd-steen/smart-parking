<?php
$file = 'app/Services/ParkingApiService.php';
$content = file_get_contents($file);

$hardcoded = <<<PHP
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
PHP;

$content = preg_replace('/private static function getFallbackSpots\(\).*?\];\s*\}/s', $hardcoded, $content);
file_put_contents($file, $content);
