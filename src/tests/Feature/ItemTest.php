<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_items() {
        $items = Item::factory(5)->create();

        $response = $this->get('/');

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_sold_items_display_sold_label() {
        $item = Item::factory()->create([
            'status' => 'soldout',
        ]);

        $response = $this->get('/');
        $response->assertSeeText('soldout');
    }

    public function test_user_cannot_see_their_own_items() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get('/');

        $response->assertDontSeeText($item->name);
    }
}
