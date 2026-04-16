<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Vehicle;

class VehicleTest extends TestCase
{
    public function test_vehicle_goed_scenario()
    {
        // Scenario 1 (goed)
        $vehicle = new Vehicle();
        $vehicle->license_plate = 'AB-123-C';
        $vehicle->type = 'Auto';
        $this->assertEquals('AB-123-C', $vehicle->license_plate);
    }

    public function test_vehicle_fout_scenario()
    {
        // Scenario 2 (fout)
        $vehicle = new Vehicle();
        $vehicle->license_plate = 'AB-123-C';
        $this->assertNull($vehicle->type);
    }
}
