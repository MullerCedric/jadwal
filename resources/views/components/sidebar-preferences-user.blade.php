<div class="sr-only-focusable__container">
    <a class="sr-only-focusable" href="#content">Revenir au contenu</a>
</div>
@if(isset($preference) && $teacher)
    @if(Route::has('preferences.show') && $examSession->isValidated())
        <a href="{{ route('preferences.show', ['preference' => $preference->id]) }}"
           class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
            @svg('eye', 'c-side-nav__icon')<span>Voir les préférences de <i
                    title="{{ $teacher->name }}">{{ explode(' ',trim($teacher->name))[0] }}</i></span>
        </a>
    @endif
    @if(Route::has('preferences.showPDF') && $current === 'show' && $preference->isValidated() && $preference->isSent())
        <a href="{{ route('preferences.showPDF', ['preference' => $preference->id]) }}"
           class="c-side-nav__link">
            @svg('file-text', 'c-side-nav__icon')Exporter ces préférences en PDF
        </a>
    @endif
    @if(Route::has('confirm.show') && Route::has('preferences.edit') && $preference->isSent())
        <a href="{{ route('confirm.show', ['confirmBoxId' => 'UpdatePreference' . $preference->id]) }}"
           class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
            @svg('edit-3', 'c-side-nav__icon')<span>Modifier les préférences de <i
                    title="{{ $teacher->name }}">{{ explode(' ',trim($teacher->name))[0] }}</i></span>

            @section('UpdatePreference' . $preference->id)
                @component('components/confirm-box', ['cancelFirst' => true])
                    <p>
                        Voulez-vous vraiment modifier les préférences envoyées par ce professeur ?
                    </p>
                    <p class="c-smaller">
                        Note : le professeur concerné sera averti par e-mail des modifications que vous avez apportées !
                    </p>
                    @slot('actions')
                        <a href="{{ route('preferences.edit', ['preference' => $preference->id]) }}"
                           class="button button--small">
                            Modifier ces préférences
                        </a>
                    @endslot
                @endcomponent
            @endsection
        </a>
    @endif
@endif
<div class="c-side-nav__group">
    @if(Route::has('exam_sessions.show'))
        <a href="{{ route('exam_sessions.show', ['id' => $examSession->id]) }}"
           class="c-side-nav__link">
            @svg('activity', 'c-side-nav__icon')Revenir à la session
        </a>
    @endif
    @if(Route::has('exam_sessions.index'))
        <a href="{{ route('exam_sessions.index') }}"
           class="c-side-nav__link">
            @svg('grid', 'c-side-nav__icon')Gérer les sessions
        </a>
    @endif
    @if(Route::has('exam_sessions.create'))
        <a href="{{ route('exam_sessions.create') }}"
           class="c-side-nav__link">
            @svg('plus-square', 'c-side-nav__icon'){{ __('exam_sessions.new_session') }}
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    @if(Route::has('locations.index'))
        <a href="{{ route('locations.index') }}" class="c-side-nav__link">
            @svg('map-pin', 'c-side-nav__icon')Gérer les implantations
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
@auth()
    <div class="c-side-nav__group">
        @if(Route::has('logout'))
            <form action="{{ route('logout') }}" method="POST" class="c-side-nav__link">
                @csrf
                @svg('log-out', 'c-side-nav__icon')<button type="submit" class="link">{{ __('auth.logout') }}</button>
            </form>
        @endif
    </div>
@endauth
