<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run() {
        User::create([
            'name' => '小池 百合子',
            'email' => 'yuriko@koike.com',
            'password' => bcrypt('password'),
            'address' => '東京都渋谷区神宮前1-1-1 1001',
        ]);

        $faker = Faker::create('ja_JP');
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'address' => $faker->address(),
            ]);
        }
    }
}


