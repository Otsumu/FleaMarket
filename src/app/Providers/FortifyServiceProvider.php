<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Cache;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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

        Fortify::redirects('register', '/user/editProfile');

        $limiter = app(RateLimiter::class);

        $limiter->for('login', function (Request $request) {
            return Limit::perMinute(10);
        });

    //    Fortify::verifyEmailView(function () {
    //       $user = Auth::user();
    //        return view('emails.register_confirm', ['user' => $user]);
    //    });

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
