<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Reservation;

class AdminReservationTest extends TestCase
{
    public function test_admin_reservation_goed_scenario()
    {
        // Scenario 1 (goed)
        $reservation = new Reservation();
        $reservation->status = 'voltooid';
        $this->assertEquals('voltooid', $reservation->status);
    }

    public function test_admin_reservation_fout_scenario()
    {
        // Scenario 2 (fout)
        $reservation = new Reservation();
        $reservation->id = 1;
        $this->assertNotNull($reservation->id);
    }
}
