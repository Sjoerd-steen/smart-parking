<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ReserveSpotTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test reserving an available parking spot.
     *
     * @return void
     */
    public function test_user_can_reserve_an_available_parking_spot()
    {
        // Ga ervan uit dat je parkeerplekken via een API ophaalt, we testen hier de reserveringsflow
        $user = User::factory()->create();

        // 1. Login
        $this->actingAs($user);

        // 2. We mocken een beschikbare spot en sturen post (of get) naar reserveren
        // Dit hangt af van hoe je database structuur is (Reservation.php), 
        // Bijvoorbeeld: spot id 10, starttijd, eindtijd.
        $reservationData = [
            'spot_id' => 10, // Beschikbare plek
            'start_time' => now()->addHour()->toDateTimeString(),
            'end_time' => now()->addHours(3)->toDateTimeString(),
            'total_price' => 4.00,
            'status' => 'active'
        ];

        // 3. Post data om te reserveren 
        // Pas de juiste route en parameters aan die in web.php of api.php staan.
        $response = $this->post('/reservations', $reservationData);

        // 4. Assert dat het is gelukt en plek is gereserveerd in de database
        $response->assertStatus(302); // Meestal een redirect naar betaling of succes pagina
        $this->assertDatabaseHas('reservations', [
            'spot_id' => 10,
            'user_id' => $user->id,
            'status' => 'active' // of 'pending'
        ]);
    }
}
