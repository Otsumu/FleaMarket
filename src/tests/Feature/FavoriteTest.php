<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_favorite() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('favorite.toggle', ['item_id' => $item->id]));

        $this->assertEquals(1, $item->favorites()->count());

        $response->assertJson([
            'status' => 'success',
            'favorite_count' => 1
        ]);
    }

    public function test_user_can_remove_favorite() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('favorite.toggle', ['item_id' => $item->id]));

        $response = $this->post(route('favorite.toggle', ['item_id' => $item->id]));
        $this->assertEquals(0, $item->favorites()->count());

        $response->assertJson([
            'status' => 'success',
            'favorite_count' => 0
        ]);
    }

    public function test_user_can_get_favorites() {
        $user = User::factory()->create();
        $item1 = Item::factory()->create();
        $item2 = Item::factory()->create();

        $this->actingAs($user);

        $user->favorites()->attach($item1);

        $response = $this->get(route('favorite.index'));

        $response->assertJsonFragment(['id' => $item1->id]);

        $response->assertJsonMissing(['id' => $item2->id]);
    }

    public function test_guest_cannot_add_favorite() {
        $item = Item::factory()->create();

        $response = $this->post(route('favorite.toggle', ['item_id' => $item->id]));

        $response->assertStatus(302);
    }
}