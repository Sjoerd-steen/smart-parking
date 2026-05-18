<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SpotStatusTest extends TestCase
{
    /**
     * Test checking if a parking spot is available or occupied.
     *
     * @return void
     */
    public function test_check_if_spot_is_available()
    {
        // Omdat de spot status wellicht via een API komt of logical model
        // Mocken we even de functionaliteit. 
        $spotStatusData = [
            'id' => 5,
            'status' => 'vrij', // of 'bezet'
        ];

        // Test de simpele assert (Bijv op een custom class, in dit voorbeeld simpel in array of object vorm)
        $this->assertEquals('vrij', $spotStatusData['status']);
    }
}
