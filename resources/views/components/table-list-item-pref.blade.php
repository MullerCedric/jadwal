<div class="c-table-list__state">
    <div class="c-table-list__state-elem">
        @if($preference && $preference->isValidated() && $preference->isSent())
            @svg('send', 'c-table-list__icon') {{ $preference->sent_at->format('d/m/y') }}
        @else
            @svg('draft', 'c-table-list__icon') brouillon
        @endif
    </div>
</div>
<div class="c-table-list__to">
    {{ $examSession->location->name }}
</div>
<div class="c-table-list__infos">
    <div class="c-table-list__title">
        {{ $examSession->title }}
    </div>
    <div class="c-table-list__session">
        Date limite {{ $examSession->deadline->diffForHumans() }}
        ({{ $examSession->deadline->format('d/m/y') }})
    </div>
    @if($preference)
        <form method="POST" class="c-table-list__actions"
              action="{{ route('send_preferences.send', ['preference' => $preference->id, 'token' => $token]) }}">
            @csrf
            @if($preference->isValidated() && !$preference->isSent())
                <button type="submit" class="button--small cta">Envoyer</button>
            @endif
            @if(!$preference->isSent())
                <a href="{{ route('preferences.edit', ['preference' => $preference->id, 'token' => $token]) }}"
                   class="button button--small">
                    Modifier
                </a>
            @endif
            <a href="{{ route('preferences.show', ['preference' => $preference->id, 'token' => $token]) }}"
               class="button button--small">
                Voir
            </a>
        </form>
    @else
        <div class="c-table-list__actions">
            <a href="{{ route('preferences.create', ['token' => $token, 'exam_session', $examSession->id]) }}"
               class="button--small cta">
                Compléter
            </a>
        </div>
    @endif
</div>
