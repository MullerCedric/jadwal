@if($total_count > 0)
    @if($total_count > 3)
        @foreach($teachers as $teacher)
            @if($loop->iteration > 2) @break @endif
            <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
               title="{{ $teacher->name }}">{{
                    explode(' ',trim($teacher->name))[0]
                }}</a>@if($loop->first), @endif
        @endforeach
        et {{ $total_count - 2 }} autres {{ $plural }}
    @else
        @foreach($teachers as $teacher)
            <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
               title="{{ $teacher->name }}">{{
                    explode(' ',trim($teacher->name))[0]
                }}</a>@if($loop->count > 2 && $loop->remaining >= 2), @endif
            @if($loop->remaining === 1) et @endif
        @endforeach
        {{ $total_count == '1' ? $singular : $plural }}
    @endif
@else
    {{ $none }}
@endif
