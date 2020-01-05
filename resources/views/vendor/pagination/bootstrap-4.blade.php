@if ($paginator->hasPages())
    <div class="c-pagination">
        <div class="c-pagination__button">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="c-pagination__link disabled" aria-disabled="true">&lsaquo;</span>
            @else
                <a class="c-pagination__link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   aria-label="@lang('pagination.previous')">&lsaquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="c-pagination__link disabled" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="c-pagination__link c-pagination__link--current"
                               href="{{ $url }}" aria-current="page">{{ $page }}</a>
                        @else
                            <a class="c-pagination__link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="c-pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                   aria-label="@lang('pagination.next')">&rsaquo;</a>
            @else
                <span class="c-pagination__link disabled" aria-disabled="true">&rsaquo;</span>
            @endif
        </div>
    </div>
@endif
