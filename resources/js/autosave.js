document.addEventListener('DOMContentLoaded', async () => {
    console.log('autosave.js loaded');
    const titleInput = document.querySelector('.title');
    const textarea = document.querySelector('.content');
    const documentId = textarea?.dataset.documentId;
    const userId = window.userId;
    console.log('Elements:', { titleInput, textarea, documentId, userId });
    if (!titleInput || !textarea || !documentId || !userId) {
        showNotification('エラー: 必要な要素が見つかりません', 'error');
        return console.error('Missing elements or IDs');
    }

    // 通知を表示する関数
    const showNotification = (message, type) => {
        const notification = document.querySelector('#notification');
        notification.textContent = message;
        notification.className = `notification ${type}`;
        notification.style.display = 'block';
        notification.style.opacity = '1';
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 500);
        }, 2000); // 3秒後に非表示
    };

    let timeoutId;
    const saveToLaravel = async () => {
        console.log('Saving:', { title: titleInput.value, content: textarea.value });
        if (!titleInput.value && !textarea.value) return;

        // オフライン検知
        if (!navigator.onLine) {
            showNotification('オフラインです。保存できません', 'error');
            return;
        }

        clearTimeout(timeoutId);
        timeoutId = setTimeout(async () => {
            const url = `/api/documents/update/${documentId}`;
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: titleInput.value || '',
                        content: textarea.value || ''
                    })
                });
                if (response.ok) {
                    console.log('Saved to Laravel!', { documentId });
                    showNotification('保存しました！', 'success');
                } else {
                    const errorText = await response.text();
                    console.error('Laravel save failed:', response.status, errorText);
                    showNotification(`保存に失敗しました: ${response.status}`, 'error');
                }
            } catch (error) {
                console.error('Network error:', error);
                showNotification('ネットワークエラー: 保存できませんでした', 'error');
            }
        }, 1000);
    };

    titleInput.addEventListener('input', saveToLaravel);
    textarea.addEventListener('input', saveToLaravel);
});