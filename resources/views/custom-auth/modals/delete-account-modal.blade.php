<x-modals.modal-wrapper :open="'openDeleteModal'">

    <!-- 削除ボタン -->
    <x-slot:trigger>
        <button
            type="button"
            class="btn-danger"
            @click="openDeleteModal = true">
            アカウント削除
        </button>
    </x-slot:trigger>

    <!-- モーダル中身 -->
    <h2 class="modal-title">本当に削除しますか？</h2>

    <p class="modal-text">
        この操作は元に戻せません。<br>
        アカウントに紐づくデータもすべて削除されます。
    </p>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <label for="delete-password" class="form-label">
            確認のためパスワードを入力してください
        </label>

        <input
            id="delete-password"
            name="password"
            type="password"
            class="input-text">

        @if ($errors->userDeletion->has('password'))
        <p class="form-error">
            {{ $errors->userDeletion->first('password') }}
        </p>
        @endif

        <div class="modal-actions">
            <button
                type="button"
                class="btn-secondary"
                @click="openDeleteModal = false">
                キャンセル
            </button>

            <button
                type="submit"
                class="btn-danger">
                削除する
            </button>
        </div>

    </form>

</x-modals.modal-wrapper>