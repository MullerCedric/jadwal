@if(($current === 'show' || $current === 'edit') && isset($preference))
    <div class="c-side-nav__group">
        @if($token)
            @if($preference->isValidated() && !$preference->isSent())
                <form action="{{ route('send_preferences.send', ['preference' => $preference->id, 'token' => $token]) }}"
                      method="POST" class="link c-side-nav__link">
                    @csrf
                    <button type="submit" class="link">@svg('send', 'c-side-nav__icon')Envoyer ces préférences</button>
                </form>
            @endif
            <a href="{{ route('preferences.show', ['preference' => $preference->id, 'token' => $token]) }}"
               class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
                @svg('eye', 'c-side-nav__icon')Voir ces préférences
            </a>
            @if(!$preference->isSent())
                <a href="{{ route('preferences.edit', ['preference' => $preference->id, 'token' => $token]) }}"
                   class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
                    @svg('edit-3', 'c-side-nav__icon')Modifier ces préférences
                </a>
            @endif
            @if($current === 'show' && isset($examSession) && isset($emptyExamSessions))
                @if($preference->isSent())
                    <a href="{{ route('confirm.show', ['confirmBoxId' => 'fromPreference' . $preference->id]) }}"
                       class="c-side-nav__link">
                        @svg('copy-2',
                        'c-side-nav__icon')<span>Repartir de ces préférences pour une autre session</span>
                    </a>

                    @section('fromPreference' . $preference->id)
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
                    @endsection
                @endif

                <a href="{{ route('preferences.index', ['token' => $token]) }}"
                   class="c-side-nav__link">
                    @svg('list', 'c-side-nav__icon')Gérer vos préférences
                </a>
            @endif
        @else
            <a href="{{ route('preferences.show', ['preference' => $preference->id]) }}"
               class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
                @svg('eye', 'c-side-nav__icon')Voir ces préférences
            </a>
            @if($preference->isSent())
                <a href="{{ route('preferences.edit', ['preference' => $preference->id]) }}"
                   class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
                    @svg('edit-3', 'c-side-nav__icon')Modifier ces préférences
                </a>
            @endif
        @endif
    </div>
@endif
@if($current === 'create' || $current === 'edit')
    @if(isset($token) && isset($preferences) && isset($examSession))
        <div class="c-side-nav__group">
            @for($i = 0; $i < count($preferences) && $i < 3; $i++)
                <a href="{{ route('confirm.show', ['confirmBoxId' => 'fromPreference' . $preferences[$i]->id]) }}"
                   class="c-side-nav__link">
                    @svg('copy-2',
                    'c-side-nav__icon')<span>Repartir des préférences envoyées pour <i>{{ $preferences[$i]->examSession->title }}</i></span>
                </a>

                @section('fromPreference' . $preferences[$i]->id)
                    @component('components/confirm-box', [
                        'action' => route('preferences.copy', ['token' => $token, 'preference' => $preferences[$i]->id])
                    ])
                        Repartir des préférences envoyées pour <i>{{ $preferences[$i]->examSession->title }}</i> et les
                        utiliser pour {{ $examSession->title }}
                        <input type="hidden" name="targeted_exam_session" value="{{ $examSession->id }}">
                        <p class="c-smaller">
                            Attention : si vous aviez commencé un brouillon pour la session sélectionnée, les
                            données seront écrasées par la copie que vous pourrez modifier avant de valider
                        </p>
                        @slot('actions')
                            <button type="submit" class="button--small cta">Copier</button>
                        @endslot
                    @endcomponent
                @endsection
            @endfor
            <a href="{{ route('preferences.index', ['token' => $token]) }}"
               class="c-side-nav__link">
                @svg('list',
                'c-side-nav__icon'){{ count($preferences) < 4 ? 'Gérer vos préférences' : 'Afficher plus de préférences' }}
            </a>
        </div>
    @endif
@endif
