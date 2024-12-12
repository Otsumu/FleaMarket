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
    <form action="{{ route('item.index') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="first-content">
            <h2 class="first-title" style="font-weight: bold; margin: 60px auto;">商品の出品</h2>
            <h4 style="font-size: 26px; color: rgb(99, 98, 98);">商品画像</h4>
            <div class="file-upload" id="file-upload">
                <input type="file" name="image" id="image" style="display: none;" accept="image/*">
                <p class="file-select">商品画像を選択する</p>
                    <div id="image-preview" style="margin-top: 10px; display: none;">
                        <img id="preview-image" src="#" alt="Selected Image" style="max-width: 100%; height: auto;">
                    </div>
            </div>
        </div>

        <div class="second-content">
            <h2 class="item-detail">商品の詳細</h2>
            <h4 class="selected-category">カテゴリー</h4>
                <ul class="category-options" id="categoryOptions">
                    <li data-value="fashion">ファッション</li>
                    <li data-value="electronics">家電</li>
                    <li data-value="interior">インテリア</li>
                    <li data-value="redies">レディース</li>
                    <li data-value="mens">メンズ</li>
                    <li data-value="cosme">コスメ</li>
                    <li data-value="book">本</li>
                    <li data-value="game">ゲーム</li>
                    <li data-value="sports">スポーツ</li>
                    <li data-value="kitchen">キッチン</li>
                    <li data-value="handmade">ハンドメイド</li>
                    <li data-value="acccesary">アクセサリー</li>
                    <li data-value="toy">おもちゃ</li>
                    <li data-value="baby-kids">ベビー・キッズ</li>
                </ul>
            <input type="hidden" name="category" id="categoryInput" value="">
            <div class="select-box select-box-sort">
                <label class="select-box-label">商品の状態</label>
                <select name="sort" class="select-box" onchange="this.form.submit()">
                    <option value="good" {{ request('sort') == 'good' ? 'selected' : '' }}>良好</option>
                    <option value="not bad" {{ request('sort') == 'not bad' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                    <option value="bad" {{ request('sort') == 'bad' ? 'selected' : '' }}>やや傷や汚れあり</option>
                    <option value="too bad" {{ request('sort') == 'too bad' ? 'selected' : '' }}>状態が悪い</option>
                </select>
            </div>
        </div>

        <div class="third-content">
            <h2 class="item-title">商品名と説明</h2>
            <div class="item-container">
                <label for="productName">商品名</label>
                    <input type="text" id="productName" name="productName" required>
                <label for="productIntro">商品の説明</label>
                    <textarea rows="5" id="productIntro" name="productIntro" required></textarea>
                <label for="price">販売価格</label>
                <div class="price-container">
                        <span class="currency-symbol">￥</span>
                        <input type="number" id="price" name="price" required>
                </div>
            </div>
        </div>

        <button type="submit">出品する</button>
    </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/sell.js') }}"></script>
@endsection



