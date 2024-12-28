<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Item;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function create($id) {
        $item = Item::findOrFail($id);
        return view('create', compact('item'));
    }

    public function store(Request $request) {
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);

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

            $item->status = 'soldout';
            $item->save();

            return redirect()->route('item.detail', $item->id)->with('status', '決済が完了しました！');
        } catch (\Stripe\Exception\CardException $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
