<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>入力画面 - Blush Edit</title>

  @vite(['resources/css/reset.css']) <!--リセットCSS -->
  @vite(['resources/css/base.css']) <!--共通CSS のちほどまとめて継承 -->
  @vite(['resources/css/create.css']) <!--このページのみのCSS -->

  @vite(['resources/js/create.js']) <!-- 入力・編集ページのみのJS -->
  @vite(['resources/js/autosave.js']) <!-- 自動保存 -->
  @vite(['resources/js/tags-input.js']) <!-- タグ追加 -->

  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
  <header>
    <nav class="nav-items">
      <a class="return-button" href="{{ route('document.index') }}">←</a>
      <div class="right-nav">
        <div class="darkmode">
          <img class="mode" src="{{ asset('img/sun.png') }}">
          <div class="dark-switch">
            <input type="checkbox" id="darkSwitch">
            <label for="darkSwitch"><span></span></label>
            <div id="swImg"></div>
          </div>
          <img class="mode" src="{{ asset('img/moon.png') }}">
        </div>
        <div>
          <label>タグ（カンマ区切り）</label>
          <input type="text" name="tags" class="form-control" placeholder="例: 仕事, 重要, 2025">
        </div>
        <button class="preview">
          <a href="#">preview</a>
        </button>
      </div>
    </nav>
  </header>

  <div class="create">
    <input class="title" type="text" name="title" value="{{ $document->title ?? '' }}" placeholder="タイトルを入力">
    <textarea class="content" name="content" data-document-id="{{ $document->id ?? 'temp' }}"
      placeholder="ここに文章を入力してください">{{ $document->content ?? '' }}</textarea>
    <div id="notification" class="notification"></div>
  </div>
  <div id="char-count"></div>

  <script>
    window.userId = "{{ auth()->id() }}";
    window.documentId = '{{ $documentId ?? "temp" }}';
  </script>

</body>

</html>