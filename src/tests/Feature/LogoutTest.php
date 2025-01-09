<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');

        $this->assertFalse(Auth::check());
    }
}
