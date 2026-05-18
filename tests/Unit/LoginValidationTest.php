<?php

namespace Tests\Unit;

use Tests\TestCase; // Gebruik Tests\TestCase voor features zoals HTTP requests

class LoginValidationTest extends TestCase
{
    /**
     * Test empty inputs return error message.
     *
     * @return void
     */
    public function test_login_validation_fails_with_empty_inputs()
    {
        // 1. Post request met lege velden
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        // 2. Expect session error met 'Vul alle velden in' of standaard laravel validatie bericht
        $response->assertSessionHasErrors(['email', 'password']);
    }
}
