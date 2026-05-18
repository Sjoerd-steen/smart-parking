<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the payment process.
     *
     * @return void
     */
    public function test_user_can_pay_for_reservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Stel er is een reservering met status pending
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => 5.00
        ]);

        // Ga naar de betaalpagina
        $response = $this->get('/payment/' . $reservation->id);
        $response->assertStatus(200);

        // Kies betaalmethode en post
        $response = $this->post('/payment/' . $reservation->id . '/process', [
            'payment_method' => 'ideal',
            'amount' => 5.00
        ]);

        // Expect confirmation / redirect naar succes
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'paid' // of 'active'
        ]);
    }
}
