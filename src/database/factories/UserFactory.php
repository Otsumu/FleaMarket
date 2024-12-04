<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');

        $imageUrl = $faker->imageUrl(400, 400, 'people');
        $imageContent = file_get_contents($imageUrl);
        $imageName = 'images/' . uniqid() . '.jpg';

        Storage::disk('public')->put($imageName, $imageContent);

        return [
            'name' => $this->faker->lastName() . ' ' . $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'address' => $this->faker->address(),
            'image' => $imageName,
        ];
    }
}