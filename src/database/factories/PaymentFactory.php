<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'amount' => $this->faker->numberBetween(100, 50000),
            'currency' => 'jpy',
            'status' => 'succeeded',
            'stripe_payment_id' => 'pi_' . $this->faker->regexify('[A-Za-z0-9]{24}'),
        ];
    }
}