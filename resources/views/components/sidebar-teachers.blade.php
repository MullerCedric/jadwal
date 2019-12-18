<div class="c-side-nav__group">
    @if (Route::has('teachers.create'))
        <a href="{{ route('teachers.create') }}" class="c-side-nav__link">
            Ajouter un professeur
        </a>
    @endif
    @if (Route::has('teachers.index'))
        <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
            Gérer les professeurs
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
    <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
        Gérer les sessions
    </a>
</div>
