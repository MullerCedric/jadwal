@extends('layouts.app')

@section('title', $location->name)

@section('content')
    <p>
        Liste des professeurs de cette implémentation&nbsp;:
    </p>
    <ul>
        @foreach($location->teachers as $teacher)
            <li>
                <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">
                    {{ $teacher->name }}
                </a>
            </li>
        @endforeach
    </ul>
    <form method="POST"
          action="{{ route('locationsteachers.destroy', ['location' => $location->id]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="link">Réinitialiser l'implantation</button>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-locations', ['current' => 'show', 'resource' => $location->name])
    @endcomponent
@endsection
