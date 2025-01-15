<?php

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_displays_correct_information() {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'image' => 'path/to/profile/image.jpg',
        ]);

        $item1 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品1',
        ]);
        $item2 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品2',
        ]);

        $purchase1 = Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item1->id,
        ]);
        $purchase2 = Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item2->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('user.myPage'));

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');


        $response->assertSee('path/to/profile/image.jpg');

        $response->assertSee('出品商品1');
        $response->assertSee('出品商品2');

        $response->assertSee('出品商品1');
        $response->assertSee('出品商品2');
    }

    public function test_user_can_see_initial_values_on_profile_page() {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'postcode' => '123-4567',
            'address' => 'Test Address',
            'build' => 'Test Building',
            'image' => 'profile_image.jpg',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('user.editProfile'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->postcode);
        $response->assertSee($user->address);
        $response->assertSee($user->build);

        $response->assertSee('storage/' . $user->image);
    }
}