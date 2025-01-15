<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_post_comment() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', $item->id), [
            'content' => 'これはテストコメントです。',
        ]);

        $response->assertRedirect(route('item.detail', $item->id))
                ->assertSessionHas('success', 'コメントが投稿されました！');

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'これはテストコメントです。',
        ]);
    }

    public function test_guest_cannot_post_comment() {
        $item = Item::factory()->create();

        $response = $this->post(route('comments.store', $item->id), [
            'content' => 'これはゲストコメントです。',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('comments', [
            'content' => 'これはゲストコメントです。',
        ]);
    }

    public function test_validation_fails_when_content_is_empty() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', $item->id), [
            'content' => '',
        ]);

        $response->assertSessionHasErrors([
            'content' => 'コメントを入力してください',
        ]);
    }

    public function test_validation_fails_when_content_exceeds_max_length() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', $item->id), [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors([
            'content' => '255文字以内で入力してください',
        ]);
    }

    public function test_user_cannot_post_duplicate_comments() {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post(route('comments.store', $item->id), [
            'content' => 'これは最初のコメントです。',
        ]);

        $response = $this->post(route('comments.store', $item->id), [
            'content' => 'これは別のコメントです。',
        ]);

        $response->assertRedirect(route('item.detail', $item->id))
                ->assertSessionHas('error', 'このアイテムにはすでにコメントを投稿しています');

        $this->assertEquals(1, Comment::where('user_id', $user->id)->where('item_id', $item->id)->count());
    }
}