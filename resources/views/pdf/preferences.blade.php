<!doctype html><html lang="fr"><head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        html, body {
            display: block;
        }
    </style>
</head><body>
<h1>
    Haute École de la Province de Liège, {{ $examSession->location->name }}
</h1>
<p>
    {{ $examSession->title }}
</p>
<p>
    Nom du professeur : {{ $teacher->name }}
</p>
    <p>
        @if($preference->sent_at)
            Ces préférences ont été envoyées le {{ $preference->sent_at->format('d/m/y')  }} et ce @else Ce
        @endif PDF a été généré le {{ $currDate }}
    </p>
@if($examSession->indications)
    <div class="c-message">
        @markdown($examSession->indications)
    </div>
@endif
@if($preference->values)
<table class="table table-striped">
    <tr>
        <th scope="col">Intitulé EXACT du cours</th>
        <th scope="col">
            <p>Groupes</p>
            <p class="c-smaller">Indications</p>
        </th>
        <th scope="col">Type</th>
        <th scope="col">Locaux possibles</th>
        <th scope="col">Durée de l'examen</th>
        <th scope="col">Surveillants souhaités</th>
    </tr>
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
</table>
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
</body></html>
