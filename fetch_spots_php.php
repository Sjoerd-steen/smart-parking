<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$query = '[out:json];
area["name"="Rotterdam"]["admin_level"="8"]->.searchArea;
(
  node["amenity"="parking"](area.searchArea);
  way["amenity"="parking"](area.searchArea);
);
out center 50;';

try {
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()->timeout(15)->get('https://overpass-api.de/api/interpreter', [
        'data' => $query
    ]);
    
    if ($response->successful()) {
        file_put_contents(__DIR__ . '/storage/app/rotterdam_parking_fixed.json', $response->body());
        echo "Successfully downloaded real parking spots to storage!\n";
    } else {
        echo "API failed: " . $response->status() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
