<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_shipping_address_reflects_on_purchase_page() {
        $user = User::factory()->create([
            'postcode' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'build' => '渋谷マンション101'
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('user.changeAddress', $item->id));

        $response->assertSee($user->postcode);
        $response->assertSee($user->address);
        $response->assertSee($user->build);
    }

    public function test_shipping_address_is_associated_with_purchase() {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
            'postcode' => null,
            'address' => null,
            'build' => null,
        ]);

        $postcode = '123-4567';
        $address = '東京都渋谷区1-2-3';
        $build = '渋谷マンション101';

        $user->update([
            'postcode' => $postcode,
            'address' => $address,
            'build' => $build
        ]);

        $purchase->update([
            'postcode' => $postcode,
            'address' => $address,
            'build' => $build
        ]);

        $purchase->refresh();
        $this->assertEquals($postcode, $purchase->postcode);
        $this->assertEquals($address, $purchase->address);
        $this->assertEquals($build, $purchase->build);
    }
}