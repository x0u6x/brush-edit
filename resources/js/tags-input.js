document.addEventListener('DOMContentLoaded', function () {
    const tagInput = document.querySelector('input[name="tags"]');
    const addTagBtn = document.querySelector('.add-tag-btn');
    const tagToggle = document.querySelector('.tag-toggle');
    const tagPopup = document.querySelector('.tag-input-popup');
    const tagCount = document.querySelector('.tag-count');
    const tagPills = document.querySelector('.tag-pills');
    const documentId = window.documentId; // Editページで確定済み
    let currentTags = [];

    // トグル機能
    if (tagToggle && tagPopup) {
        tagToggle.addEventListener('click', function (e) {
            e.stopPropagation(); // 外クリック検知を防ぐ
            const isOpen = tagPopup.style.display === 'block';
            if (isOpen) {
                tagPopup.style.display = 'none';
            } else {
                tagPopup.style.display = 'block';
            }
        });
    }

    // ポップアップ外クリックで閉じる
    if (tagPopup) {
        document.addEventListener('click', function (e) {
            if (!tagPopup.contains(e.target) && !tagToggle.contains(e.target) && tagPopup.style.display === 'block') {
                tagPopup.style.display = 'none';
                tagToggle.textContent = '#タグ';
            }
        });
    }

    // タグ数カウント
    function updateTagCount() {
        if (tagCount) {
            tagCount.textContent = currentTags.length > 0 ? `${currentTags.length}` : '';
            tagCount.style.backgroundColor = currentTags.length > 0 ? '#bbb' : 'transparent';
        } else {
            console.error('❌ tagCount is null');
        }
    }

    // ピル表示更新
    function updateTagPills() {
        if (!tagPills) {
            console.error('❌ tagPills is null');
            return;
        }
        tagPills.innerHTML = '';
        if (tagInput) {
            tagInput.value = ''; // ピル表示時にinputクリア
        }

        currentTags.forEach((tag, index) => {
            const pill = document.createElement('span');
            pill.className = 'tag-pill';
            pill.innerHTML = `
                ${tag}
                <span class="delete-tag-btn" data-index="${index}">×</span>
            `;
            tagPills.appendChild(pill);
        });

        // 削除ボタンのイベントリスナー
        document.querySelectorAll('.delete-tag-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const index = parseInt(this.getAttribute('data-index'));
                deleteTag(index);
            });
        });
    }

    // タグ削除
    function deleteTag(index) {
        const newTags = currentTags.filter((_, i) => i !== index);
        fetch(`/api/documents/${documentId}/tags`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ tags: newTags.join('#') || '' }) //空を許容
        })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log('🔍 削除レスポンス:', data);
                if (data.success) {
                    currentTags = data.tags || [];
                    console.log('✅ タグ削除完了:', currentTags);
                    tagInput.value = ''; // 入力クリア
                    updateTagPills(); // ピル更新
                    updateTagCount(); // タグ数更新
                } else {
                    console.error('❌ 削除失敗:', data);
                }
            })
            .catch(err => console.error('❌ タグ削除エラー:', err));
    }

    // 初期化関数
    function initTags() {
        if (!documentId || !tagInput) {
            console.error('❌ documentIdまたはtagInputが見つかりません');
            return;
        }

        console.log(`✅ タグ初期化: documentId=${documentId}`);

        // 既存タグ取得
        fetch(`/api/documents/${documentId}/tags`)
            .then(res => res.json())
            .then(data => {
                currentTags = data.tags || [];
                updateTagCount();
                updateTagPills();
            })
            .catch(err => console.error('❌ タグ取得エラー:', err));
    }

    // タグ保存関数
    function saveTags() {
        if (!tagInput || !documentId) return;

        fetch(`/api/documents/${documentId}/tags`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ tags: tagInput.value || '' }) //空を許容
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    currentTags = data.tags || [];
                    console.log('✅ タグ保存完了:', data.tags);
                    updateTagCount();
                    updateTagPills();
                }
            })
            .catch(err => console.error('❌ タグ保存エラー:', err));
    }

    // ボタンクリックでタグ保存
    if (addTagBtn) {
        addTagBtn.addEventListener('click', saveTags);
    }

    // 初回初期化
    initTags();
});