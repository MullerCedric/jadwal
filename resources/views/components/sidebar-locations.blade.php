<div class="c-side-nav__group">
    @if (Route::has('locations.create'))
        <a href="{{ route('locations.create') }}"
           class="c-side-nav__link{{ $current === 'create' ? ' c-side-nav__link--current' : '' }}">
            Ajouter une implantation
        </a>
    @endif
    @if (Route::has('locations.index'))
        <a href="{{ route('locations.index') }}"
           class="c-side-nav__link{{ $current === 'index' ? ' c-side-nav__link--current' : '' }}">
            Gérer les implantations
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
        Gérer les sessions
    </a>
    <a href="{{ route('messages.index') }}" class="c-side-nav__link">
        Gérer les messages
    </a>
    <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
        Gérer les professeurs
    </a>
</div>
