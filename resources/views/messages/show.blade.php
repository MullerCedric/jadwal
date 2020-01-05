@extends('layouts.app')

@section('title', $message->title)

@section('content')
    <p>
        <b>Message destiné à</b> l'implantation
        <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
            {{ $message->examSession->location->name }}
        </a> regroupant <i
            title="La liste affichée ici est une liste dynamique et affiche donc l'état actuel de l'implantation et non celle au moment de l'envoi">actuellement</i>
        les professeurs suivants :
        @foreach($message->examSession->location->teachers as $teacher)
            <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">{{ $teacher->name }}</a>@if(!$loop->last)
                , @endif
        @endforeach
    </p>

    <div>
        @markdown($message->body)
    </div>
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
                    <button type="submit" class="cta">
                        Envoyer les formulaires
                    </button>
                </p>
                <p>
                    Ce message est à l'état de brouillon. Vous pouvez encore <a
                        href="{{ route('messages.edit', ['message' => $message->id]) }}">le modifier</a>
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
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'show', 'resource' => $message->title])
    @endcomponent
@endsection
