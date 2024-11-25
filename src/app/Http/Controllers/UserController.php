<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirmMail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        return view('user.register');
    }

    public function store(RegisterRequest $request) {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        auth()->login($user);
        event(new Registered($user));
        $request->session()->forget('register_data');

        Mail::to($user->email)->send(new RegisterConfirmMail($user));

        return redirect()->route('user.editProfile');
    }

    public function update(AddressRequest $request) {
        $validatedData = $request->validated();
        $user = auth()->user();
        $user ->update([
            'name' => $validatedData['name'],
            'postcode' => $validatedData['postcode'],
            'address' => $validatedData['address'],
            'build' => $validatedData['build'] ?? '',
        ]);

        return redirect()->route('item.index')->with('success', 'プロフィールが更新されました');
    }

    public function saveImage(ProfileRequest $request) {
        $image = $request->file('image');
        $imagePath = $image->store('images', 'public');
        $user = auth()->user();
        $user->image = $imagePath;
        $user->save();

        return redirect()->back()->with('success', '画像が保存されました。');
    }

    public function edit() {
        return view('user.editProfile');
    }

    public function myPage() {
        return view('user.myPage');
    }
}
