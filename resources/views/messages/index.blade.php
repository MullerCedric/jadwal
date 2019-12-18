@extends('layouts.app')

@section('title', 'Les messages')

@section('content')
    @if ($messages && !$messages->isEmpty())
        @foreach($messages as $message)
            <article class="c-session-short">
                <header class="c-session-short__head">
                    <h2 class="c-session-short__heading">
                        <span>
                            <a href="{{ route('messages.show', ['message' => $message->id]) }}">
                                {{ $message->title }}
                            </a>
                        </span>
                    </h2>
                    <div>
                        <form method="POST"
                              action="{{ route('messages.destroy', ['message' => $message->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link">Supprimer</button>
                        </form>
                    </div>
                </header>
                <main>
                    @if($message->examSession->isValidated())
                        <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
                              method="POST">
                            @csrf
                            @if($message->isValidated() && $message->isSent())
                                <p>
                                    Ce message a été envoyé le {{ $message->sent_at->format('d/m/y') }} pour
                                    "<a href="{{ route('exam_sessions.show', ['exam_session' => $message->examSession->id]) }}">
                                        {{ $message->examSession->title }}
                                    </a>"
                                </p>
                            @elseif($message->isValidated() && !$message->isSent())
                                <p>
                                    Ce message est à l'état de brouillon. Vous pouvez
                                    <button type="submit" class="link">l'envoyer</button>
                                    ou <a href="{{ route('messages.edit', ['message' => $message->id]) }}">le
                                        modifier</a>
                                </p>
                            @else
                                <p>
                                    Ce message est à l'état de brouillon. Vous pouvez encore <a
                                        href="{{ route('messages.edit', ['message' => $message->id]) }}">le modifier</a>
                                </p>
                            @endif
                        </form>
                    @else
                        <p>
                            La <a
                                href="{{ route('exam_sessions.show', ['exam_session' => $message->examSession->id]) }}">
                                session
                            </a> associée à ce message est toujours à l'état de brouillon. <a
                                href="{{ route('exam_sessions.edit', ['exam_session' => $message->examSession->id]) }}">
                                Cliquez ici pour la terminer
                            </a> afin de pouvoir procéder à l'envoi des formulaires
                        </p>
                    @endif
                </main>
            </article>
        @endforeach
    @else
        <div>
            Aucun message actuellement
        </div>
    @endif
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'index'])
    @endcomponent
@endsection
