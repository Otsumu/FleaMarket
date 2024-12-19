<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認メール</title>
</head>
<body>
    <h1>ご登録ありがとうございます！</h1>
    <p>{{ $user->name }} 様、以下のリンクをクリックしてアカウントを確認してください。</p>
    <p>
        <a href="{{ $verificationUrl }}">アカウントを確認</a>
    </p>
</body>
</html>