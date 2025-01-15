<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition() {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
        ];
    }
}
