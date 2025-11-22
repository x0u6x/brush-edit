<x-modals.modal-wrapper :open="'openPasswordReset'">

    <x-slot:trigger>

        <a href="#"
            class="forgot-password-link"
            @click.prevent="openPasswordReset = true">
            パスワードをお忘れですか？
        </a>

    </x-slot:trigger>

    <h2 class="modal-title">パスワードリセット</h2>
    <p class="modal-text">
        ご登録時のメールアドレスを入力してください。<br>
        リセットリンクを送信します。</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label for="reset-email">メールアドレス</label>
        <input id="reset-email" type="email" name="email" class="input-text">
        @error('email')
        <p class="form-error">{{ $message }}</p>
        @enderror

        <div class="modal-actions">
            <button type="submit" class="btn-nomal">
                リセットリンクを送信
            </button>
        </div>
    </form>

</x-modals.modal-wrapper>