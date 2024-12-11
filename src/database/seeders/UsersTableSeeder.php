<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run() {
        $faker = Faker::create('ja_JP');
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'address' => $faker->address(),
                'build' => $faker->buildingNumber(),
                'postcode' => $faker->postcode(),
            ]);
        }
    }
}


