@props(['open'])

<!-- 開くボタン -->
{{ $trigger }}

<!-- モーダル本体 -->
<div
    x-show="{{ $open }}"
    x-transition
    class="modal-overlay">
    <div
        class="modal-container"
        @click.outside="{{ $open }} = false">
        <span class="modal-close" @click="{{ $open }} = false">&times;</span>

        <div class="modal-body">
            {{ $slot }}
        </div>

        @if (isset($actions))
        <div class="modal-actions">
            {{ $actions }}
        </div>
        @endif
    </div>
</div>