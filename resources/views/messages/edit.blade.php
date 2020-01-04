@extends('layouts.app')

@section('title', 'Modifier le message "' . $email->title . '"')

@section('content')
    <form method="post" action="{{ route('messages.store') }}" class="o-form">
        @csrf
        <label for="exam_session" class="o-form__label">Session d'examen concernée</label>
        <select id="exam_session" name="exam_session" required
                class="o-form__input @error('location') is-invalid @enderror">
            @foreach($examSessions as $examSession)
                <option value="{{ $examSession->id }}"
                    {{ (old('exam_session') ?? $email->exam_session_id) == $examSession->id ? 'selected':'' }}>
                    {{ $examSession->location->name . ' | ' .$examSession->title }}
                </option>
            @endforeach
        </select>
        @error('exam_session')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="title" class="o-form__label">Titre du message</label>
        <input id="title" type="text" name="title" value="{{ old('title')  ?? $email->title}}"
               class="o-form__input @error('title') is-invalid @enderror"
               placeholder="[Important] Session de janvier 2020"
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
        >{{ old('body') ?? $email->body }}</textarea>
        @error('body')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="hidden" name="id" value="{{ $email->id }}">

        <button type="submit" class="o-form__submit cta">
            Enregistrer les modifications
        </button>
        <p class="o-form__full">
            ou
            <button type="submit" class="link" formaction="{{ route('draft_messages.store') }}">
                enregistrer en tant que brouillon
            </button>
        </p>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'create'])
    @endcomponent
@endsection
