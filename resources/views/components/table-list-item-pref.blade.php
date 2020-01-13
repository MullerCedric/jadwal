@section('fromSession' . $examSession->id)
    @if($preference)
        @component('components/confirm-box', [
            'action' => route('preferences.copy', ['token' => $token, 'preference' => $preference->id])
        ])
            Repartir des préférences envoyées pour <i>{{ $examSession->title }}</i> et les utiliser pour
            <label for="targeted_exam_session" class="sr-only">Session d'examens ciblée</label>
            <select id="targeted_exam_session" name="targeted_exam_session" required>
                @foreach($emptyExamSessions as $emptyExamSession)
                    @if(!$emptyExamSession->preferences->firstWhere('teacher_id', $teacher->id)
                        || $emptyExamSession->preferences->firstWhere('teacher_id', $teacher->id)->sent_at === NULL)
                        <option value="{{ $emptyExamSession->id }}"
                            {{ (old('targeted_exam_session') ?? null) == $emptyExamSession->id ? 'selected':'' }}>
                            {{ $emptyExamSession->title . ' | ' . $emptyExamSession->location->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            <p class="c-smaller">
                Attention : si vous aviez commencé un brouillon pour la session sélectionnée, les
                données seront écrasées par la copie que vous pourrez modifier avant de valider
            </p>
            @slot('actions')
                <button type="submit" class="button--small cta">Copier</button>
            @endslot
        @endcomponent
    @endif
@endsection

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
            @if($preference->isValidated() && $preference->isSent())
                <a href="{{ route('confirm.show', ['confirmBoxId' => 'fromSession' . $examSession->id]) }}"
                   class="button button--small">
                    Copier ces préférences
                </a>
            @endif
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
            <a href="{{ route('preferences.create', ['token' => $token, 'exam_session' => $examSession->id]) }}"
               class="button--small cta">
                Compléter
            </a>
        </div>
    @endif
</div>
