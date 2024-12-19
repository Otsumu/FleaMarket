@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('header__center')
<form action="{{ route('search') }}" method="GET" class="header-search-form">
    <input type="text" name="query" placeholder="なにをお探しですか？" class="header-search-input">
</form>
@endsection

@section('header__right')
<nav class="header-nav">
    <ul class="nav-list">
        <li>
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}">ログイン</a>
            @endif
        </li>
        <li><a href="{{ route('user.myPage') }}">マイページ</a></li>
        <li><a href="{{ route('item.sell') }}" class="sell-button">出品</a></li>
    </ul>
</nav>
@endsection

@section('content')
    <div class="homepage">
    <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="first-content">
            <h2 class="first-title" style="font-weight: bold; margin: 60px auto;">商品の出品</h2>
            <h4 style="font-size: 26px; color: rgb(99, 98, 98);">商品画像</h4>
            <div class="file-upload" id="file-upload">
                <input type="file" name="img_url" id="image" style="display: none;" accept="image/*">
                <p class="file-select">商品画像を選択する</p>
                <div id="image-preview" style="margin-top: 10px; display: none;">
                    <img id="preview-image" src="#" alt="Selected Image">
                </div>
                @error('img_url')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            @if(isset($item) && $item->img_url&& Storage::disk('public')->exists($item->img_url))
                <img src="{{ asset('storage/' . $item->img_url) }}">
            @endif
        </div>

        <div class="second-content">
            <h2 class="item-detail">商品の詳細</h2>
            <h4 class="selected-category">カテゴリー</h4>
            <ul class="category-options" id="categoryOptions">
                <button data-value="fashion">ファッション</button>
                <button data-value="electronics">家電</button>
                <button data-value="interior">インテリア</button>
                <button data-value="redies">レディース</button>
                <button data-value="mens">メンズ</button>
                <button data-value="cosme">コスメ</button>
                <button data-value="book">本</button>
                <button data-value="game">ゲーム</button>
                <button data-value="sports">スポーツ</button>
                <button data-value="kitchen">キッチン</button>
                <button data-value="handmade">ハンドメイド</button>
                <button data-value="acccesary">アクセサリー</button>
                <button data-value="toy">おもちゃ</button>
                <button data-value="baby-kids">ベビー・キッズ</button>
            </ul>
            <input type="hidden" name="category" id="categoryInput" value="">
            @error('category')
                <div class="error">{{ $message }}</div>
            @enderror
            <div class="select-box select-box-sort">
                <label class="select-box-label">商品の状態</label>
                <select name="condition" class="select-box">
                    <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>良好</option>
                    <option value="not bad" {{ old('condition') == 'not bad' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                    <option value="bad" {{ old('condition') == 'bad' ? 'selected' : '' }}>やや傷や汚れあり</option>
                    <option value="too bad" {{ old('condition') == 'too bad' ? 'selected' : '' }}>状態が悪い</option>
                </select>
                @error('condition')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="third-content">
            <h2 class="item-title">商品名と説明</h2>
            <div class="item-container">
                <label for="name">商品名</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                <label for="description">商品の説明</label>
                    <textarea rows="5" id="description" name="description" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                <label for="price">販売価格</label>
                <div class="price-container">
                        <span class="currency-symbol">￥</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"required>
                </div>
                @error('price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit">出品する</button>
    </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/sell.js') }}"></script>
@endsection



