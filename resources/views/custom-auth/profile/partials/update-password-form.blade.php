<section>

    <h2>パスワード更新</h2>

    <p class="profile-info">十分に長くランダムなパスワードを使用して、アカウントのセキュリティを高めましょう。</p>


    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- 現在のパスワード -->
        <div class="form-group">
            <label for="current_password" class="form-label">現在のパスワード</label>
            <input
                class="form-input"
                id="current_password"
                name="current_password"
                type="password"
                autocomplete="current-password">

            @if ($errors->updatePassword->has('current_password'))
            <p class="error-message">
                {{ $errors->updatePassword->first('current_password') }}
            </p>
            @endif
        </div>

        <!-- 新しいパスワード -->
        <div class="form-group">
            <label for="password" class="form-label">新しいパスワード</label>
            <input
                class="form-input"
                id="password"
                name="password"
                type="password"
                autocomplete="new-password">

            @if ($errors->updatePassword->has('password'))
            <p class="error-message">
                {{ $errors->updatePassword->first('password') }}
            </p>
            @endif
        </div>

        <!-- 新しいパスワード（確認） -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">パスワード再入力</label>
            <input
                class="form-input"
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password">

            @if ($errors->updatePassword->has('password_confirmation'))
            <p class="error-message">
                {{ $errors->updatePassword->first('password_confirmation') }}
            </p>
            @endif
        </div>

        <div>
            <button type="submit" class="profile-save-btn">保存する</button>

            @if (session('status') === 'password-updated')
            <p
                class="profile-saved-message"
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)">保存しました</p>
            @endif
        </div>

    </form>
</section>