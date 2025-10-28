/* ↓ホバー時に文章冒頭を表示させる */
document.addEventListener('DOMContentLoaded', () => {
  const titles = document.querySelectorAll('.titles');

  titles.forEach(title => {
    // ツールチップ要素を動的に追加
    const tooltip = document.createElement('span');
    tooltip.className = 'tooltip-text';
    tooltip.textContent = title.dataset.tooltip || '内容なし';
    title.appendChild(tooltip);

    // マウス移動時にツールチップをカーソル横に配置
    title.addEventListener('mousemove', (e) => {
      const offsetX = 15; // カーソルからの横オフセット
      const offsetY = 10; // カーソルからの縦オフセット
      tooltip.style.left = `${e.clientX + offsetX}px`;
      tooltip.style.top = `${e.clientY + offsetY}px`;
    });
  });

  /* タグワンクリック検索 */
  const tagPills = document.querySelectorAll('.tag-pill');
  const urlParams = new URLSearchParams(window.location.search);
  const currentTagId = urlParams.get('tag_id');
  const searchQuery = urlParams.get('search');

  tagPills.forEach(pill => {
    pill.addEventListener('click', () => {
      const tagId = pill.dataset.tagId;
      const baseUrl = window.directoryBaseUrl || '/documents/directory';

      // 同じタグをクリックしたらフィルタ解除
      if (currentTagId === tagId) {
        // 検索クエリがあれば保持
        window.location.href = searchQuery ? `${baseUrl}?search=${searchQuery}` : baseUrl;
      } else {
        // 新しいタグを適用、検索クエリも保持
        const newParams = new URLSearchParams();
        newParams.set('tag_id', tagId);
        if (searchQuery) newParams.set('search', searchQuery);
        window.location.href = `${baseUrl}?${newParams.toString()}`;
      }
    });
  });
});