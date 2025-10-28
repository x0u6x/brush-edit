<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集画面 - Blush Edit</title>

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
        <div class="tag-toggle-container">
          <!-- トグルボタン -->
          <span class="tag-toggle"># タグ</span>
          <span class="tag-count"></span>

          <!-- タグ入力小窓 -->
          <div class="tag-input-popup">
            <input name="tags" type="text" placeholder="#をつけてタグ名入力(複数可)">
            <div class="tag-pills"></div>
            <button class="add-tag-btn">追加</button>
          </div>
        </div>
        <button class="preview">
          <a href="{{ route('document.preview', $document->id) }}" target=”_blank”>preview</a>
        </button>
      </div>
    </nav>
  </header>

  <div class="create">
    <input class="title" type="text" name="title" placeholder="無題" value="{{ $document->title ?? '' }}">
    <textarea class="content" name="content" data-document-id="{{ $document->id ?? 'temp' }}">{{ $document->content ?? '' }}</textarea>
    <div id="notification" class="notification"></div>
  </div>
  <div id="char-count"></div>

  <script>
    window.userId = "{{ auth()->id() }}";
    window.documentId = "{{ $document->id }}";
  </script>

</body>

</html>