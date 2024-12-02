<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');

        return [
            'name' => $this->faker->lastName() . ' ' . $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'address' => $this->faker->address(),
        ];
    }
}