@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('header__center')
<form action="{{ route('search') }}" method="GET" class="header-search-form">
    <input type="text" name="query" placeholder="なにをお探しですか？" class="header-search-input">
</form>
@endsection

@section('header__right')
<nav class="header-nav">
    <ul class="nav-list">
        <li><a href="{{ route('logout') }}">ログアウト</a></li>
        <li><a href="{{ route('user.myPage') }}">マイページ</a></li>
        <li><a href="{{ route('item.sell') }}" class="sell-button">出品</a></li>
    </ul>
</nav>
@endsection

@section('content')
<main>
    <form class="auth-form" action="{{ route('user.updateAddress', ['item_id' => request()->segment(3)]) }}" method="POST">
        @csrf
        @method('patch')
        <input type="hidden" name="item_id" value="{{ $item_id ?? '' }}">
            <h2 class="auth-title" style="margin-top: 10px">住所の変更</h2>
            <div class="auth-item" style="gap: 30px;">
                <div class="input-group">
                    <div style="display: flex; align-items: center;">
                        <h3 class="title" style="margin: 0;">郵便番号</h3>
                            <p class="auth-form__error-message" style="margin-top: 10px;">
                                @error('postcode')
                                    {{ $message }}
                                @enderror
                            </p>
                    </div>
                    <div class="input-tag">
                        <input type="text" id="postcode" name="postcode" placeholder="Postcode" value="{{ old('postcode', auth()->user()->postcode) }}">
                    </div>
                </div>

                <div class="input-group">
                    <div style="display: flex; align-items: center;">
                        <h3 class="title" style="margin: 0;">住所</h3>
                            <p class="auth-form__error-message" style="margin-top: 10px;">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </p>
                    </div>
                    <div class="input-tag">
                        <input type="text" id="address" name="address" placeholder="Address" value="{{ old('address', auth()->user()->address) }}">
                    </div>
                </div>

                <div class="input-group">
                    <div style="display: flex; align-items: center;">
                        <h3 class="title" style="margin: 0;">建物名</h3>
                            <p class="auth-form__error-message" style="margin-top: 10px;">
                                @error('build')
                                    {{ $message }}
                                @enderror
                            </p>
                    </div>
                    <div class="input-tag">
                        <input type="text" id="build" name="build" placeholder="Build" value="{{ old('build', auth()->user()->build) }}">
                    </div>
                </div>

                <div class="btn-actions">
                    <div class="register-btn">
                        <button type="submit">更新する</button>
                    </div>
                </div>
            </div>
    </form>
</main>
@endsection