<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認メール</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f7fc;
            color: #333;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 500px;
            position: relative;
            height: 40vh;
        }

        .logo {
            width: 150px;
            margin-bottom: 10px;
        }

        .account-link {
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 50px;
            border-radius: 5px;
            font-weight: bold;
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .account-link:hover {
            background-color: #0056b3;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <a href="{{ route('item.index') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </a>

        <h1>ご登録ありがとうございます</h1>
        <p><span class="highlight">{{ $user->name }}</span> 様、下記URLをクリックし登録を完了してください</p>
        <p><a class="account-link" href="{{ url('/user/editProfile') }}">アカウントを確認</a></p>
    </div>

</body>
</html>