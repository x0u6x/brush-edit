<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Brush Edit</title>

    @vite(['resources/css/reset.css']) <!--リセットCSS -->
    @vite(['resources/css/base.css']) <!--共通CSS のちほどまとめて継承 -->
    @vite(['resources/css/directory.css']) <!--このページのみのCSS -->
    @vite(['resources/css/pagination.css']) <!--ページネーション -->

    @vite(['resources/js/directory.js'])
</head>

<body>
    <!-- 共通ヘッダーコンポーネント -->
    <x-header />

    <!-- メインコンテンツ -->
    @yield('content')
</body>

</html>