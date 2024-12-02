@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('auth.login') }}" method="post">
        @csrf
        <div class="auth-item">
            <h2 class="auth-title">ログイン</h2>

            <div class="input-group">
                <div style="display: flex; align-items: center;">
                    <h3 class="title" style="margin: 0;">メールアドレス</h3>
                    <p class="auth-form__error-message" style="margin-top: 10px;">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="input-tag">
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email', session('register_data.email')) }}">
                </div>
            </div>

            <div class="input-group">
                <div style="display: flex; align-items: center;">
                    <h3 class="title" style="margin: 0;">パスワード</h3>
                    <p class="auth-form__error-message" style="margin-top: 10px;">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="input-tag">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
            </div>

            <div class="btn-actions">
                <div class="register-btn">
                    <button type="submit">ログインする</button>
                </div>
                <div class="login-link">
                    <a href="{{ route('register') }}">会員登録はこちら</a>
                </div>
            </div>

        </div>
    </form>
</main>
@endsection