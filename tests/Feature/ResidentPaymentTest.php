<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\Building;
use App\Models\Residence;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResidentPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_resident_receipt_is_sent_to_their_syndic_for_validation(): void
    {
        $syndic = User::factory()->create(['role' => 'syndic']);
        $resident = User::factory()->create(['role' => 'resident']);
        $residence = Residence::create(['syndic_id' => $syndic->id, 'name' => 'Résidence Test']);
        $building = Building::create([
            'residence_id' => $residence->id,
            'name' => 'Bâtiment A',
            'code' => 'BAT-A',
        ]);
        $apartment = Apartment::create([
            'building_id' => $building->id,
            'user_id' => $resident->id,
            'number' => '101',
            'floor' => 1,
            'monthly_fee' => 800,
            'status' => 'occupied',
        ]);

        $response = $this->actingAs($resident)->post(route('resident.payments.store'), [
            'amount' => 800,
            'month' => '2026-09',
            'payment_method' => 'virement',
            'payment_date' => '2026-09-16',
            'confirmation' => '1',
        ]);

        $response->assertRedirect(route('resident.payments', absolute: false));
        $this->assertDatabaseHas('payments', [
            'apartment_id' => $apartment->id,
            'user_id' => $resident->id,
            'status' => 'pending',
            'amount' => 800,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $syndic->id,
            'read_at' => null,
        ]);

        $this->actingAs($syndic)
            ->get(route('syndic.payments.index'))
            ->assertSee($resident->name)
            ->assertSee('À valider par le syndic');

        $payment = Payment::where('user_id', $resident->id)->latest()->first();
        $this->actingAs($syndic)
            ->patch(route('syndic.payments.approve', $payment))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('payments', ['id' => $payment->id, 'status' => 'paid']);
    }
}