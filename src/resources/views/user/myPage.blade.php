@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/myPage.css') }}">
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
        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="profile-wrapper">
            <img id="profileImagePreview"
            src="{{ url('storage/' . $user->image) }}" class="profile-image">
            <h4 class="profile-name">{{ $user->name }}</h4>
            <a href="{{ route('user.editProfile')}}" class="profile-edit-btn">プロフィールを編集</a>
        </div>
        <div class="item__index">
            <a class="sell" href="javascript:void(0);" onclick="showItems('sell')">出品した商品</a>
            <a class="purchase" href="javascript:void(0);" onclick="showItems('purchase')">購入した商品</a>
        </div>

        <div class="item__list" id="itemList">
            <div class="items sell-items" id="sell-items">
            @if($items -> isEmpty())
                <p style="font-size: 20px; font-weight: bold; padding: 10px; margin-top: 5%;">出品した商品はありません</p>
            @else
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
            @endif
            </div>

            <div class="items purchase-items" id="purchase-items" style="display: none;">
            @if($purchasedItems -> isEmpty())
                <p style="font-size: 20px; font-weight: bold; margin-top: 5%;">購入した商品はありません</p>
            @else
                @foreach($purchasedItems as $purchase)
                    <div class="shop__item">
                        <div class="item__image">
                            <a href="{{ route('item.detail', ['item_id' => $purchase->item->id]) }}">
                                <img src="{{ $purchase->item->img_url }}" alt="{{ $purchase->item->name }}" class="item__img">
                            </a>
                        </div>
                        <div class="item__content">
                            <h2>{{ $purchase->item->name }}</h2>
                        </div>
                    </div>
                @endforeach
            @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/myPage.js') }}"></script>
@endsection