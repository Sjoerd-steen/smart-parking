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
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->put('/admin/reserveringen/1', [
            'status' => 'voltooid'
        ]);
 
        $response->assertStatus(404);
    }

    public function test_admin_reservation_integration_fout_scenario()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->delete('/admin/reserveringen/999');
        $response->assertStatus(404);
    }
}
