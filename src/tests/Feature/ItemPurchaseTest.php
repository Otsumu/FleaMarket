<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemPurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_item() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('item.purchase.post', $item->id), [
            'payment_method' => 'credit_card',
        ]);

        $response->assertRedirect(route('item.detail', $item->id));
        $response->assertSessionHas('success', '購入が完了しました！');

        $item->refresh();
        $this->assertEquals('soldout', $item->status);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_purchased_item_is_marked_as_soldout_on_item_list() {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'status' => 'available',
        ]);

        $this->actingAs($user);

        $this->post(route('item.purchase.post', $item->id));

        $response = $this->get(route('item.index'));
        $response->assertSee('soldout');
        $response->assertSee($item->name);
    }

    public function test_purchased_item_is_added_to_user_profile() {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'status' => 'available',
        ]);

        $this->actingAs($user);

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
        ]);

        $item->update(['status' => 'soldout']);

        $response = $this->get(route('user.myPage'));

        $response->assertSee($item->name);
    }
}