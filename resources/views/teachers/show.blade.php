@extends('layouts.app')

@section('title', $teacher->name)

@section('content')
    <section>
        <h2>
            {{ $teacher->name }} enseigne dans les implantations suivantes&nbsp;:
        </h2>
        <ul class="c-tchr-list">
            @foreach($teacher->locations as $location)
                <li class="c-tchr-list__item c-tchr-list__item--one-line">
                    <a href="{{ route('locations.show', ['location' => $location->id]) }}">
                        {{ $location->name }}
                    </a>
                    <form method="POST" class="c-tchr-list__actions"
                          action="{{ route('locationsteachers.destroy', [
                            'location' => $location->id,
                            'id' => $teacher->id,
                            'redirect_to' => 'teachers.show'
                        ]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button--small" title="Retirer de l'implantation">
                            Retirer
                        </button>
                        <a href="{{ route('locations.edit', ['location' => $location->id]) }}"
                           class="button button--small">
                            Modifier
                        </a>
                        <a href="{{ route('locations.show', ['location' => $location->id]) }}"
                           class="button button--small">
                            Voir
                        </a>
                    </form>
                </li>
            @endforeach
        </ul>
    </section>
@endsection

@section('sidebar')
    @component('components/sidebar-teachers', ['current' => 'show', 'teacher' => $teacher])
    @endcomponent
@endsection
