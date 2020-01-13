<div class="c-table-list__state">
    <div class="c-table-list__state-elem">
        @if($message->isValidated() && $message->isSent())
            @svg('send', 'c-table-list__icon') {{ $message->sent_at->format('d/m/y') }}
        @else
            @svg('draft', 'c-table-list__icon') brouillon
        @endif
    </div>
</div>
<div class="c-table-list__to">
    @if($message->examSession->location)
        <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
            {{ $message->examSession->location->name }}
        </a>
    @else
        <span>/</span>
    @endif
</div>
<div class="c-table-list__infos">
    <div>
        <a href="{{ route('messages.show', ['message' => $message->id]) }}"
           class="c-table-list__title">
            {{ $message->title }}
        </a>
    </div>
    <div>
        <a href="{{ route('exam_sessions.show', ['id' => $message->examSession->id]) }}"
           class="c-table-list__session">
            {{ $message->examSession->title }}
            @if(!$message->examSession->isValidated())
                <span title="Cette session est toujours à l'état de brouillon"> ⚠️</span>
            @endif
        </a>
    </div>
    @if(!isset($showActions) || $showActions !== false)
        <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
              method="POST" class="c-table-list__actions">
            @csrf
            @if($message->examSession->isValidated() && $message->isValidated() && !$message->isSent())
                <button type="submit" class="button--small cta">Envoyer</button>
            @endif
            @if(!$message->isSent())
                <a href="{{ route('messages.edit', ['message' => $message->id]) }}"
                   class="button button--small">
                    Modifier
                </a>
            @endif
            @if($message->isValidated())
                <a href="{{ route('messages.show', ['message' => $message->id]) }}"
                   class="button button--small">
                    Voir
                </a>
            @endif
        </form>
    @endif
</div>
