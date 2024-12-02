<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create('ja_JP');

        $this->call(UsersTableSeeder::class);
        $this->call(ItemsTableSeeder::class);

        \App\Models\User::factory(10)->create();
    }
}
