@extends('layouts.app')

@if($token)
    @section('title', 'Vos préférences concernant ' . $preference->examSession->title)
@else
    @section('title', 'Préférences de ' . $teacher->name)
@endif

@section('content')
    <p>
        Haute École de la Province de Liège, {{ $examSession->location->name }}
    </p>
    <p>
        {{ $examSession->title }}
    </p>
    @if(auth()->user() && $examSession->id === auth()->user()->id && $examSession->preferences->isNotEmpty())
        <p>
            Nom du professeur : <span class="no-js-only">{{ $teacher->name }}</span>
            <select id="redirectSelector" class="js-only js-only--inline">
                @foreach($examSession->preferences as $otherPreference)
                    <option value="{{ $otherPreference->id }}"
                        {{ $preference->id === $otherPreference->id ? 'selected':'' }}>
                        {{ $otherPreference->teacher->name }}
                    </option>
                @endforeach
            </select>
        </p>
    @else
        <p>
            Nom du professeur : <span>{{ $teacher->name }}</span>
        </p>
    @endif
    @if($preference->isSent())
        <p>
            Ces préférences ont été envoyées le {{ $preference->sent_at->format('d/m/y') }}
        </p>
    @endif
    @if($examSession->indications)
        <div class="c-message">
            @markdown($examSession->indications)
        </div>
    @endif
    @if($preference->values)
        <div class="table__outer">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Intitulé EXACT du cours</th>
                    <th scope="col">
                        <p>Groupes</p>
                        <p class="c-smaller">Indications supplémentaires</p>
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
        </div>
    @else
        <p><strong>Aucune préférence n'a été enregistrée</strong></p>
    @endif
    @if($preference->about)
        <section>
            <h2>Demandes particulières/indisponibilités/contraintes</h2>
            <p>
                {{ $preference->about }}
            </p>
        </section>
    @endif

    @if($preference->isValidated() && !$preference->isSent())
        <form action="{{ route('send_preferences.send', ['preference' => $preference->id, 'token' => $token]) }}"
              method="POST">
            @csrf
            <button type="submit" class="cta">
                @svg('send', 'c-side-nav__icon')Envoyer ces préférences
            </button>
        </form>
    @endif
@endsection

@section('sidebar')
    @if($token)
        @component('components/sidebar-preferences', [
            'current' => 'show',
            'token' => $token,
            'examSession' => $examSession,
            'preference' => $preference,
            'teacher' => $teacher,
            'emptyExamSessions' => $emptyExamSessions
        ])
        @endcomponent
    @else
        @component('components/sidebar-preferences-user', [
            'current' => 'show',
            'preference' => $preference,
            'examSession' => $examSession,
            'teacher' => $teacher])
        @endcomponent
    @endif
@endsection
