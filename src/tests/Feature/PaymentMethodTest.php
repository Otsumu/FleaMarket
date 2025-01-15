<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_changes_reflect_immediately() {
        $item = Item::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('item.purchase', $item->id));

        $response->assertSee('カード支払い');

        $response->assertSee('コンビニ支払い');
    }
}
