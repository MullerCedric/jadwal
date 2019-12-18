<div class="c-side-nav__group">
    @if (Route::has('exam_sessions.create'))
        <a href="{{ route('exam_sessions.create') }}" class="c-side-nav__link">
            {{ __('exam_sessions.new_session') }}
        </a>
    @endif
    @if (Route::has('exam_sessions.index'))
        <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
            {{ __('exam_sessions.curr_and_future_sessions') }}
        </a>
    @endif
    @if (Route::has('closed_exam_sessions.index'))
        <a href="{{ route('closed_exam_sessions.index') }}" class="c-side-nav__link">
            {{ __('exam_sessions.closed_sessions') }}
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    <a href="{{ route('locations.index') }}" class="c-side-nav__link">
        Gérer les implantations
    </a>
    <a href="{{ route('messages.index') }}" class="c-side-nav__link">
        Gérer les messages
    </a>
    <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
        Gérer les professeurs
    </a>
</div>
