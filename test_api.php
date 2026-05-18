<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new App\Services\ParkingApiService();
$spots = $service->getRotterdamParkingSpots();
$cnt = 0;
foreach($spots as $s) {
    if ($s['city'] !== 'Rotterdam') {
        echo $s['id'] . ' ' . $s['city'] . ' ' . $s['name'] . "\n";
        $cnt++;
    }
}
echo "Total non-Rotterdam spots: " . $cnt . "\n";
