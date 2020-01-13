<div class="sr-only-focusable__container">
    <a class="sr-only-focusable" href="#content">Revenir au contenu</a>
</div>
@if(isset($message))
    <div class="c-side-nav__group">
        @if(Route::has('send_messages.send') && $message->examSession->isValidated() && $message->isValidated() && !$message->isSent())
            <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
                  method="POST" class="link c-side-nav__link">
                @csrf
                @svg('send', 'c-side-nav__icon')<button type="submit" class="link">Envoyer le message</button>
            </form>
        @endif
        @if(Route::has('messages.show'))
            <a href="{{ route('messages.show', ['message' => $message->id]) }}"
               class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
                @svg('eye', 'c-side-nav__icon')Voir le message
            </a>
        @endif
        @if(Route::has('messages.edit') && !$message->isSent())
            <a href="{{ route('messages.edit', ['message' => $message->id]) }}"
               class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
                @svg('edit-3', 'c-side-nav__icon')Modifier le message
            </a>
        @endif
        @if(Route::has('confirm.show') && Route::has('messages.destroy'))
            <a href="{{ route('confirm.show', ['confirmBoxId' => 'deleteMessage']) }}"
               class="c-side-nav__link">
                @svg('trash-2', 'c-side-nav__icon')Supprimer le message

                @section('deleteMessage')
                    @component('components/confirm-box', [
                        'action' => route('messages.destroy', ['message' => $message->id]),
                        'method' => 'DELETE',
                        'cancelFirst' => true,
                        ])
                        <p>
                            Voulez-vous définitivement supprimer ce message ?
                        </p>
                        <p class="c-smaller">
                            Note: Si le message a déjà été envoyé, il sera toujours visible pour ses destinataires
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
    @if(Route::has('messages.create'))
        <a href="{{ route('messages.create') }}"
           class="c-side-nav__link{{ $current === 'create' ? ' c-side-nav__link--current' : '' }}">
            @svg('plus-square', 'c-side-nav__icon')Écrire un nouveau message
        </a>
    @endif
    @if(Route::has('messages.index'))
        <a href="{{ route('messages.index') }}"
           class="c-side-nav__link{{ $current === 'index' ? ' c-side-nav__link--current' : '' }}">
            @svg('list', 'c-side-nav__icon')Gérer les messages
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    @if(Route::has('locations.index'))
        <a href="{{ route('locations.index') }}" class="c-side-nav__link">
            @svg('map-pin', 'c-side-nav__icon')Gérer les implantations
        </a>
    @endif
    @if(Route::has('exam_sessions.index'))
        <a href="{{ route('exam_sessions.index') }}" class="c-side-nav__link">
            @svg('activity', 'c-side-nav__icon')Gérer les sessions
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
