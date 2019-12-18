@extends('layouts.app')

@section('title', 'Les sessions d\'examens')

@section('content')
    @if ($examSessions && !$examSessions->isEmpty())
        @foreach($examSessions as $examSession)
            <article class="c-session-short">
                <header class="c-session-short__head">
                    <h2 class="c-session-short__heading">
                        <span>
                            <a href="{{ route('locations.show', ['location' =>$examSession->location->id]) }}">
                                {{ $examSession->location->name }}
                            </a>
                        </span>
                        <span>
                            <a href="{{ route('exam_sessions.show', ['exam_session' => $examSession->id]) }}">
                                {{ $examSession->title }}
                            </a>
                        </span>
                    </h2>
                    <div>
                        <form method="POST"
                              action="{{ route('closed_exam_sessions.destroy', ['exam_session' => $examSession->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link">Supprimer</button>
                        </form>
                    </div>
                </header>
                <main>
                    @if($examSession->isValidated() && $examSession->isSent())
                        @component('components/timeline', [
                        'sent_at' => $examSession->sent_at,
                        'today' => $today,
                        'deadline' => $examSession->deadline,
                        'deleted_at' => $examSession->deleted_at])
                        @endcomponent
                        @if(!$examSession->deleted_at)
                            @if($examSession->deadline->startOfDay() <= $today->startOfDay())
                                <form method="POST"
                                      action="{{ route('closed_exam_sessions.store', ['exam_session' => $examSession->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link">
                                        Clôturer définitivement la session
                                    </button>
                                </form>
                                <p>
                                    (pop up confirm avec vue)
                                </p>
                            @endif
                            <p>
                                {{ $examSession->sent_preferences_count }}
                                des {{ $examSession->location->teachers->count() }} professeurs ont complété leurs
                                préférences pour cette session.
                                @if($examSession->sent_preferences_count < $examSession->location->teachers->count())
                                    <a href="{{ route('messages.create') }}">
                                        Écrire un message de rappel aux professeurs qui n'ont pas encore envoyé leurs
                                        préférences
                                    </a>
                                @endif
                            </p>
                        @endif
                    @elseif($examSession->isValidated() && !$examSession->isSent())
                        <p>
                            Cette session est à l'état de brouillon.
                            <a href="{{ route('exam_sessions.show', ['exam_session' => $examSession->id]) }}">
                                Cliquez ici pour terminer sa création
                            </a>
                        </p>
                    @else
                        <p>
                            Cette session est à l'état de brouillon. Vous pouvez encore la
                            <a href="{{ route('exam_sessions.edit', ['exam_session' => $examSession->id]) }}">modifier</a>
                        </p>
                    @endif
                </main>
            </article>
        @endforeach
    @else
        <div>
            Aucune session actuellement
        </div>
    @endif
@endsection

@section('sidebar')
    @component('components/sidebar-exam_sessions', ['current' => 'index'])
    @endcomponent
@endsection
