<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Building;
use App\Models\Residence;
use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $syndic = User::factory()->create(['role' => 'syndic']);
        $residence = Residence::create([
            'syndic_id' => $syndic->id,
            'name' => 'Résidence Les Palmiers',
        ]);
        Building::create([
            'residence_id' => $residence->id,
            'name' => 'Bâtiment A',
            'code' => 'BAT-A',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'resident',
            'residence_name' => 'Résidence Les Palmiers',
            'building_name' => 'Bâtiment A',
            'apartment_number' => '14',
            'floor' => 3,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('resident.dashboard', absolute: false));
    }
}
