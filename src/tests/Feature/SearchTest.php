<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_items_by_name() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item1 = Item::factory()->create(['name' => 'Laptop']);
        $item2 = Item::factory()->create(['name' => 'Smartphone']);
        $item3 = Item::factory()->create(['name' => 'Tablet']);

        $response = $this->get('/item/search?query=Laptop');

        $response->assertStatus(200)
            ->assertViewIs('item.index')
            ->assertViewHas('items')
            ->assertSee('Laptop')
            ->assertDontSee('Smartphone')
            ->assertDontSee('Tablet');

        $this->assertEquals('Laptop', session('search_query'));
    }

    public function test_search_state_is_retained_in_my_list() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item1 = Item::factory()->create(['name' => 'Laptop']);
        $item2 = Item::factory()->create(['name' => 'Smartphone']);

        $response = $this->get('/item/search?query=Laptop');

        $response->assertStatus(200)
            ->assertViewHas('items', function ($items) {
                return $items->count() === 1 && $items->first()->name === 'Laptop';
        });

        $this->assertEquals('Laptop', session('search_query'));
    }
}