@extends('layouts.app')

@section('title', $teacher->name)

@section('content')
    <p>
        {{ $teacher->email }}
    </p>
    <p>
        {{ $teacher->name }} enseigne dans les implantations suivantes :
    </p>
    <ul>
        @foreach($teacher->locations as $location)
            <li>
                <a href="{{ route('locations.show', ['location' => $location->id]) }}">
                    {{ $location->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection

@section('sidebar')
    @component('components/sidebar-teachers', ['current' => 'show'])
    @endcomponent
@endsection
