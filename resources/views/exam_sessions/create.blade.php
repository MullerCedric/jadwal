@extends('layouts.app')

@section('title', 'Créer une nouvelle session')

@section('content')
    <form method="post" action="{{ route('exam_sessions.store') }}" class="o-form" id="storeForm">
        @csrf
        <label for="location" class="o-form__label">Implantation</label>
        <select id="location" name="location" required autofocus
                class="o-form__input @error('location') is-invalid @enderror">
            @foreach($locations as $location)
                <option value="{{ $location->id }}"
                    {{ (old('location') == $location->id ? 'selected':'') }}>
                    {{ $location->name }}
                </option>
            @endforeach
        </select>
        @error('location')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="title" class="o-form__label">Nom de la session</label>
        <input id="title" type="text" name="title" value="{{ old('title') }}"
               class="o-form__input @error('title') is-invalid @enderror"
               placeholder="Session d'examens de janvier 2020">
        @error('title')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="indications" class="o-form__label">Indications supplémentaires</label>
        <textarea id="indications" name="indications"
                  class="o-form__input @error('indications') is-invalid @enderror"
                  placeholder="Période d'examens du 06/01 au 24/01/2020"
        >{{ old('indications') }}</textarea>
        @error('indications')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="deadline" class="o-form__label">Date limite</label>
        <input id="deadline" type="date" name="deadline" value="{{ old('deadline') }}"
               class="o-form__input @error('deadline') is-invalid @enderror"
               placeholder="Liste et modalités examens de janvier 2020">
        @error('deadline')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <button type="submit" class="o-form__submit cta">
            Passer à l'étape suivante
        </button>
        <p class="o-form__full">
            ou <button type="submit" class="link" formaction="{{ route('draft_exam_sessions.store') }}">enregistrer en tant que brouillon</button>
        </p>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-exam_sessions', ['current' => 'create'])
    @endcomponent
@endsection
