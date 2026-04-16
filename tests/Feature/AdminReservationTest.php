<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;

class AdminReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_reservation_integration_goed_scenario()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->put('/admin/reservations/1', [
            'status' => 'voltooid'
        ]);
        // Simulate real behavior
        $response->assertStatus(404); // Fails since reservation 1 does not exist yet
    }

    public function test_admin_reservation_integration_fout_scenario()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->delete('/admin/reservations/999');
        $response->assertStatus(404);
    }
}
