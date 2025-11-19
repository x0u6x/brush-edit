<section>

    <h2>アカウントを削除</h2>

    <p class="profile-info">
        アカウントを削除すると、全てのデータとファイルも完全に削除されます。
        アカウントを削除する前に必要なデータがあれば事前にダウンロードの実施をお願いします。
    </p>

    <div x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">

        <!-- アカウント削除ボタン -->
        <button
            @click="open = true"
            class="user-delete-btn">
            アカウント削除
        </button>

        <!-- モーダル：オーバーレイ -->
        <div
            x-show="open"
            x-transition
            class="modal-overlay">

            <!-- モーダル本体 -->
            <div
                class="modal-container"
                @click.outside="open = false">

                <span class="modal-close"
                    @click="open = false">&times;
                </span>

                <h2 class="modal-title">本当に削除しますか？</h2>

                <p class="modal-text">
                    この操作は元に戻せません。<br>
                    アカウントに紐づくデータもすべて削除されます。
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <label for="password" class="form-label">
                        確認のためパスワードを入力してください
                    </label>

                    <input
                        id="password"
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
                            @click="open = false">
                            キャンセル
                        </button>

                        <button
                            type="submit"
                            class="btn-danger">
                            削除する
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


</section>