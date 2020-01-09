@extends('layouts.app')

@section('title', $examSession->title)

@section('content')
    <p>
        Concerne l'implantation <a href="{{ route('locations.show', ['location' =>$examSession->location->id]) }}">
            {{ $examSession->location->name }}
        </a>
    </p>
    @if($examSession->isValidated() && $examSession->isSent())
        @component('components/timeline', [
        'sent_at' => $examSession->sent_at,
        'today' => $today,
        'deadline' => $examSession->deadline,
        'deleted_at' => $examSession->deleted_at])
        @endcomponent
        <p>
            {{ $examSession->sent_preferences_count }} des {{ $examSession->location->teachers->count() }} professeurs
            ont complété leurs préférences pour cette session.
        </p>
    @else
        <p>
            Cette session est à l'état de brouillon. Vous pouvez encore la
            <a href="{{ route('exam_sessions.edit', ['exam_session' => $examSession->id]) }}">modifier</a>
        </p>
        <p>
            Cette session comporte actuellement {{ $examSession->location->teachers->count() }} professeurs
        </p>
    @endif
    <table>
        <thead class="sr-only">
        <tr>
            <th scope="col">Nom du professeur</th>
            <th scope="col">Statut des préférences</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($examSession->location->teachers as $teacher)
            <tr>
                <td><a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">{{ $teacher->name }}</a></td>
                @if($teacher->preferences_are_sent)
                    <td>Complété</td>
                    <td>
                        <a href="{{ route('preferences.show', ['preference' => $teacher->preferences->first()->id]) }}"
                           class="button button--small">
                            Consulter
                        </a>
                    </td>
                @elseif($teacher->preferences_are_draft)
                    <td>En cours de complétion</td>
                    <td>/</td>
                @else
                    <td>Non complété</td>
                    <td>/</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <section>
        <h3>Messages liés à cette session</h3>
        @if($examSession->messages->isNotEmpty())
            <table>
                <thead class="sr-only">
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">État</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                @foreach($examSession->messages as $message)
                    <tr>
                        @if($message->isSent())
                            <td>
                                <a href="{{ route('messages.show', ['message' => $message->id]) }}">{{ $message->title }}</a>
                            </td>
                            <td>Envoyé {{ $message->sent_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('messages.show', ['message' => $message->id]) }}">Voir</a>
                                @if(!$examSession->deleted_at)
                                    <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
                                          method="POST">
                                        @csrf
                                        <button type="submit" class="cta button--small">Envoyer à nouveau</button>
                                    </form>
                                @endif
                            </td>
                        @elseif($message->isValidated())
                            <td>
                                <a href="{{ route('messages.show', ['message' => $message->id]) }}">{{ $message->title }}</a>
                            </td>
                            <td>Enregistré</td>
                            <td>
                                <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
                                      method="POST">
                                    @csrf
                                    <a href="{{ route('messages.show', ['message' => $message->id]) }}"
                                       class="button button--small">
                                        Voir
                                    </a>
                                    <button type="submit"
                                            class="cta button--small"{!! $examSession->isValidated() ? '' : 'title="La session est toujours à un brouillon" disabled' !!}>
                                        Envoyer
                                    </button>
                                </form>
                            </td>
                        @else
                            <td>{{ $message->title }}</td>
                            <td>Brouillon</td>
                            <td>&nbsp;</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p>
                Aucun message lié actuellement ! <a href="{{ route('messages.create') }}">Créez-en</a> un afin d'envoyer
                les formulaires aux professeurs concernés
            </p>
        @endif
        @if($examSession->isValidated() && $examSession->isSent())
            @if($examSession->sent_preferences_count < $examSession->location->teachers->count())
                <a href="{{ route('messages.create') }}">
                    Écrire un nouveau message aux professeurs qui n'ont pas encore envoyé leurs
                    préférences
                </a>
            @endif
        @endif
    </section>
@endsection

@section('sidebar')
    @component('components/sidebar-exam_sessions', ['current' => 'show', 'examSession' => $examSession, 'today' => $today])
    @endcomponent
@endsection
