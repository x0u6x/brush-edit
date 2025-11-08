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