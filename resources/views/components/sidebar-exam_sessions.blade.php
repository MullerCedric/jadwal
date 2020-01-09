@if(isset($examSession))
    <a href="{{ route('exam_sessions.show', ['id' => $examSession->id]) }}"
       class="c-side-nav__link{{ $current === 'show' ? ' c-side-nav__link--current' : '' }}">
        @svg('eye', 'c-side-nav__icon')Voir la session
    </a>
    <a href="{{ route('exam_sessions.edit', ['exam_session' => $examSession->id]) }}"
       class="c-side-nav__link{{ $current === 'edit' ? ' c-side-nav__link--current' : '' }}">
        @svg('edit-3', 'c-side-nav__icon')Modifier la session
    </a>
    @if(!$examSession->deleted_at && $examSession->isValidated() && $examSession->isSent())
        @if($examSession->deadline->startOfDay() <= $today->startOfDay())
            <form method="POST" class="link c-side-nav__link"
                  action="{{ route('closed_exam_sessions.store', ['exam_session' => $examSession->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="link"
                        title="Clôturer définitivement cette session">
                    @svg('x-octagon', 'c-side-nav__icon')Clôturer
                </button>
            </form>
        @endif
    @endif
    @if($examSession->isValidated() && $examSession->isSent())
        <a href="{{ route('confirm.show', ['confirmBoxId' => 'copyExamSession' . $examSession->id]) }}"
           class="c-side-nav__link">
            @svg('copy-2', 'c-side-nav__icon')Repartir de cette session

            @section('copyExamSession' . $examSession->id)
                @component('components/confirm-box', [
                    'action' => route('exam_sessions.copy', ['id' => $examSession->id]),
                    ])
                    <p>
                        Vous êtes sur le point de créer une nouvelle session en repartant de celle-ci
                    </p>
                    <p>
                        <label for="keep_message">Copier également les messages liés</label>
                        <select id="keep_message" name="keep_message" required>
                            <option value="1" selected>
                                Oui
                            </option>
                            <option value="0">
                                Non
                            </option>
                        </select>
                    </p>
                    <p class="c-smaller">
                        Note : Copier les messages ne les envoie pas automatiquement. Un envoi manuel sera nécessaire
                    </p>
                    @slot('actions')
                        <button type="submit" class="cta button--small">Copier</button>
                    @endslot
                @endcomponent
            @endsection
        </a>
    @endif
    <a href="{{ route('confirm.show', ['confirmBoxId' => 'deleteExamSession' . $examSession->id]) }}"
       class="c-side-nav__link">
        @svg('trash-2', 'c-side-nav__icon')Supprimer la session

        @section('deleteExamSession' . $examSession->id)
            @component('components/confirm-box', [
                'action' => route('closed_exam_sessions.destroy', ['exam_session' => $examSession->id]),
                'method' => 'DELETE',
                'cancelFirst' => true,
                ])
                <p>
                    Voulez-vous définitivement supprimer cette session ?
                </p>
                @slot('actions')
                    <button type="submit" class="button--small">Supprimer</button>
                @endslot
            @endcomponent
        @endsection
    </a>
@endif
<div class="c-side-nav__group">
    @if (Route::has('exam_sessions.create'))
        <a href="{{ route('exam_sessions.create') }}"
           class="c-side-nav__link{{ $current === 'create' ? ' c-side-nav__link--current' : '' }}">
            @svg('plus-square', 'c-side-nav__icon'){{ __('exam_sessions.new_session') }}
        </a>
    @endif
    @if (Route::has('exam_sessions.index'))
        <a href="{{ route('exam_sessions.index') }}"
           class="c-side-nav__link{{ $current === 'index' ? ' c-side-nav__link--current' : '' }}">
            @svg('grid', 'c-side-nav__icon')Gérer les sessions
        </a>
    @endif
</div>
<div class="c-side-nav__group">
    <a href="{{ route('locations.index') }}" class="c-side-nav__link">
        @svg('map-pin', 'c-side-nav__icon')Gérer les implantations
    </a>
    <a href="{{ route('messages.index') }}" class="c-side-nav__link">
        @svg('mail', 'c-side-nav__icon')Gérer les messages
    </a>
    <a href="{{ route('teachers.index') }}" class="c-side-nav__link">
        @svg('users', 'c-side-nav__icon')Gérer les professeurs
    </a>
</div>
