<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_liked_items_are_displayed() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedItem = Item::factory()->create();
        $user->favorites()->attach($likedItem);

        $response = $this->get('/');

        $response->assertSee($likedItem->name);
    }

    public function test_sold_items_display_sold_label() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $soldItem = Item::factory()->create([
            'status' => 'soldout',
        ]);

        $user->favorites()->attach($soldItem);

        $response = $this->get('/');

        $response->assertSee('soldout');
    }

    public function test_user_cannot_see_their_own_items() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('/');
        $response->assertDontSee($item->name);
    }

    public function test_guests_cannot_see_my_list() {
        $response = $this->getJson('/item/favorites');

        $response->assertStatus(401);
    }
}