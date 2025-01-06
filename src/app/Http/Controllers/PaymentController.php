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

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        try {
            $charge = Charge::create([
                'source' => $request->stripeToken,
                'amount' => $item->price,
                'currency' => 'jpy',
            ]);
            Payment::create([
                'user_id' => auth()->id(),
                'item_id' => $request->item_id,
                'amount' => $charge->amount,
                'currency' => $charge->currency,
                'status' => $charge->status,
                'stripe_payment_id' => $charge->id
            ]);

            $item->status = 'soldout';
            $item->save();

            return redirect()->route('item.detail', $item->id)->with('success', '決済が完了しました！');
        } catch (\Stripe\Exception\CardException $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
