<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    public function test_register_goed_scenario()
    {
        // Scenario 1 (goed)
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->password = 'password123';
        $this->assertEquals('test@example.com', $user->email);
    }

    public function test_register_fout_scenario()
    {
        // Scenario 2 (fout)
        $email = 'ongeldig-email';
        $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL) !== false);
    }
}
