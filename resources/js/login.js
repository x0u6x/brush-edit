document.addEventListener('DOMContentLoaded', () => {
    console.log('login.js loaded'); // デバッグ

    const tabs = document.querySelectorAll('.tab');
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');

    // 初期表示: ログインタブをアクティブに
    document.querySelector('.tab[data-tab="login"]').classList.add('active');
    loginForm.classList.add('active');

    // 各タブにクリックイベントを追加
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // フォームの表示/非表示を切り替え
            const target = tab.getAttribute('data-tab');
            if (target === 'login') {
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
            } else if (target === 'register') {
                loginForm.classList.remove('active');
                registerForm.classList.add('active');
            }
        });
    });

})