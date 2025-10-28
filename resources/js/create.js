document.addEventListener('DOMContentLoaded', () => {
    console.log('create.js loaded'); // デバッグ
    const textarea = document.querySelector('.content'); 
    const charCount = document.querySelector('#char-count');

    if (!textarea || !charCount) {
        console.error('create.js: Missing textarea or char-count', { textarea, charCount });
        return;
    }

    // 文字数更新関数（改行除去）
    const updateCharCount = () => {
        const textWithoutNewlines = textarea.value.replace(/[\r\n]+/g, '');
        charCount.textContent = `${textWithoutNewlines.length}文字`;
    };

    // テキストエリアの高さ調整関数
    const updateHeight = () => {
        textarea.style.height = 'auto';
        textarea.style.height = `${textarea.scrollHeight}px`;
    };

    // 初期化
    updateCharCount();
    updateHeight();

    // 入力時に更新
    textarea.addEventListener('input', () => {
        updateCharCount();
        updateHeight();
    });

    // ダークモード切り替え
    const body = document.querySelector('body');
    const darkmode = document.querySelector('#darkSwitch');
    if (darkmode) {
        darkmode.addEventListener('change', () => {
            body.classList.toggle('dark');
        });
    }
});