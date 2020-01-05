<div class="c-pagination c-pagination--top">
    @foreach ($letters as $letter => $count)
        @if($count >= 1)
            <a href="{{ route('teachers.index', ['currLetter' => $letter]) }}" title="{{ $count }} professeur(s)"
               class="button button--small c-pagination__link{{ $currLetter === $letter ? ' c-pagination__link--current' : '' }}">
                {{ implode(" ", str_split($letter)) }}
            </a>
        @else
            <span class="button button--small disabled c-pagination__link">
                {{ implode(" ", str_split($letter)) }}
            </span>
        @endif
    @endforeach
</div>
