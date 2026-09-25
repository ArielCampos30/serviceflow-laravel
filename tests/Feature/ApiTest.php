<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.serviceflow.api_token' => 'test-api-token']);
    }

    public function test_api_rejects_requests_without_token(): void
    {
        $this->getJson('/api/v1/orders')->assertUnauthorized();
    }

    public function test_api_lists_and_creates_orders_with_valid_token(): void
    {
        $client = Client::create([
            'name' => 'Cliente API',
            'email' => 'api@example.test',
            'status' => 'active',
        ]);
        $service = Service::create([
            'name' => 'Servicio API',
            'base_price' => 1000,
            'active' => true,
        ]);
        $user = User::factory()->create();

        WorkOrder::create([
            'client_id' => $client->id,
            'service_id' => $service->id,
            'assigned_to' => $user->id,
            'title' => 'Orden existente',
            'status' => 'new',
            'priority' => 'medium',
            'total' => 1000,
        ]);

        $headers = ['Authorization' => 'Bearer test-api-token'];

        $this->withHeaders($headers)
            ->getJson('/api/v1/orders')
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('data.0.title', 'Orden existente');

        $this->withHeaders($headers)
            ->postJson('/api/v1/orders', [
                'client_id' => $client->id,
                'service_id' => $service->id,
                'assigned_to' => $user->id,
                'title' => 'Nueva orden vía API',
                'status' => 'scheduled',
                'priority' => 'high',
                'total' => 2500,
            ])
            ->assertCreated()
            ->assertJsonPath('data.title', 'Nueva orden vía API');

        $this->assertDatabaseHas('work_orders', ['title' => 'Nueva orden vía API']);
    }
}
