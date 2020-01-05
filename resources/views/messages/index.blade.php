@extends('layouts.app')

@section('title', 'Vos messages envoyés')

@section('content')
    <div class="c-msg-list">
        @forelse($messages as $message)
            <div class="c-msg-list__state">
                <div class="c-msg-list__state-elem">
                    @if($message->isValidated() && $message->isSent())
                        @svg('send', 'c-msg-list__icon') {{ $message->sent_at->format('d/m/y') }}
                    @else
                        @svg('draft', 'c-msg-list__icon') brouillon
                    @endif
                </div>
            </div>
            <div class="c-msg-list__to">
                @if($message->examSession->location)
                    <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
                        {{ $message->examSession->location->name }}
                    </a>
                @else
                    <span>/</span>
                @endif
            </div>
            <div class="c-msg-list__infos">
                <div>
                    <a href="{{ route('messages.show', ['message' => $message->id]) }}"
                       class="c-msg-list__title">
                        {{ $message->title }}
                    </a>
                </div>
                <div>
                    <a href="{{ route('exam_sessions.show', ['exam_session' => $message->examSession->id]) }}"
                       class="c-msg-list__session">
                        {{ $message->examSession->title }}
                        @if(!$message->examSession->isValidated())
                            <span title="Cette session est toujours à l'état de brouillon"> ⚠️</span>
                        @endif
                    </a>
                </div>
                <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
                      method="POST" class="c-msg-list__actions">
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
                    <a href="{{ route('messages.show', ['message' => $message->id]) }}"
                       class="button button--small">
                        Voir
                    </a>
                </form>
            </div>
        @empty
            <div>
                Aucun message actuellement
            </div>
        @endforelse
    </div>
    {{ $messages->onEachSide(2)->appends(request()->input())->links() }}
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'index'])
    @endcomponent
@endsection
