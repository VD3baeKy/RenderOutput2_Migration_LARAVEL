<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SAMURAI Travel 管理')</title>
    @stack('styles')
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>

