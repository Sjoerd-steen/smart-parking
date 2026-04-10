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

$response = \Illuminate\Support\Facades\Http::timeout(10)->asForm()->post('https://overpass-api.de/api/interpreter', [
    'data' => $query
]);

if ($response->successful()) {
    $data = $response->json();
    echo "Success! Found " . count($data['elements'] ?? []) . " spots.\n";
} else {
    echo "Failed! Status: " . $response->status() . "\n";
    echo $response->body() . "\n";
}
