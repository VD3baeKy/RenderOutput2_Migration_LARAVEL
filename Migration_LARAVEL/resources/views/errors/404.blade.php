<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    {{-- 5秒後にトップページにリダイレクト --}}
    <meta http-equiv="refresh" content="5;URL={{ url('/') }}">
    <title>404 Not Found</title>
</head>
<body>
    <h1>404 Not Found</h1>
    <p>5秒後にトップページへ自動的に戻ります。</p>
</body>
</html>
