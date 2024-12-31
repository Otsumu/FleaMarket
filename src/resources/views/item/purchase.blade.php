@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="first-wrapper">
            <img src="{{ Str::startsWith($item->img_url, 'http') ? $item->img_url : asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}" class="product-image">
            <div class="text-container">
                <h3>{{ $item->name }}</h3>
                <h3>¥{{ number_format($item->price) }}</h3>
            </div>
        </div>
        <div class="second-wrapper">
            <h3>支払い方法</h3>
            <div class="second-wrapper-tag" style="padding-left: 40px">
                <select class="payment_method" name="payment_method" id="paymentMethod" style="width: 40%; height: 40px; margin-left: 30px;" required>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>カード支払い</option>
                    <option value="convenience_store" {{ old('payment_method') == 'convenience_store' ? 'selected' : '' }}>コンビニ支払い</option>
                </select>
            </div>
        </div>
        <div class="third-wrapper">
            <div class="header-row">
                <h3>配送先</h3>
                <a href="{{ route('user.changeAddress', $item->id) }}">変更する</a>
            </div>
            <div class="third-wrapper-tag" style="padding-left: 40px;">
                <p>〒{{ $user->postcode }}</p>
                <p>{{ $user->address }} &nbsp; {{ $user->build }}</p>
            </div>
        </div>
    </div>

    <div class="right">
    @if ($item->status === 'soldout')
        <p class="text-danger" style=" margin-top: 50%; font-size:30px; font-weight: bold;">この商品は売り切れです</p>
    @else
    <form id="purchaseForm" action="{{ route('item.purchase.post', $item->id) }}" method="POST">
        @csrf
            <table class="payment_method-check">
                <tr>
                    <td>商品代金</td>
                    <td>¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <td>支払い方法</td>
                    <td class="payment-method-display">選択してください</td>
                </tr>
            </table>
            <button class="btn btn_buy" type="submit">購入する</button>
        </form>
    @endif
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemId = {{ $item->id }};
        
        // 支払い方法選択時の表示変更とボタンの有効化・無効化
        document.getElementById('paymentMethod').addEventListener('change', function() {
            var selectedPaymentMethod = this.value;
            var paymentMethodDisplay = document.querySelector('.payment-method-display');
            var purchaseButton = document.getElementById('purchaseButton');  // 購入ボタン

            // 支払い方法に応じた表示変更
            if (selectedPaymentMethod === 'credit_card') {
                paymentMethodDisplay.textContent = 'カード支払い';
                if (purchaseButton) {
                    purchaseButton.disabled = false;  // 購入ボタンを有効にする
                }
            } else if (selectedPaymentMethod === 'convenience_store') {
                paymentMethodDisplay.textContent = 'コンビニ支払い';
                if (purchaseButton) {
                    purchaseButton.disabled = false;  // 購入ボタンを有効にする
                }
            } else {
                paymentMethodDisplay.textContent = '選択してください';
                if (purchaseButton) {
                    purchaseButton.disabled = true;  // 購入ボタンを無効にする
                }
            }
        });

        // フォーム送信時の処理
        document.getElementById('purchaseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const paymentMethod = document.getElementById('paymentMethod').value;
            const form = this;

            // 支払い方法がカードの場合
            if (paymentMethod === 'credit_card') {
                window.location.href = `/items/${itemId}/create`;  // カード決済の処理
            } else {
                // コンビニ支払いの場合
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(new FormData(form))
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();  // レスポンスをJSONとして解析
                    } else {
                        throw new Error('購入処理が失敗しました');
                    }
                })
                .then(data => {
                    // サーバーからリダイレクトURLが返されている場合
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;  // リダイレクトURLに遷移
                    } else {
                        console.error('リダイレクトURLが見つかりません');
                    }
                })
                .catch(error => {
                    console.error('購入処理でエラーが発生しました:', error);
                    alert('購入処理中にエラーが発生しました。再度お試しください。');
                });
            }
        });
    });
</script>
@endsection