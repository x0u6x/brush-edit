<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレビュー</title>

    @vite(['resources/css/reset.css']) <!--リセットCSS -->
    @vite(['resources/css/preview.css']) <!--このページのみのCSS -->

    @vite(['resources/js/preview.js'])
</head>

<body>

    <!-- オプション -->

    <div class="sidebar">
        <button class="toggle-button">▶︎</button>
        <ul class="menu">
            <li>
                <label><input type="radio" name="direction" value="horizontal" checked> 横書き</label>
                <label><input type="radio" name="direction" value="vertical"> 縦書き</label>
            </li>
            <li>
                <label for="back-color">背景色</label>
                <input type="color" id="back-color" value="#ffffff">
            </li>
            <li>
                <label for="font-color">文字色</label>
                <input type="color" id="font-color" value="#000000">

            </li>
            <li>
                <label for="font-size">フォントサイズ:</label>
                <input type="number" id="font-size" min="12" max="24" value="16">
            </li>
            <li>
                <select class="font-family">
                    <option value="Gothic" selected>ゴシック体</option>
                    <option value="Mincho">明朝体</option>
                </select>
            </li>
        </ul>
    </div>


    <!-- 本文 -->
    <div class="main-text">
        <main>
            <h1>{{ $document->title ?: '' }}</h1>
            <p>{!! nl2br(e($document->content)) !!}</p>
        </main>
    </div>

</body>

</html>