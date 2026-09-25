<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_work_order(): void
    {
        $user = User::factory()->create(['role' => 'operator']);
        $client = Client::create(['name' => 'Cliente Test', 'status' => 'active']);
        $service = Service::create(['name' => 'Servicio Test', 'base_price' => 1000, 'active' => true]);

        $this->actingAs($user)->post('/orders', [
            'client_id' => $client->id,
            'service_id' => $service->id,
            'assigned_to' => $user->id,
            'title' => 'Orden Test',
            'status' => 'new',
            'priority' => 'medium',
            'total' => 1000,
        ])->assertRedirect('/orders');

        $this->assertDatabaseHas('work_orders', ['title' => 'Orden Test']);
    }
}
