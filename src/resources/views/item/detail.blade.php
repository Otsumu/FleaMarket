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
        <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}" class="product__img">
            @if($item->status == 'soldout')
                <span class="soldout-label">SOLD OUT</span>
            @endif
    </div>

    <div class="right">
    @if(session('success'))
        <div class="alert alert-success" style="margin-top: 10px; font-size: 14px; color: green;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-top: 10px; font-size: 14px; color: red;">
            {{ session('error') }}
        </div>
    @endif
        <div class="first-info">
            <h2><strong>{{ $item->name }}</strong></h2>
            <p>ブランド名 {{ $item->brand }}</p>
            <h3>¥{{ number_format($item->price) }} (税込)</h3>
            <div class="info-container">
                <p id="favoriteButton" class="clickable" data-item-id="{{ $item->id }}">
                    <i class="fa-regular fa-star"></i>
                </p>
                <span id="favoriteCount">{{ $item->favorites()->count() }}</span>
                <p id="commentButton" class="clickable"><i class="fa-regular fa-comment"></i></p>
                <span id="commentCount">{{ $commentsCount }}</span>
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
            <p>カテゴリー :
                @foreach(explode(',', $item->category) as $category)
                    <span class="category-box">{{ $category }}</span>
                @endforeach
            </p>
            <p>商品の状態 : <span style="margin-left: 15px">{{ $item->condition }}</span></p>
        </div>
        <div class="comment-info">
            <h3><strong>コメント ({{ $commentsCount }}) </strong></h3>
            @foreach ($comments as $comment)
                <div class="profile-wrapper">
                    <img id="profileImagePreview"
                    src="{{ url('storage/' . $comment->user->image) }}" class="profile-image">
                    <h4 class="profile-name">{{ $comment->user->name }}</h4>
                </div>
            <textarea>{{ $comment->content }}</textarea>
            @endforeach
            <h4 class="comment"><strong>商品へのコメント</strong></h4>
            <form action="{{ route('comments.store', $item->id) }}" method="POST">
                @csrf
                @if($errors->has('content'))
                    <div class="error" style="margin-top: 5px; font-size: 14px; color: red;">
                        <p>{{ $errors->first('content') }}</p>
                    </div>
                @endif
                <textarea id="commentInput" rows="10" name="content" class="comment-comment" placeholder="コメントを入力"></textarea>
                <button type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/detail.js') }}"></script>
@endsection