<section>

    <h2>メールアドレス変更</h2>
    <p class="profile-info">アカウントに登録されているメールアドレスを変更できます。</p>


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div>
            <label for="email" class="form-label">メールアドレス</label>

            <input
                id="email" name="email" type="email"
                value="{{ old('email', $user->email) }}"
                required autocomplete="username"
                class="form-input" />

            @error('email')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="profile-save-btn">保存する</button>

            @if (session('status') === 'profile-updated')
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