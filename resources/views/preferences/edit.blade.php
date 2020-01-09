@extends('layouts.app')

@if($token)
    @section('title', 'Remplissez vos préférences')
@else
    @section('title', 'Préférences de ' . $preference->teacher->name)
@endif

@section('content')
    <p>
        Haute École de la Province de Liège, {{ $examSession->location->name }}
    </p>
    <p>
        {{ $examSession->title }}
    </p>
    <p>
        Nom du professeur : {{ $teacher->name }}
    </p>
    @if($examSession->indications)
        <div class="c-message">
            @markdown($examSession->indications)
        </div>
    @endif
    <form method="POST" action="{{ route('preferences.store') }}">
        @csrf
        <ul>
            @for($i = 0; $i < (count($preference->values) + 1); $i++)
                @if($i < count($preference->values) || session('add_course') === true)
                    <li class="o-form" {{ $i === count($preference->values) ? 'id=new-course' : '' }}>
                        @if($i === count($preference->values))
                            <div class="o-form__full">
                                Laissez l'ensemble des champs vides pour ignorer
                            </div>
                        @endif
                        <input type="hidden" name="count{{ $i }}" value="true">
                        <label for="course_name{{ $i }}" class="o-form__label">Intitulé EXACT du cours</label>
                        <input id="course_name{{ $i }}" type="text" name="course_name{{ $i }}"
                               value="{{ old('course_name' . $i) ?? $preference->values[$i]->course_name ?? '' }}"
                               class="o-form__input @error('course_name' . $i) is-invalid @enderror"
                               placeholder="Le suicide par la pratique - Théorie"
                            {{ (session('add_course') === true && $i === count($preference->values))
                            || (!session('add_course') && $i === 0) ? 'autofocus' : '' }}>
                        @error('course_name' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="groups{{ $i }}" class="o-form__label">Liste COMPLÈTE des groupes concernés</label>
                        <input id="groups{{ $i }}" type="text" name="groups{{ $i }}"
                               value="{{ old('groups' . $i) ?? $preference->values[$i]->groups ?? '' }}"
                               class="o-form__input @error('groups' . $i) is-invalid @enderror"
                               placeholder="2181-2189">
                        @error('groups' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="groups_indications{{ $i }}" class="o-form__label">Indications
                            supplémentaires</label>
                        <textarea id="groups_indications{{ $i }}" name="groups_indications{{ $i }}"
                                  class="o-form__input @error('groups_indications' . $i) is-invalid @enderror"
                                  placeholder="Un examen par groupe ? Un seul examen pour tous ? Tous les groupes en même temps ? À répartir sur plusieurs amphis ?"
                        >{{ old('groups_indications' . $i) ?? $preference->values[$i]->groups_indications ?? '' }}</textarea>
                        @error('groups_indications' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="o-form__label">Type d'examen</div>
                        <div class="o-form__input">
                            <label for="oral{{ $i }}" class="o-form__label">Oral</label>
                            <input type="radio" name="type{{ $i }}" id="oral{{ $i }}" value="oral"
                                {{ (old('type' . $i) ?? $preference->values[$i]->type ?? '') === 'oral' ? 'checked' : '' }}>
                            <label for="written{{ $i }}" class="o-form__label">Écrit</label>
                            <input type="radio" name="type{{ $i }}" id="written{{ $i }}" value="written"
                                {{ (old('type' . $i) ?? $preference->values[$i]->type ?? '') === 'written' ? 'checked' : '' }}>
                        </div>
                        @error('type' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="rooms{{ $i }}" class="o-form__label">Locaux possibles</label>
                        <input id="rooms{{ $i }}" type="text" name="rooms{{ $i }}"
                               value="{{ old('rooms' . $i) ?? $preference->values[$i]->rooms ?? '' }}"
                               class="o-form__input @error('rooms' . $i) is-invalid @enderror"
                               placeholder="(AX et BX), (AE et AN)">
                        @error('rooms' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="duration{{ $i }}" class="o-form__label">Durée de l'examen</label>
                        <div class="o-form__input">
                            <input id="duration{{ $i }}" type="number" name="duration{{ $i }}"
                                   value="{{ old('duration' . $i) ?? $preference->values[$i]->duration ?? '' }}"
                                   class="o-form__input @error('duration' . $i) is-invalid @enderror"
                                   placeholder="2"
                                   step="1" min="1" max="8"> heure(s)
                        </div>
                        @error('duration' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <label for="watched_by{{ $i }}" class="o-form__label">Surveillants souhaités</label>
                        <input id="watched_by{{ $i }}" type="text" name="watched_by{{ $i }}"
                               value="{{ old('watched_by' . $i) ?? $preference->values[$i]->watched_by ?? '' }}"
                               class="o-form__input @error('watched_by' . $i) is-invalid @enderror"
                               placeholder="Guy Lefranc et une autre personne">
                        @error('watched_by' . $i)
                        <span class="o-form__error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </li>
                @endif
            @endfor
        </ul>
        <p>
            <button type="submit" class="link" name="add_course" value="true"
                    formaction="{{ route('draft_preferences.store') }}">
                Ajouter un cours
            </button>
        </p>
        <div class="o-form">
            <label for="about" class="o-form__full">Demandes particulières/indisponibilités/contraintes</label>
            <textarea id="about" name="about"
                      class="o-form__full @error('about') is-invalid @enderror"
                      placeholder="Si possible, j'aimerais que mes examens aient lieu la 2e et 3e semaine, merci !"
            >{{ old('about') ?? $preference->about ?? '' }}</textarea>
            @error('about')
            <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="exam_session" value="{{ $examSession->id }}">
            <input type="hidden" name="id" value="{{ $preference->id }}">

            <button type="submit" class="o-form__submit cta">
                Prévisualiser
            </button>
            <p class="o-form__full">
                ou
                <button type="submit" class="link" formaction="{{ route('draft_preferences.store') }}">
                    enregistrer en tant que brouillon
                </button>
            </p>
        </div>
    </form>
    <p>
        Vous avez jusqu'au {{ $examSession->deadline->format('d/m/y') }} <strong>au plus tard</strong> pour envoyer vos
        préférences
    </p>
@endsection

@section('sidebar')
    @if($token)
        @component('components/sidebar-preferences', [
        'current' => 'edit',
        'token' => $token,
        'examSession' => $examSession,
        'preferences' => $teacher->preferences,
        'preference' => $preference,
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
