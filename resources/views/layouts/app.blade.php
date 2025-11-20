<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Brush Edit</title>

    @vite(['resources/css/reset.css']) <!-- リセットCSS -->
    @vite(['resources/css/directory.css']) <!-- ユーザーホーム画面 -->
    @vite(['resources/css/profile.css']) <!-- アカウント管理画面 -->
    @vite(['resources/css/modal.css']) <!-- モーダル -->
    @vite(['resources/css/pagination.css']) <!-- ページネーション -->

    @vite(['resources/js/app.js'])
</head>

<body>
    <!-- 共通ヘッダーコンポーネント -->
    <x-header />

    <!-- メインコンテンツ -->
    @yield('content')
</body>

</html>