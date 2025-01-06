<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Comment;

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

        Comment::factory(10)->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'item_id' => Item::inRandomOrder()->first()->id
        ]);
        Payment::factory(10)->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'item_id' => Item::inRandomOrder()->first()->id
        ]);
        User::factory(10)->create();
    }
}
