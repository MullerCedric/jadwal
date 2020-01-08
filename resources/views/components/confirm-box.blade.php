<div class="c-confirm-box__container">
    <form class="c-confirm-box" action="{{ $action ?? '#' }}" method="{{ $method ?? 'POST' }}">
        @if(isset($method) && ($method === 'DELETE' || $method === 'PUT'))
            @method($method)
        @endif
        @csrf
        <main class="c-confirm-box__body">
            {{ $slot ?? 'Êtes-vous sûr ?' }}
        </main>
        <div class="c-confirm-box__actions">
            {{ $actions ?? '' }}
            <a href="{{ route('confirm.cancel') }}"
               class="button button--small">
                Annuler
            </a>
        </div>
    </form>
</div>
