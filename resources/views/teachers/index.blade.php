@extends('layouts.app')

@section('title', 'Les professeurs')

@section('content')
    @component('components/letter-pagination', [
    'letters' => $letterPagination,
    'currLetter' => $currLetter])
    @endcomponent
    <ul class="c-tchr-list">
        @forelse($teachers as $teacher)
            <li class="c-tchr-list__item">
                <div class="c-tchr-list__title">
                    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}">
                        {{ $teacher->name }}
                    </a>
                </div>
                <div class="c-tchr-list__locations">
                    Enseigne dans implantations suivantes :
                    @forelse($teacher->locations as $location)
                        <a href="{{ route('locations.show', ['location' => $location->id]) }}">{{
                                $location->name
                            }}</a>@if(!$loop->last), @endif
                    @empty
                        /
                    @endforelse
                </div>
                <div class="c-tchr-list__actions">
                    <a href="{{ route('teachers.edit', ['teacher' => $teacher->id]) }}"
                       class="button button--small">
                        Modifier
                    </a>
                    <a href="{{ route('teachers.show', ['teacher' => $teacher->id]) }}"
                       class="button button--small">
                        Voir
                    </a>
                </div>
            </li>
        @empty
            <li>
                Aucun professeur actuellement
            </li>
        @endforelse
    </ul>
    {{ $teachers->onEachSide(2)->appends(request()->input())->links() }}
@endsection

@section('sidebar')
    @component('components/sidebar-teachers', ['current' => 'index'])
    @endcomponent
@endsection
