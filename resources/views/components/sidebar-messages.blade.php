<div class="c-side-nav__group">
    @if (Route::has('messages.create'))
        <a href="{{ route('messages.create') }}"
           class="c-side-nav__link{{ $current === 'create' ? ' c-side-nav__link--current' : '' }}">
            Écrire un nouveau message
        </a>
    @endif
    @if (Route::has('messages.index'))
        <a href="{{ route('messages.index') }}"
           class="c-side-nav__link{{ $current === 'index' ? ' c-side-nav__link--current' : '' }}">
            Gérer les messages
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    <a href="{{ route('locations.index') }}" class="c-side-nav__link">
        Gérer les implantations
    </a>
    <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
        Gérer les sessions
    </a>
    <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
        Gérer les professeurs
    </a>
</div>
