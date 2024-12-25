<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CreatesNewUsers::class, CreateNewUser::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        config(['fortify.home' => '/']);

        config(['fortify.redirects.email-verification' => '/user/editProfile']);

        Fortify::verifyEmailView(function () {
            $user = Auth::user();

            if ($user && $user->email_verified_at) {
                return redirect('/item.index');
            }

            return view('user.editProfile', ['user' => $user]);
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new CustomVerifyEmail($url))->toMail($notifiable);
        });

        Fortify::authenticateUsing(function (Request $request) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return Auth::user();
            }

            if (!Auth::validate($credentials)) {
                Session::flash('error', 'ログイン情報が登録されていません');
            }

            return null;
        });
    }
}

