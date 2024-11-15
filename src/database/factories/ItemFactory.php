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

        $images = Storage::disk('public')->files('images');
        $randomImage = $this->faker->randomElement($images);
        $fileName = basename($randomImage);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'img_url' => url('storage/images/' . $fileName),
            'name' => $faker->word,
            'price' => $faker->numberBetween(100, 50000),
            'description' => $faker->sentence,
            'category' => $faker->randomElement(['ファッション', '電子機器', '家庭用品', '美容健康']),
            'condition' => $faker->randomElement(['新品', '良好', 'やや傷や汚れあり', '状態が悪い']),
        ];
    }
}
