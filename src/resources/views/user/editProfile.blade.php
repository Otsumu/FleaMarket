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
    <form class="auth-form" action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
            <h2 class="auth-title">プロフィール設定</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="image-group">
                <div class="image-container">
                    <img id="profileImagePreview" src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/images/default.jpg') }}" 
                        alt="Profile Image" class="profile-image">
                </div>
                <input type="file" name="image" accept="image/*" style="display: none;" id="imageInput">
                <button type="button" class="select-image-button" onclick="document.getElementById('imageInput').click();">画像を選択する</button>
            </div>

            <div class="auth-item">
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
                        <input type="text" id="name" name="name" placeholder="Username" value="{{ old('name', auth()->user()->name) }}">
                    </div>
                </div>

                <div class="input-group">
                    <div style="display: flex; align-items: center;">
                        <h3 class="title" style="margin: 0;">郵便番号</h3>
                            <p class="auth-form__error-message">
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
                            <p class="auth-form__error-message">
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
                            <p class="auth-form__error-message">
                                @error('build')
                                    {{ $message }}
                                @enderror
                            </p>
                    </div>
                    <div class="input-tag">
                        <input type="text" id="build" name="build" placeholder="build" value="{{ old('build', auth()->user()->build) }}">
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

@section('js')
    <script src="{{ asset('js/image_preview.js') }}"></script>
@endsection