@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
                <a href="{{ route('user.login') }}">ログイン</a>
            @endif
        </li>
        <li><a href="{{ route('user.myPage') }}">マイページ</a></li>
        <li><a href="{{ route('item.sell') }}" class="sell-button">出品</a></li>
    </ul>
</nav>
@endsection

@section('content')
    <div class="homepage">
        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="item__index">
            <a class="recommend" href="#">おすすめ<p>
            <a class="myList" href="#">マイリスト</p>
        </div>
        <div class="item__list">
            @foreach($items as $item)
                <div class="shop__item">
                    <div class="item__image">
                        <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item__img">
                        </a>
                    </div>
                    <div class="item__content">
                        <h2>{{ $item->name }}</h2>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection