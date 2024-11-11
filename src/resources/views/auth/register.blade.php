@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('auth.register') }}" method="post">
        @csrf
        <div class="auth-item">
            <h2 class="auth-title">会員登録</h2>

            <div class="input-group">
                <div style="display: flex; align-items: center;">
                    <h3 class="title" style="margin: 0;">ユーザー名</h3>
                    <p class="auth-form__error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="input-tag">
                    <input type="text" id="name" name="name" placeholder="Username" value="{{ old('name', session('register_data.name')) }}">
                </div>
            </div>

            <div class="input-group">
                <div style="display: flex; align-items: center;">
                    <h3 class="title" style="margin: 0;">メールアドレス</h3>
                    <p class="auth-form__error-message">
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
                    <p class="auth-form__error-message">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="input-tag">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
            </div>

            <div class="input-group">
                <div style="display: flex; align-items: center;">
                    <h3 class="title" style="margin: 0;">確認パスワード</h3>
                    <p class="auth-form__error-message">
                        @error('password_confirmation')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="input-tag">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                </div>
            </div>

            <div class="btn-actions">
                <div class="register-btn">
                    <button type="submit">登録する</button>
                </div>
                <div class="login-link">
                    <a href="{{ route('auth.login') }}">ログインはこちら</a>
                </div>
            </div>

        </div>
    </form>
</main>
@endsection