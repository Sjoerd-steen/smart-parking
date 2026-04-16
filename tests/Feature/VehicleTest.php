<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_integration_goed_scenario()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/user/voertuigen', [
            'license_plate' => 'AB-123-C',
            'type' => 'Auto'
        ]);
        $response->assertStatus(302);
    }

    public function test_vehicle_integration_fout_scenario()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/user/voertuigen', []);
        $response->assertSessionHasErrors(['license_plate']);
    }
}
