@extends('layouts.app')

@section('title', $location->name)

@section('content')
    <section>
        <h2>
            Liste des professeurs de cette implémentation&nbsp;:
        </h2>
        <ul class="c-tchr-list">
            @foreach($location->teachers as $teacher)
                <li class="c-tchr-list__item c-tchr-list__item--one-line">
                    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">
                        {{ $teacher->name }}
                    </a>
                    <form method="POST" class="c-tchr-list__actions"
                          action="{{ route('locationsteachers.destroy', ['location' => $location->id, 'id' => $teacher->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button--small" title="Retirer de l'implantation">
                            Retirer
                        </button>
                        <a href="{{ route('teachers.edit', ['teacher' => $teacher->id]) }}"
                           class="button button--small">
                            Modifier
                        </a>
                        <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
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
    @component('components/sidebar-locations', ['current' => 'show', 'location' => $location])
    @endcomponent
@endsection
