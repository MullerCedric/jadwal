@if($current === 'show')
    <div class="c-side-nav__group">
        @if (Route::has('preferences.index'))
            <a href="{{ route('preferences.index', ['token' => $token]) }}"
               class="c-side-nav__link">
                Gérer vos préférences
            </a>
        @endif
    </div>
@endif
@if($current === 'create')
    @if(isset($token) && isset($preferences) && isset($examSession))
        <div class="c-side-nav__group">
            @for($i = 0; $i < count($preferences) && $i < 3; $i++)
                <a href="{{ route('confirm.show', ['confirmBoxId' => 'fromPreference' . $preferences[$i]->id]) }}"
                   class="c-side-nav__link">
                    Repartir des préférences envoyées pour <i>{{ $preferences[$i]->examSession->title }}</i>
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
                Afficher plus de préférences
            </a>
        </div>
    @endif
@endif
