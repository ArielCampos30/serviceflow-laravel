<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $password = Str::random(24);
        User::factory()->create(['email' => 'test@example.com', 'password' => $password]);

        $this->post('/login', ['email' => 'test@example.com', 'password' => $password])
            ->assertRedirect('/');

        $this->assertAuthenticated();
    }
}
