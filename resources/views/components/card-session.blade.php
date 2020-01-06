<article class="c-card">
    <header class="c-card__header">
        <h2>
            <div class="c-card__title">
                <a href="{{ route('exam_sessions.show', ['id' => $examSession->id]) }}">
                    {{ $examSession->title }}<span class="sr-only">, </span>
                </a>
            </div>
            <div class="c-card__subtitle">
                <a href="{{ route('locations.show', ['location' =>$examSession->location->id]) }}">
                    {{ $examSession->location->name }}
                </a>
            </div>
        </h2>
        {{--<div class="c-more">
            <a class="c-more__link">
                @svg('more-vertical', '')
            </a>
        </div>--}}
    </header>

    <main class="c-card__main">
        @if($examSession->isValidated() && $examSession->isSent())
            @component('components/timeline', [
            'sent_at' => $examSession->sent_at,
            'today' => $today,
            'deadline' => $examSession->deadline,
            'deleted_at' => $examSession->deleted_at])
            @endcomponent
            @component('components/listing-teachers', [
            'total_count' => $examSession->sent_preferences_count,
            'teachers' => $examSession->location->sentTeachers])
                    @slot('none')
                        Aucun professeur n'a envoyé ses préférences
                    @endslot
                    @slot('singular')
                        a envoyé ses préférences
                    @endslot
                    @slot('plural')
                        ont envoyé leurs préférences
                    @endslot
            @endcomponent
        @else
            <p>
                Cette session est à l'état de brouillon
            </p>
        @endif
    </main>

    <footer class="c-card__footer">
        <div>
            <span
                title="{{ $examSession->sent_preferences_count }} des {{ $examSession->location->teachers->count() }} professeurs ont complété leurs préférences pour cette session"
                class="c-card__percent {{ $examSession->percent() < 70 ? 'c-card__percent--low' : '' }} {{ $examSession->percent() == 100 ? 'c-card__percent--high' : '' }}">
                {{ $examSession->percent() }}%
            </span>
        </div>
        <div>
            <form method="POST"
                  action="{{ route('closed_exam_sessions.store', ['exam_session' => $examSession->id]) }}">
                @csrf
                @method('DELETE')
                @if(!$examSession->deleted_at)
                    @if($examSession->isValidated() && $examSession->isSent())
                        @if($examSession->sent_preferences_count < $examSession->location->teachers->count())
                            @if($examSession->deadline->startOfDay() <= $today->copy()->addDay(4)->startOfDay())
                                <a href="{{ route('messages.create') }}" class="button--small cta"
                                   title="Écrire un nouveau message aux professeurs n'ayant pas envoyé leurs préférences">
                                    Rappel
                                </a>
                            @else
                                <a href="{{ route('messages.create') }}" class="button button--small"
                                   title="Écrire un nouveau message aux professeurs n'ayant pas envoyé leurs préférences">
                                    Rappel
                                </a>
                            @endif
                        @endif
                        @if($examSession->deadline->startOfDay() <= $today->startOfDay())
                            @if($examSession->sent_preferences_count == $examSession->location->teachers->count())
                                <button type="submit" class="button--small cta"
                                        title="Clôturer définitivement cette session">
                                    Clôturer
                                </button>
                            @else
                                <button type="submit" class="button button--small"
                                        title="Clôturer définitivement cette session">
                                    Clôturer
                                </button>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('exam_sessions.edit', ['exam_session' => $examSession->id]) }}"
                           class="button button--small">
                            Modifier
                        </a>
                    @endif
                @endif
                <a href="{{ route('exam_sessions.show', ['id' => $examSession->id]) }}"
                   class="button button--small">
                    Voir
                </a>
            </form>
        </div>
    </footer>
</article>
