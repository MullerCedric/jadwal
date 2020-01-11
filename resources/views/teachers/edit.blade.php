@extends('layouts.app')

@section('title', 'Modifier les informations de "' . $teacher->name . '"')

@section('content')
    <form method="post" action="{{ route('teachers.update', ['teacher' => $teacher->id]) }}" class="o-form">
        @csrf
        @method('PUT')
        <label for="name" class="o-form__label">Nom complet</label>
        <input id="name" type="text" name="name" value="{{ old('name') ?? $teacher->name }}"
               class="o-form__input @error('name') is-invalid @enderror"
               placeholder="Myriam Dupont" required autofocus>
        @error('name')
            <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="email" class="o-form__label">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') ?? $teacher->email }}"
               class="o-form__input @error('email') is-invalid @enderror"
               placeholder="myriam.dupont@hepl.be" required>
        @error('email')
            <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        @if($allLocations && $allLocations->isNotEmpty())
            <div class="o-form__label">Fais partie des implantations</div>
            <ul class="c-small-list">
                @foreach($allLocations as $location)
                    <li>
                        <input type="checkbox" name="location{{ $location->id }}" id="location{{ $location->id }}"
                               class="o-form__input"
                            {{ (old('location' . $location->id) || $teacher->locations->contains($location)) ? 'checked' : '' }}>
                        <label for="location{{ $location->id }}">{{ $location->name }}</label>
                    </li>
                @endforeach
            </ul>
            @error('locations')
            <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @endif

        <button type="submit" class="o-form__submit cta">
            Enregistrer les modifications
        </button>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-teachers', ['current' => 'edit', 'teacher' => $teacher])
    @endcomponent
@endsection
