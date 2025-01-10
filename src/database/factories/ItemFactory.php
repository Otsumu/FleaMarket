<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Item;
use Faker\Factory as Faker;


class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition() {
        $faker = Faker::create('ja_JP');

        $imageFiles = [
            'image1.jpg',
            'image2.jpg',
            'image3.jpg',
            'image4.jpg',
            'image5.jpg',
            'image6.jpg',
            'image7.jpg',
            'image8.jpg',
            'image9.jpg',
            'image10.jpg',
        ];

        $randomImage = $this->faker->randomElement($imageFiles);

        return [
            'user_id' => User::factory()->create()->id,
            'img_url' => 'images/' . $randomImage,
            'name' => $faker->randomElement([
                        'スポーツウェア',
                        '最新型スマートフォン',
                        'オシャレな時計',
                        '本格的なコーヒーマシン',
                        'スタイリッシュなデスクライト',
                        'プレミアムヘッドフォン'
                    ]) . ' ' . $faker->randomElement(['限定モデル', '新発売', 'お得なセット', '特別割引中']),
            'price' => $faker->numberBetween(100, 50000),
            'description' => 'これはダミーです',
            'category' => $faker->randomElement(['ファッション', '電子機器', '家庭用品', '美容健康']),
            'condition' => $faker->randomElement(['新品', '良好', 'やや傷や汚れあり', '状態が悪い']),
        ];
    }
}
