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
        <div class="item__index">
            <a class="recommend" href="#" id="recommend-tab">おすすめ</a>
            <a class="myList" href="#" id="mylist-tab">マイリスト</a>
        </div>
        <div class="item__list">
            @foreach($items as $item)
                <div class="shop__item">
                    <div class="item__image">
                        <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                        <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="item__img">
                        </a>
                        @if($item->status == 'soldout')
                            <span class="soldout-label">SOLD OUT</span>
                        @endif
                    </div>
                    <div class="item__content">
                        <h2>{{ $item->name }}</h2>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination-container" id="pagination-container">
            {{ $items->links() }}
        </div>
    </div>
@endsection

@section('js')
    <script>
        const itemDetailPath = "{{ route('item.detail', ['item_id' => ':id']) }}";

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            const mylistTab = document.getElementById('mylist-tab');
            const recommendTab = document.getElementById('recommend-tab');
            const itemList = document.querySelector('.item__list');
            const paginationContainer = document.getElementById('pagination-container');

            async function showFavoriteItems() {
                try {
                    console.log('Fetching favorites...');
                    paginationContainer.style.display = 'none';
                    const searchQuery = new URLSearchParams(window.location.search).get('query');
                    console.log('Search query:', searchQuery);

                    const url = '/item/favorites' + (searchQuery ? `?query=${searchQuery}` : '');
                    console.log('Fetching URL:', url);
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
            });

                    if (!response.ok) {
                        if (response.status === 401) {
                            console.warn('Unauthorized access');
                            itemList.innerHTML = '<div class="error" style="font-size: 20px; font-weight: bold;">ログインが必要です</div>';
                            return;
                        }

                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    console.log('Response received');
                    const data = await response.json();
                    console.log('Favorites data:', data);

                    if (!data.items || data.items.length === 0) {
                        itemList.innerHTML = '<div class="no-items" style="font-size: 20px; font-weight: bold;">お気に入りに登録された商品はありません</div>';
                        return;
                    }

                    itemList.innerHTML = data.items.map(item => `
                        <div class="shop__item">
                            <div class="item__image">
                                <a href="${itemDetailPath.replace(':id', item.id)}">
                                    <img src="${item.img_url.startsWith('http') ? item.img_url : '/storage/' + item.img_url}"
                                        alt="${item.name}"
                                        class="item__img">
                                </a>
                                ${item.status === 'soldout' ? '<span class="soldout-label">SOLD OUT</span>' : ''}
                            </div>
                            <div class="item__content">
                                <h2>${item.name}</h2>
                            </div>
                        </div>
                    `).join('');
                } catch (error) {
                    console.error('Fetch error:', error);
                    itemList.innerHTML = '<div class="error" style="font-size: 20px; font-weight: bold;">データの取得に失敗しました</div>';
                }
            }

            if (mylistTab) {
                mylistTab.onclick = function(e) {
                    console.log('Mylist clicked');
                    e.preventDefault();
                    showFavoriteItems();
                    paginationContainer.style.display = 'none';
                };
            }

            if (recommendTab) {
                recommendTab.onclick = function(e) {
                    e.preventDefault();
                    paginationContainer.style.display = 'none';
                };
            }
        });
    </script>
@endsection