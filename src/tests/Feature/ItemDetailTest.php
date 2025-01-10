<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_page_displays_correctly() {
        $item = Item::factory()->create([
            'name' => 'Test Item',
            'brand' => 'Test Brand',
            'price' => 1000,
            'description' => 'This is a test product.',
            'category' => 'Test Category,Another Category',
            'condition' => 'New',
        ]);

        $comment = Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => 1,
            'content' => 'This is a test comment.',
        ]);

        $favorite = Favorite::create([
            'item_id' => $item->id,
            'user_id' => 1,
        ]);

        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get(route('item.detail', ['item_id' => $item->id]));

        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee($item->brand);
        $response->assertSee('¥' . number_format($item->price));
        $response->assertSeeText($item->description);
        $response->assertSee($item->condition);
        $response->assertSee($comment->content);
        $response->assertSee($favorite->count());
        $response->assertSee($comment->user->name);

        foreach (explode(',', $item->category) as $category) {
            $response->assertSee($category);
        }
    }
}
