<p>
    @if($sent_preferences_count > 0)
        @if($sent_preferences_count > 3)
            @foreach($teachers as $teacher)
                @if($loop->iteration > 2) @break @endif
                <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
                   title="{{ $teacher->name }}">{{
                    explode(' ',trim($teacher->name))[0]
                }}</a>@if($loop->first), @endif
            @endforeach
            et {{ $sent_preferences_count - 2 }} autres ont envoyé leurs préférences
        @else
            @foreach($teachers as $teacher)
                <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
                   title="{{ $teacher->name }}">{{
                    explode(' ',trim($teacher->name))[0]
                }}</a>@if($loop->count > 2 && $loop->remaining >= 2), @endif
                @if($loop->remaining === 1) et @endif
            @endforeach
            @if($sent_preferences_count == '1') a envoyé ses @else ont envoyé leurs @endif préférences
        @endif
    @else
        Aucun professeur n'a envoyé ses préférences actuellement
    @endif
</p>
