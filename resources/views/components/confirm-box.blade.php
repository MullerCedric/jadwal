<div class="c-confirm-box__container">
    <div class="c-confirm-box">
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
    </div>
</div>
