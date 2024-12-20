<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->faker = Faker::create('ja_JP');
        $user = User::inRandomOrder()->first();
        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'name' => '腕時計',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'category' => 'ファッション',
            'condition' => '良好',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'name' => 'HDD',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'category' => '電子機器',
            'condition' => '目立った傷や汚れなし',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'name' => '玉ねぎ3束',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束のセット',
            'category' => '家庭用品',
            'condition' => 'やや傷や汚れあり',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'category' => 'ファッション',
            'condition' => '状態が悪い',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'category' => '電子機器',
            'condition' => '良好',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'name' => 'マイク',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'category' => '電子機器',
            'condition' => '目立った傷や汚れなし',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'category' => 'ファッション',
            'condition' => 'やや傷や汚れあり',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'name' => 'タンブラー',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'category' => '家庭用品',
            'condition' => '状態が悪い',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'name' => 'コーヒーミル',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'category' => '家庭用品',
            'condition' => '良好',
            'status' => 'available',
        ]);

        Item::create([
            'user_id' => $user->id,
            'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'category' => '美容健康',
            'condition' => '目立った傷や汚れなし',
            'status' => 'available',
        ]);
    }
}
