@extends('layouts.app')

@section('title', 'Préférences de ' . $preference->teacher->name . ' concernant ' . $preference->examSession->title)

@section('content')
    <p>
        Haute École de la Province de Liège, {{ $examSession->location->name }}
    </p>
    @markdown($examSession->indications)
    <p>
        Nom du professeur : {{ $teacher->name }}
    </p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Intitulé EXACT du cours</th>
            <th scope="col">
                <p>Groupes</p>
                <p>Indications supplémentaires</p>
            </th>
            <th scope="col">Type</th>
            <th scope="col">Locaux possibles</th>
            <th scope="col">Durée de l'examen</th>
            <th scope="col">Surveillants souhaités</th>
        </tr>
        </thead>
        <tbody>
        @foreach($preference->values as $val)
            <tr>
                <td>{{ $val->course_name }}</td>
                <td>
                    <p>{{ $val->groups }}</p>
                    <p>{{ $val->groups_indications ?? '' }}</p>
                </td>
                <td>{{ $val->type === 'oral' ? 'Oral' : 'Écrit' }}</td>
                <td>{{ $val->rooms ?? '/' }}</td>
                <td>{{ $val->duration . ' heures' }}</td>
                <td>{{ $val->watched_by ?? '/' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($preference->about)
        <section>
            <h2>Demandes particulières/indisponibilités/contraintes</h2>
            <p>
                {{ $preference->about }}
            </p>
        </section>
    @endif

    <form action="{{ route('send_preferences.send', ['preference' => $preference->id, 'token' => $token]) }}"
          method="POST">
        @csrf
        @if($preference->isValidated() && $preference->isSent())
            <p>
                Ces préférences ont été envoyées le {{ $preference->sent_at->format('d/m/y') }} pour
                "<a href="{{ route('exam_sessions.show', ['exam_session' => $examSession->id]) }}">
                    {{ $examSession->title }}
                </a>"
            </p>
        @elseif($preference->isValidated() && !$preference->isSent())
            <p>
                <button type="submit">
                    Envoyer ces préférences
                </button>
            </p>
            <p>
                Ces préférences sont à l'état de brouillon. Vous pouvez encore <a
                    href="{{ route('preferences.edit', ['preference' => $preference->id, 'token' => $token]) }}">les
                    modifier</a>
            </p>
        @else
            <p>
                Ces préférences sont à l'état de brouillon. Vous pouvez encore <a
                    href="{{ route('preferences.edit', ['preference' => $preference->id, 'token' => $token]) }}">les
                    modifier</a>
            </p>
        @endif
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-exam_sessions', ['current' => 'show'])
    @endcomponent
@endsection
