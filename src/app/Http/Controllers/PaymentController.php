<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Purchase;

class PaymentController extends Controller
{
    public function create(Request $request, $itemId) {
        $item = Item::find($itemId);
        if (!$item) {
            return redirect()->back()->withErrors(['item' => '商品見つかりませんでした。']);
        }

        if ($item->status === 'soldout') {
            return redirect()->back()->withErrors(['status' => 'この商品は売り切れです']);
        }

        $user = auth()->user();
        $paymentMethod = $request->input('credit_card', 'convenience_store');
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'payment_method' => $paymentMethod,
            'comments_count' => $item->comments()->count(),
        ]);

        if ($paymentMethod === 'convenience_store') {
            return view('create',compact('item', 'user', 'purchase'))->with('success','購入が完了しました');
        }

        return view('create', compact('item', 'user', 'purchase'));
    }

    public function store(Request $request) {
        $itemId = $request->input('item_id');
        $item = Item::find($itemId);

        if ($item->status === 1) {
            return back()->withErrors(['status' => 'この予約は既に支払いが完了しています']);
        }

        Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            $charge = \Stripe\Charge::create([
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
        }
    catch (\Stripe\Exception\CardException $e) {
        return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
