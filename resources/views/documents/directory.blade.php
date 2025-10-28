<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brush Edit | 管理画面</title>

  @vite(['resources/css/reset.css']) <!--リセットCSS -->
  @vite(['resources/css/base.css']) <!--共通CSS のちほどまとめて継承 -->
  @vite(['resources/css/directory.css']) <!--このページのみのCSS -->
  @vite(['resources/css/pagination.css']) <!--ページネーション -->

  @vite(['resources/js/directory.js'])

</head>

<body>
  <header>
    <h1><a href="{{ route('document.index') }}">Brush Edit</a></h1>
    <nav class="right-nav">
      <a class="nav-link" href="{{ route('profile.edit') }}"><img class="nav-item" src="{{ asset('img/setting.png') }}" alt="設定"></a>
      <form method="POST" action="{{ route('logout') }}" id="logout-form">
        @csrf
        <button type="submit" class="nav-link"><img class="nav-item" src="{{ asset('img/logout.png') }}" alt="ログアウト"></button>
      </form>
    </nav>
  </header>


  <div class="container">
    <aside class="sidebar">
      <button class="new-create"><a href="{{ route('document.create') }}">＋ 新規作成</a></button>
      <form action="{{ route('document.index') }}" method="GET">
        <input type="text" class="search-input" name="search" placeholder="タイトルまたは本文で検索…" value="{{ request()->query('search') }}" />
        @if(request()->query('tag_id'))
        <input type="hidden" name="tag_id" value="{{ request()->query('tag_id') }}" />
        @endif
        <button type="submit" class="search-button">検索</button>
      </form>
      <div class="tag-area">
        <h3>使用中のタグ</h3>
        <div class="tag-list">
          @if($tags->isNotEmpty())
          @foreach ($tags as $tag)
          <span class="tag-pill {{ request()->query('tag_id') == $tag->id ? 'active' : '' }}" data-tag-id="{{ $tag->id }}">{{ $tag->name }}</span>
          @endforeach
          @else
          <p>タグがありません</p>
          @endif
        </div>
      </div>
    </aside>

    <main>

      @if($documents->isNotEmpty())
      @foreach ($documents as $document)
      <div class="logs">
        <div class="document">
          <p class="titles" data-tooltip="{{ Str::limit(strip_tags($document->content), 200, '...') }}">
            <a href="{{ route('document.edit', $document->id) }}">{{ $document->title }}</a>
          </p>
          <p class="tag">
            @foreach ($document->tags as $tag)
            <span class="pill">{{ $tag->name }}</span>
            @endforeach
          </p>
          <p class="updated-at">{{ $document->updated_at->format('Y-m-d h:i A') }}
            <span class="char-count">{{ mb_strlen(preg_replace('/[\r\n]+/', '', $document->content)) }}文字</span>
          </p>
        </div>
        <form action="{{ route('document.destroy', $document->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="delete-button" type="submit" onclick="return confirm('本当に削除しますか？')">
            <img class="nav-item" src="{{ asset('img/dustbox.png') }}" alt="削除">
          </button>
        </form>
      </div>
      @endforeach
      <div class="pagination">{{ $documents->links() }}</div>
      @else
      <div class="no-results">
        <p>該当する文書がありません</p>
      </div>
      @endif
    </main>
  </div>

  <script>
    window.directoryBaseUrl = "{{ route('document.index') }}"; //タグワンクリック検索用
  </script>
</body>

</html>