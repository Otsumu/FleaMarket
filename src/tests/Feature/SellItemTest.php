<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class SellItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_item() {
        Storage::fake('public');

        $user = User::factory()->create();

        $image = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        $itemData = [
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明',
            'img_url' => $image,
            'category' => '電子機器',
            'condition' => '新品',
            'price' => 1000,
        ];

        $response = $this->actingAs($user)
                        ->post(route('item.store'), $itemData);

        $response->assertRedirect(route('item.index'));

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明',
            'category' => '電子機器',
            'condition' => '新品',
            'price' => 1000,
            'user_id' => $user->id
        ]);
    }
}