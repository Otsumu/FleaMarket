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
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const displayElement = document.querySelector('.payment-method-display');

    if (paymentMethodSelect) {
        paymentMethodSelect.addEventListener('change', function() {
            const selectedMethod = this.value;
            if (displayElement) {
                if (selectedMethod === 'credit_card') {
                    displayElement.textContent = 'カード支払い';
                } else if (selectedMethod === 'convenience_store') {
                    displayElement.textContent = 'コンビニ支払い';
                }
            }
        });
    }

    const itemId = {{ $item->id }};

    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const paymentMethod = document.getElementById('paymentMethod').value;

    if (paymentMethod === 'credit_card') {
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = `/item/${itemId}/create`;

        document.body.appendChild(form);
        form.submit();
    } else if (paymentMethod === 'convenience_store') {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/item/${itemId}/purchase`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);

        const paymentMethodInput = document.createElement('input');
        paymentMethodInput.type = 'hidden';
        paymentMethodInput.name = 'payment_method';
        paymentMethodInput.value = paymentMethod;
        form.appendChild(paymentMethodInput);

        document.body.appendChild(form);
        form.submit();
    }
    });
});
</script>
@endsection