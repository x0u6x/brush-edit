<section>

    <h2>アカウントを削除</h2>

    <p class="profile-info">
        アカウントを削除すると、全てのデータとファイルも完全に削除されます。
        アカウントを削除する前に必要なデータがあれば事前にダウンロードの実施をお願いします。
    </p>

    <div x-data="{ openDeleteModal: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
        @include('custom-auth.modals.delete-account-modal', [
        'open' => 'openDeleteModal'
        ])
    </div>

</section>