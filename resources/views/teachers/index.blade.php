@extends('layouts.app')

@section('title', 'Les professeurs')

@section('content')
    @if ($teachers && !$teachers->isEmpty())
        @foreach($teachers as $teacher)
            <article class="c-session-short">
                <header class="c-session-short__head">
                    <h2 class="c-session-short__heading">
                        <span>
                            <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">
                                {{ $teacher->name }}
                            </a>
                        </span>
                    </h2>
                    <div>
                        <form method="POST"
                              action="{{ route('teachers.destroy', ['teacher' => $teacher->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link">Supprimer</button>
                        </form>
                    </div>
                </header>
                <main>
                    <p>
                        {{ $teacher->name }} enseigne dans implantations suivantes :
                        @foreach($teacher->locations as $location)
                            <a href="{{ route('locations.show', ['location' => $location->id]) }}">{{
                                $location->name
                            }}</a>@if(!$loop->last), @endif
                        @endforeach
                    </p>
                    <p>
                        <a href="{{ route('teachers.edit', ['teacher' => $teacher->id]) }}">Modifier</a>
                    </p>
                </main>
            </article>
        @endforeach
    @else
        <div>
            Aucun professeur actuellement
        </div>
    @endif
@endsection

@section('sidebar')
    @component('components/sidebar-teachers', ['current' => 'index'])
    @endcomponent
@endsection
