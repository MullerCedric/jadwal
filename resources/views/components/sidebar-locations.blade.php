@if(isset($location))
    <div class="c-side-nav__group">
        @if(Route::has('locations.show'))
            <a href="{{ route('locations.show', ['location' => $location->id]) }}"
               class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
                @svg('eye', 'c-side-nav__icon')Voir l'implantation
            </a>
        @endif
        @if(Route::has('locations.edit'))
            <a href="{{ route('locations.edit', ['location' => $location->id]) }}"
               class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
                @svg('edit-3', 'c-side-nav__icon')Modifier l'implantation
            </a>
        @endif
        @if(Route::has('confirm.show') && Route::has('locationsteachers.destroy'))
            <a href="{{ route('confirm.show', ['confirmBoxId' => 'emptyLocation']) }}"
               class="c-side-nav__link">
                @svg('rotate-ccw', 'c-side-nav__icon')Réinitialiser l'implantation

                @section('emptyLocation')
                    @component('components/confirm-box', [
                        'action' => route('locationsteachers.destroy', ['location' => $location->id]),
                        'method' => 'DELETE',
                        'cancelFirst' => true,
                        ])
                        <p>
                            Voulez-vous vraiment retirer tous les professeurs de cette implantation ?
                        </p>
                        <p class="c-smaller">
                            Note: Cette action ne supprimera pas les professeurs. Elle les retirera simplement de cette
                            implantation
                        </p>
                        @slot('actions')
                            <button type="submit" class="button button--small">Réinitialiser</button>
                        @endslot
                    @endcomponent
                @endsection
            </a>
        @endif
        @if(Route::has('confirm.show') && Route::has('locations.destroy'))
            <a href="{{ route('confirm.show', ['confirmBoxId' => 'deleteLocation']) }}"
               class="c-side-nav__link">
                @svg('trash-2', 'c-side-nav__icon')Supprimer l'implantation

                @section('deleteLocation')
                    @component('components/confirm-box', [
                        'action' => route('locations.destroy', ['location' => $location->id]),
                        'method' => 'DELETE',
                        'cancelFirst' => true,
                        ])
                        <p>
                            Voulez-vous définitivement supprimer cette implantation ?
                        </p>
                        @slot('actions')
                            <button type="submit" class="button--small">Supprimer</button>
                        @endslot
                    @endcomponent
                @endsection
            </a>
        @endif
    </div>
@endif
<div class="c-side-nav__group">
    @if(Route::has('locations.create'))
        <a href="{{ route('locations.create') }}"
           class="c-side-nav__link{{ $current === 'create' ? ' c-side-nav__link--current' : '' }}">
            @svg('plus-square', 'c-side-nav__icon')Ajouter une implantation
        </a>
    @endif
    @if(Route::has('locations.index'))
        <a href="{{ route('locations.index') }}"
           class="c-side-nav__link{{ $current === 'index' ? ' c-side-nav__link--current' : '' }}">
            @svg('grid', 'c-side-nav__icon')Gérer les implantations
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    @if(Route::has('exam_sessions.index'))
        <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
            @svg('activity', 'c-side-nav__icon')Gérer les sessions
        </a>
    @endif
    @if(Route::has('messages.index'))
        <a href="{{ route('messages.index') }}" class="c-side-nav__link">
            @svg('mail', 'c-side-nav__icon')Gérer les messages
        </a>
    @endif
    @if(Route::has('teachers.index'))
        <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
            @svg('users', 'c-side-nav__icon')Gérer les professeurs
        </a>
    @endif
</div>
