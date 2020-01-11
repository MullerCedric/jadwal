@extends('layouts.app')

@section('title', 'Ajouter un professeur')

@section('content')
    <form method="post" action="{{ route('teachers.store') }}" class="o-form">
        @csrf
        <label for="name" class="o-form__label">Nom complet</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}"
               class="o-form__input @error('name') is-invalid @enderror"
               placeholder="Myriam Dupont" required autofocus>
        @error('name')
            <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="email" class="o-form__label">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
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
                            {{ (old('location' . $location->id) ?? ($allLocations->count() === 1 ||
                                (session('lastAction')
                                && session('lastAction')['resource']['type'] === 'location'
                                && session('lastAction')['resource']['value']->id === $location->id)))
                            ? 'checked' : '' }}>
                        <label for="location{{ $location->id }}">{{ $location->name }}</label>
                    </li>
                @endforeach
            </ul>
            @foreach($allLocations as $location)
                @error('location' . $location->id)
                    <span class="o-form__error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endforeach
        @endif

        <div class="o-form__label">ou</div>
        <div class="o-form__input">
            <a href="{{ route('locations.create') }}">créer une nouvelle implantation</a>
        </div>

        <button type="submit" class="o-form__submit cta">
            Ajouter le professeur
        </button>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-teachers', ['current' => 'create'])
    @endcomponent
@endsection
