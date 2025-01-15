<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FleaMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    @yield('css')
</head>
<body>
    <header>
        <div class= header>
            <div class="header__left">
                <div class="header__logo">
                    <a href="{{ route('item.index') }}">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="header__center">
                @yield('header__center')
            </div>
            <div class="header__right">
                @yield('header__right')
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
    @yield('js')
</body>
</html>