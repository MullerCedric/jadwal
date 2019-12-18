@extends('layouts.app')

@section('title', 'Les implantations')

@section('content')
    @if ($locations && !$locations->isEmpty())
        @foreach($locations as $location)
            <article class="c-session-short">
                <header class="c-session-short__head">
                    <h2 class="c-session-short__heading">
                        <span>
                            <a href="{{ route('locations.show', ['location' => $location->id]) }}">
                                {{ $location->name }}
                            </a>
                        </span>
                    </h2>
                    <div>
                        <form method="POST"
                              action="{{ route('locations.destroy', ['location' => $location->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link">Supprimer</button>
                        </form>
                    </div>
                </header>
                <main>
                    <p>
                        {{ $location->teachers_count }} professeurs enseignent dans cette implantation
                    </p>
                    <p>
                        <a href="{{ route('locations.edit', ['location' => $location->id]) }}">modifier</a>
                    </p>
                </main>
            </article>
        @endforeach
    @else
        <div>
            Aucune implantation actuellement
        </div>
    @endif
@endsection

@section('sidebar')
    @component('components/sidebar-locations', ['current' => 'index'])
    @endcomponent
@endsection
