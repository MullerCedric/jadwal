@extends('layouts.app')

@section('title', 'Remplissez vos préférences (' . $examSession->title . ')')

@section('content')
    <p>
        Haute École de la Province de Liège, {{ $examSession->location->name }}
    </p>
    @markdown($examSession->indications)
    <p>
        Nom du professeur : {{ $teacher->name }}
    </p>
    <form method="POST" action="{{ route('preferences.store') }}">
        @csrf
        <ul>
            <li class="o-form">
                <input type="hidden" name="count0" value="true">
                <label for="course_name0" class="o-form__label">Intitulé EXACT du cours</label>
                <input id="course_name0" type="text" name="course_name0" value="{{ old('course_name0') }}"
                       class="o-form__input @error('course_name0') is-invalid @enderror"
                       placeholder="Le suicide par la pratique - Théorie"
                       autofocus>
                @error('course_name0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="groups0" class="o-form__label">Liste COMPLÈTE des groupes concernés</label>
                <input id="groups0" type="text" name="groups0" value="{{ old('groups0') }}"
                       class="o-form__input @error('groups0') is-invalid @enderror"
                       placeholder="2181-2189">
                @error('groups0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="groups_indications0" class="o-form__label">Indications supplémentaires</label>
                <textarea id="groups_indications0" name="groups_indications0"
                          class="o-form__input @error('groups_indications0') is-invalid @enderror"
                          placeholder="Un examen par groupe ? Un seul examen pour tous ? Tous les groupes en même temps ? À répartir sur plusieurs amphis ?"
                >{{ old('groups_indications0') }}</textarea>
                @error('groups_indications0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="o-form__label">Type d'examen</div>
                <div class="o-form__input">
                    <label for="oral0" class="o-form__label">Oral</label>
                    <input type="radio" name="type0" id="oral0" value="oral"
                        {{ old('type0') === 'oral' ? 'checked' : '' }}>
                    <label for="written0" class="o-form__label">Écrit</label>
                    <input type="radio" name="type0" id="written0" value="written"
                        {{ old('type0') === 'written' ? 'checked' : '' }}>
                </div>
                @error('type0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="rooms0" class="o-form__label">Locaux possibles</label>
                <input id="rooms0" type="text" name="rooms0" value="{{ old('rooms0') }}"
                       class="o-form__input @error('rooms0') is-invalid @enderror"
                       placeholder="(AX et BX), (AE et AN)">
                @error('rooms0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="duration0" class="o-form__label">Durée de l'examen</label>
                <div class="o-form__input">
                    <input id="duration0" type="number" name="duration0" value="{{ old('duration0') }}"
                           class="o-form__input @error('duration0') is-invalid @enderror"
                           placeholder="2"
                           step="2" min="2" max="8"> heures
                </div>
                @error('duration0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="watched_by0" class="o-form__label">Surveillants souhaités</label>
                <input id="watched_by0" type="text" name="watched_by0" value="{{ old('watched_by0') }}"
                       class="o-form__input @error('watched_by0') is-invalid @enderror"
                       placeholder="Guy Lefranc et une autre personne">
                @error('watched_by0')
                <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </li>
        </ul>
        <p>
            <button type="submit" class="link" formaction="{{ route('draft_preferences.store') }}">
                Ajouter un cours
            </button>
        </p>

        <div class="o-form">

            <label for="about" class="o-form__full">Demandes particulières/indisponibilités/contraintes</label>
            <textarea id="about" name="about"
                      class="o-form__full @error('about') is-invalid @enderror"
                      placeholder="Si possible, j'aimerais que mes examens aient lieu la 2e et 3e semaine, merci !"
            >{{ old('about') }}</textarea>
            @error('about')
            <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="exam_session" value="{{ $examSession->id }}">

            <button type="submit" class="o-form__submit cta">
                Prévisualier
            </button>
            <p class="o-form__full">
                ou
                <button type="submit" class="link" formaction="{{ route('draft_preferences.store') }}">
                    enregistrer en tant que brouillon
                </button>
            </p>
        </div>
    </form>
    <p>Vous avez jusqu'au {{ $examSession->deadline->format('d/m/y') }} <strong>au plus tard</strong> pour envoyer vos
        préférences</p>
@endsection

@section('sidebar')
    @component('components/sidebar-preferences', ['current' => 'create', 'token' => $token, 'examSession' => $examSession, 'preferences' => $teacher->preferences])
    @endcomponent
@endsection
