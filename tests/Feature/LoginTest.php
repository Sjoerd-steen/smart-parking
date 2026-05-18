<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the login functionality.
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials_and_redirect_to_main_page()
    {
        // 1. Maak een gebruiker aan (zodat we gegevens hebben)
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Ga naar de login pagina in get request niet strikt verplicht, maar zorgt voor form session token e.d. (optioneel in testing)
        $response = $this->get('/login');
        $response->assertStatus(200);

        // 3. Vul e-mail en wachtwoord in en post
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // 4. Verwacht dat we zijn ingelogd en naar dashboard of home zijn omgeleid
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/home'); // Of dashboard, pas aan afhankelijk van je applicatie
    }
}
