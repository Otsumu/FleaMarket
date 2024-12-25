<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('verification.notice');
    }

    public function edit() {
        return view('user.editProfile');
    }

    public function update(AddressRequest $addressRequest, ProfileRequest $profileRequest) {
        $addressData = $addressRequest->validated();
        $profileData = $profileRequest->validated();

        $user = auth()->user();

        if ($profileRequest->hasFile('image')) {
            $imagePath = $profileRequest->file('image')->store('images', 'public');
            session()->flash('image', $imagePath);
        }

        $user ->update([
            'name' => $user ->name,
            'postcode' => $addressData['postcode'],
            'address' => $addressData['address'],
            'build' => $addressData['build'],
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

    public function showChangeAddress($item_id) {
        return view('user.changeAddress', [
            'item_id' => $item_id
        ]);
    }

    public function updateAddress(AddressRequest $request, $item_id) {
        try {
            $validatedData = $request->validated();

            $user = auth()->user();
            $user->update([
                'postcode' => $validatedData['postcode'],
                'address' => $validatedData['address'],
                'build' => $validatedData['build']
            ]);

        return redirect()->route('item.purchase', ['item_id' => $item_id])
            ->with('success', '住所変更しました！');
        } catch (\Exception $e) {
        return back()->withErrors(['error' => '住所の更新に失敗しました。']);
        }
    }

    public function myPage() {
        $user = auth()->user();
        $items = Item::where('user_id', $user->id)->get();
        $purchasedItems = Purchase::where('user_id', $user->id)
            ->with('item')->get();

        return view('user.myPage',compact('user','items','purchasedItems'));
    }
}
