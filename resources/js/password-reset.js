document.addEventListener('DOMContentLoaded', () => {
    console.log('password-reset.js loaded'); // デバッグ
    
    const modal = document.getElementById('forgotPasswordModal');
    const openModal = document.querySelector('.forgot-password-link');
    const closeModal = document.querySelector('.modal-close');
    const resetForm = document.querySelector('#forgot-password-form');

    openModal.addEventListener('click', (e) => {
        e.preventDefault();
        modal.classList.add('active');
    });

    closeModal.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    //背景クリックで閉じる
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('active');
    });


    //モーダルフォームAJAX通信
    resetForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.querySelector('#reset-email').value;
        const csrfToken = document.querySelector('#forgot-password-form input[name="_token"]').value;

        console.log('Sending email:', email);
        try {
            const response = await fetch('/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ email })
            });

            console.log('🔍 Response Status:', response.status);
            console.log('🔍 Response OK:', response.ok);
            console.log('🔍 Response Headers:', response.headers.get('content-type'));


            const data = await response.json();
            const errorSpan = document.querySelector('#email-error');
            const successDiv = document.querySelector('#success-message');
            if (response.ok) {
                successDiv.textContent = data.status || 'リセットリンクを送信しました！';
                setTimeout(() => {
                    modal.classList.remove('active');
                    successDiv.textContent = '';
                }, 2000);
            } else {
                errorSpan.textContent = data.errors?.email || 'エラーが発生しました';
            }
        } catch (error) {
            document.querySelector('#email-error').textContent = 'ネットワークエラーが発生しました';
        }
    });
});