<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition() {
        $faker = \Faker\Factory::create('ja_JP');

        $dummyImages = [
            'images/dummy1.jpg',
            'images/dummy2.jpg',
            'images/dummy3.jpg',
            'images/dummy4.jpg',
            'images/dummy5.jpg',
            'images/default.jpg'
        ];

        return [
            'name' => $this->faker->lastName() . ' ' . $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'address' => $this->faker->address(),
            'image' => $this->faker->randomElement($dummyImages),
        ];
    }
}