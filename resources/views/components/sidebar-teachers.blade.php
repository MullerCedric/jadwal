@if(isset($teacher))
    <div class="c-side-nav__group">
        <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
           class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
            @svg('eye', 'c-side-nav__icon')Voir le professeur
        </a>
        <a href="{{ route('teachers.edit', ['teacher' => $teacher->id]) }}"
           class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
            @svg('edit-3', 'c-side-nav__icon')Modifier ses informations
        </a>
        <a href="mailto:{{ $teacher->email }}"
           class="c-side-nav__link">
            @svg('mail', 'c-side-nav__icon')Envoyer un e-mail
        </a>
        <a href="{{ route('confirm.show', ['confirmBoxId' => 'deleteTeacher']) }}"
           class="c-side-nav__link">
            @svg('trash-2', 'c-side-nav__icon')Supprimer le professeur

            @section('deleteTeacher')
                @component('components/confirm-box', [
                    'action' => route('teachers.destroy', ['teacher' => $teacher->id]),
                    'method' => 'DELETE',
                    'cancelFirst' => true,
                    ])
                    <p>
                        Voulez-vous définitivement supprimer les informations liées à ce professeur ?
                    </p>
                    @slot('actions')
                        <button type="submit" class="button button--small">Supprimer</button>
                    @endslot
                @endcomponent
            @endsection
        </a>
    </div>
@endif
<div class="c-side-nav__group">
    @if (Route::has('teachers.create'))
        <a href="{{ route('teachers.create') }}" class="c-side-nav__link">
            @svg('plus-square', 'c-side-nav__icon')Ajouter un professeur
        </a>
    @endif
    @if (Route::has('teachers.index'))
        <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
            @svg('list', 'c-side-nav__icon')Gérer les professeurs
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    <a href="{{ route('locations.index') }}" class="c-side-nav__link">
        @svg('map-pin', 'c-side-nav__icon')Gérer les implantations
    </a>
    <a href="{{ route('messages.index') }}" class="c-side-nav__link">
        @svg('mail', 'c-side-nav__icon')Gérer les messages
    </a>
    <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
        @svg('activity', 'c-side-nav__icon')Gérer les sessions
    </a>
</div>
