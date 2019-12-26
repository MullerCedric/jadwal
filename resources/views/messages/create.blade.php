@extends('layouts.app')

@section('title', 'Écrire un nouveau message')

@section('content')
    <div class="c-tip">
        <p>
            Écrivez ici le contenu du courriel qui sera envoyé aux professeurs de l'implantation choisie
        </p>
        <p>
            Bon à savoir : La date limite ainsi que l'URL vers la complétion du formulaire seront ajoutés à la fin du message automatiquement
        </p>
    </div>
    <form method="post" action="{{ route('messages.store') }}" class="o-form">
        @csrf
        @if(!session('payload'))
            <label for="exam_session" class="o-form__label">Session d'examens concernée</label>
            <select id="exam_session" name="exam_session" required
                    class="o-form__input @error('location') is-invalid @enderror">
                @foreach($examSessions as $examSession)
                    <option value="{{ $examSession->id }}"
                        {{ (old('exam_session') ?? null) == $examSession->id ? 'selected':'' }}>
                        {{ $examSession->location->name . ' | ' .$examSession->title }}
                    </option>
                @endforeach
            </select>
        @else
            <input type="hidden" name="exam_session" value="{{ session('payload') }}"/>
        @endif
        @error('exam_session')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="title" class="o-form__label">Titre du message</label>
        <input id="title" type="text" name="title" value="{{ old('title') }}"
               class="o-form__input @error('title') is-invalid @enderror"
               placeholder="Complétez vos préférences pour la prochaine session d\'examen"
               required autofocus>
        @error('title')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="body" class="o-form__label">Contenu du message</label>
        <textarea id="body" name="body"
                  class="o-form__input @error('body') is-invalid @enderror"
                  placeholder="Ceci concerne l’élaboration de la session d’examens de janvier 2020[...]"
        >{{ old('body') }}</textarea>
        @error('body')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <button class="o-form__submit" type="submit">
            Prévisualiser
        </button>
        <p class="o-form__full">
            ou
            <button class="link" type="submit" formaction="{{ route('draft_messages.store') }}">
                enregistrer en tant que brouillon
            </button>
        </p>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'create'])
    @endcomponent
@endsection