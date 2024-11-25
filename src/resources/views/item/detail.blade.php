@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">ログアウト</button>
            </form>
        </li>
        <li><a href="{{ route('user.myPage') }}">マイページ</a></li>
        <li><a href="{{ route('item.sell') }}" class="sell-button">出品</a></li>
    </ul>
</nav>
@endsection

@section('content')
<div class="container">
    <div class="left">
        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="product-image">
    </div>
    <div class="right">
        <div class="first-info">
            <h2><strong>{{ $item->name }}</strong></h2>
            <p>ブランド名 {{ $item->brand }}</p>
            <h3>¥{{ $item->price}} (税込)</h3>
            <div class="info-container">
                <p id="favoriteButton" class="clickable"><i class="fa-regular fa-star"></i></p>
                <span id="favoriteCount">{{ $item->favorite_count }}</span>
                <p id="commentButton" class="clickable"><i class="fa-regular fa-comment"></i></p>
                <span id="commentCount">{{ $item->comment_count }}</span>
            </div>
            <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}" class="buy buy-button">購入手続きへ</a>
        </div>
        <div class="second-info">
            <h3><strong>商品説明</strong></h3>
            <p>カラー : グレー</p>
            <p>新品<br>
            商品の状態は状態は良好です、傷もありません。</p><br>
            <p>購入後、即発送します。</p>
            <h3 class="second"><strong>商品の情報</strong></h3>
            <p>カテゴリー : {{ $item ->category }}</p>
            <p>商品の状態 : {{ $item ->condition }}</p>
        </div>
        <div class="comment-info">
            <h3><strong>コメント ({{ $commentsCount }}) </strong></h3>
            <div class="profile-wrapper">
                <img id="profileImagePreview" src="{{ $userImage }}" alt="Profile Image" class="profile-image">
                <h4 class="profile-name">{{ $userName }}</h4>
            </div>
            @foreach ($reviews as $review)
                <p>{{ $review->content }} - {{ $review->user->name }}</p>
            @endforeach
            <textarea id="commentInput" rows="5">
                @if($reviews->isNotEmpty())
                    {{ $reviews->first()->content }}
                @else
                    コメントがありません。
                @endif
            </textarea>
            <h4 class="comment"><strong>商品へのコメント</strong></h4>
            <textarea id="commentInput" rows="10" class="comment-comment" placeholder="コメントを入力"></textarea>
            <button onclick="postComment()">コメントを送信する</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/detail.js') }}"></script>
@endsection