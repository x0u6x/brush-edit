document.addEventListener('DOMContentLoaded', () => {
    // Elements
    const sidebar = document.querySelector('.sidebar');
    const toggleButton = document.querySelector('.toggle-button');

    //色関連
    const body = document.querySelector('body');
    const backColorInput = document.querySelector('#back-color');
    const fontColorInput = document.querySelector('#font-color');

    const fontSizeInput = document.querySelector('#font-size');
    const fontFamilySelect = document.querySelector('.font-family');

    //縦横関連
    const directionRadios = document.querySelectorAll('input[name="direction"]');
    const mainText = document.querySelector('.main-text');
    const main = document.querySelector('main');
    const h1 = document.querySelector('h1');



    // 設定の読み込み
    function loadSettings() {
        const settings = {
            direction: localStorage.getItem('direction') || 'horizontal',
            backColor: localStorage.getItem('backColor') || '#ffffff',
            fontColor: localStorage.getItem('fontColor') || '#000000',
            fontSize: localStorage.getItem('fontSize') || '16',
            fontFamily: localStorage.getItem('fontFamily') || 'Gothic'
        };

        // ラジオボタン
        document.querySelector(`input[name="direction"][value="${settings.direction}"]`)?.click();
        // 入力値
        backColorInput.value = settings.backColor;
        fontColorInput.value = settings.fontColor;
        fontSizeInput.value = settings.fontSize;
        fontFamilySelect.value = settings.fontFamily;

        updateStyles(); // 初期化時にスタイル適用
    }

    // 設定の保存
    function saveSettings() {
        localStorage.setItem('direction', document.querySelector('input[name="direction"]:checked').value);
        localStorage.setItem('backColor', backColorInput.value);
        localStorage.setItem('fontColor', fontColorInput.value);
        localStorage.setItem('fontSize', fontSizeInput.value);
        localStorage.setItem('fontFamily', fontFamilySelect.value);
    }

    // スタイルの一括適用
    function updateStyles() {
        body.style.backgroundColor = backColorInput.value || '#ffffff';
        mainText.style.color = fontColorInput.value || '#000000';
        let size = parseInt(fontSizeInput.value) || 16;
        size = Math.max(12, Math.min(24, size));
        mainText.style.fontSize = `${size}px`;
        body.style.lineHeight = `${size + 16}px`;
        h1.style.fontSize = `${size + 8}px`;
        mainText.style.fontFamily = ['Gothic', 'Mincho'].includes(fontFamilySelect.value)
            ? (fontFamilySelect.value === 'Gothic' ? '"Zen Kaku Gothic New", sans-serif' : '"Zen Old Mincho", serif')
            : '"Zen Kaku Gothic New", sans-serif';
    }



    // 表示・非表示
    toggleButton.addEventListener('click', () => {
        sidebar.style.transform = sidebar.style.transform === 'translateX(-216px)' ? 'translateX(0px)' : 'translateX(-216px)';
    });

    // 縦横切り替え
    directionRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const isVertical = radio.value === 'vertical';
            mainText.classList.toggle('vertical-text', isVertical);
            mainText.classList.toggle('main-text', !isVertical);
            main.classList.toggle('vertical-text', isVertical);
            h1.classList.toggle('vertical-text', isVertical);
            updateStyles();
            saveSettings();
        });
        
    });

    // 背景色・文字色
    backColorInput.addEventListener('input', () => {
        body.style.backgroundColor = backColorInput.value || '#ffffff';
        saveSettings();
    });

    fontColorInput.addEventListener('input', () => {
        mainText.style.color = fontColorInput.value || '#000000';
        saveSettings();
    });

    // フォントサイズ（バリデーション付き）
    fontSizeInput.addEventListener('input', () => {
        let size = parseInt(fontSizeInput.value) || 16;
        size = Math.max(12, Math.min(24, size));
        fontSizeInput.value = size;
        mainText.style.fontSize = `${size}px`;
        mainText.style.lineHeight = `${size + 16}px`;
        h1.style.fontSize = `${size + 8}px`;
        saveSettings();
    });

    // フォントファミリー
    fontFamilySelect.addEventListener('change', () => {
        mainText.style.fontFamily = ['Gothic', 'Mincho'].includes(fontFamilySelect.value)
            ? (fontFamilySelect.value === 'Gothic' ? '"Zen Kaku Gothic New", sans-serif' : '"Zen Old Mincho", serif')
            : '"Zen Kaku Gothic New", sans-serif';
        saveSettings();
    });

    // 初期化
    loadSettings();

});