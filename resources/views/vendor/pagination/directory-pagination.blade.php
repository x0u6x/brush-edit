@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <!-- ページ番号 (1 2) -->
        <div class="pagination-numbers">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="current-page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <!-- 右揃えの「1-10 全13件」 -->
        <div class="pagination-info">
            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} 全{{ $paginator->total() }}件
        </div>
    </div>
@endif