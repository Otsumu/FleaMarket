<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirmMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserController extends Controller
{
    public function index() {
        return view('user.register');
    }

    public function store(RegisterRequest $request) {
        $validatedData = $request->validate($request->rules(), $request->messages());
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        auth()->login($user);
        event(new Registered($user));

        Mail::to($user->email)->send(new RegisterConfirmMail($user));

        return redirect()->route('user.editProfile');
    }

    public function edit() {
        return view('user.editProfile');
    }

    public function update(AddressRequest $addressRequest, ProfileRequest $profileRequest) {
        $validatedData = $addressRequest->validated();
        $profileValidatedData = $profileRequest->validated();

        $user = auth()->user();

        if ($profileRequest->hasFile('image')) {
            $imagePath = $profileRequest->file('image')->store('images', 'public');
            session()->flash('image', $imagePath);
        }

        $user ->update([
            'name' => $validatedData['name'],
            'postcode' => $validatedData['postcode'],
            'address' => $validatedData['address'],
            'build' => $validatedData['build'],
        ]);

        return redirect()->route('user.myPage')->with('success', 'プロフィールが更新されました');
    }

    public function saveImage(ProfileRequest $request) {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            session(['image' => $imagePath]);
            $user = auth()->user();
            $user->image = $imagePath;
            $user->save();
        }

        return response()->json(['success' => true]);
    }

    public function showChangeAddress() {
        return view('user.changeAddress');
    }

    public function updateAddress(PurchaseRequest $request) {
        $validatedData = $request->validated();

        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
            'payment_method' => $validatedData['payment_method'],
            'postcode' => $validatedData['postcode'],
            'address' => $validatedData['address'],
            'build' => $validatedData['build'],
        ]);

        return redirect()->route('user.myPage')->with('success', '住所変更しました！');
    }

    public function myPage() {
        $user = auth()->user();
        $items = Item::where('user_id', $user->id)->get();
        $purchasedItems = Purchase::where('user_id', $user->id)
            ->with('item')->get();

        return view('user.myPage',compact('user','items','purchasedItems'));
    }
}
