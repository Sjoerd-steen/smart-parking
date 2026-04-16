<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PaymentCalculationTest extends TestCase
{
    /**
     * Calculate price of reservation based on hours.
     *
     * @return void
     */
    public function test_calculate_total_price_based_on_duration()
    {
        $pricePerHour = 2.00;
        $durationInHours = 2; // Bijv. 2 uur parkeren

        // Bereken totaalprijs
        $totalPrice = $pricePerHour * $durationInHours;

        // Verwacht resultaat moet 4.00 zijn
        $this->assertEquals(4.00, $totalPrice);
    }
}
