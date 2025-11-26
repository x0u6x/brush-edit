<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brush Edit | ログイン</title>

    @vite(['resources/css/reset.css']) <!--リセットCSS -->
    @vite(['resources/css/login.css']) <!--このページのみのCSS -->
    @vite(['resources/css/modal.css']) <!--このページのみのCSS -->

    @vite(['resources/js/login.js']) <!-- タブ切り替え -->
    @vite(['resources/js/app.js']) <!-- パスワードリセットモーダル -->
</head>

<body>

    <div class="wrapper">
        <div class="about-info">
            <h1>Brush Edit</h1>
            <h2>Brush Editは文章の推敲を支援する<br>
                デスクトップアプリケーションです。</h2>
            <p>できること</p>
            <ul>
                <li>・文章の執筆、保存</li>
                <li>・プレビューで閲覧（縦書きも対応）</li>
                <li>・ダークモード切り替え</li>
                <li>・ファイルにタグ付け</li>
                <li>・タグ検索</li>

            </ul>

            <p>今後実装予定</p>
            <ul>
                <li>・プレビューレイアウトを電子書籍風に</li>
                <li>・プレビューにマーカー機能追加</li>
                <li>・プレビューにしおり機能追加</li>
            </ul>

        </div>

        <div class="auth-container">
            <div class="auth-tabs">
                <button class="tab" data-tab="login">ログイン</button>
                <button class="tab" data-tab="register">新規登録</button>
            </div>

            <div class="login-form">

                @if (session('status'))
                <div class="status-message">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <h2>アカウントにログイン</h2>
                    <!-- メールアドレス -->
                    <div class="form-input">
                        <label for="login-email">メールアドレス</label>
                        <input id="login-email"
                            type="email" name="email"
                            autofocus autocomplete="username"
                            placeholder="example@example.com">
                        @error('email')
                        @if ((request()->is('login') || request()->is('/')) && !request()->is('register'))
                        <p class="error">{{ $message }}</p>
                        @endif
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-input">
                        <label for="login-password">パスワード</label>
                        <input id="login-password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="●●●●●●●●●●●">
                        @error('password')
                        @if ((request()->is('login') || request()->is('/')) && !request()->is('register'))
                        <p class="error">{{ $message }}</p>
                        @endif
                        @enderror
                    </div>

                    <!-- ブラウザに記憶 -->
                    <div>
                        <label for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>この端末でログイン状態を記憶する</span>
                        </label>
                    </div>

                    <button class="form-button">
                        {{ __('Log in') }}
                    </button>

                </form>

                <!-- パスワードリクエスト -->
                <div x-data="{ openPasswordReset: {{ $errors->has('email') ? 'true' : 'false' }} }">

                    @include('custom-auth.modals.password-reset-modal', [
                    'open' => 'openPasswordReset'
                    ])

                </div>
            </div>


            <div class="register-form">

                @if (session('status'))
                <div class="status-message">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <h2>アカウント新規登録</h2>
                    <!-- メールアドレス -->
                    <div class="form-input">
                        <label for="register-email">メールアドレス</label>
                        <input id="register-email" type="email" name="email"
                            autofocus autocomplete="username"
                            placeholder="example@example.com">
                        @error('email')
                        @if ((request()->is('register') || request()->is('/')) && !request()->is('login'))
                        <p class="error">{{ $message }}</p>
                        @endif
                        @enderror
                    </div>

                    <!-- パスワード -->
                    <div class="form-input">
                        <label for="register-password">パスワード</label>
                        <input id="register-password" type="password" name="password"
                            autocomplete="current-password"
                            placeholder="●●●●●●●●●●●">

                        @error('password')
                        @if ((request()->is('register') || request()->is('/')) && !request()->is('login'))
                        <p class="error">{{ $message }}</p>
                        @endif
                        @enderror
                    </div>

                    <!-- パスワード確認 -->
                    <div class="form-input">
                        <label for="password_confirmation">パスワード確認</label>
                        <input id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            placeholder="●●●●●●●●●●●">
                        @error('password_confirmation')
                        @if ((request()->is('register') || request()->is('/')) && !request()->is('login'))
                        <p class="error">{{ $message }}</p>
                        @endif
                        @enderror
                    </div>

                    <button class="form-button">
                        {{ __('Register') }}
                    </button>

                </form>
            </div>

        </div>

    </div>

</body>

</html>