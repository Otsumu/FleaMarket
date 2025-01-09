<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void {
        $this->markTestSkipped('Default example test.');
    }

    public function test_name_is_required_for_registration() {
        $response = $this->withSession(['_token' => csrf_token()])
            ->from('/register')
            ->post('/register', [
                'name' => '',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required_for_registration() {
        $response = $this->withSession(['_token' => csrf_token()])
            ->from('/register')
            ->post('/register', [
                'name' => 'Test User',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required_for_registration() {
        $response = $this->withSession(['_token' => csrf_token()])
            ->from('/register')
            ->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_must_be_at_least_8_characters() {
        $response = $this->withSession(['_token' => csrf_token()])
            ->from('/register')
            ->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_must_match() {
        $response = $this->withSession(['_token' => csrf_token()])
            ->from('/register')
            ->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'differentpassword',
            ]);

        $response->assertSessionHasErrors('password');
    }
}