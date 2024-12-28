<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Item;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(Request $request) {
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);

        if ($item->status === 'soldout') {
            return back()->withErrors(['status' => 'この商品は売り切れました']);
        }

        Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            $charge = Charge::create([
                'source' => $request->stripeToken,
                'amount' => $item->price,
                'currency' => 'jpy',
            ]);

            Payment::create([
                'user_id' => auth()->id(),
                'payment_id' => $charge->id,
                'amount' => $charge->amount,
                'currency' => $charge->currency,
                'status' => $charge->status,
            ]);

            $item->payment_status = 1;
            $item->save();

            return back()->with('status', '決済が完了しました！');
        } catch (\Stripe\Exception\CardException $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
