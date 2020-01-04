@extends('layouts.app')

@section('title', 'Les implantations')
@section('main-type', 'main-main--index')

@section('content')
    <div>
        <div class="o-card--grid">
            @forelse($locations as $location)
                @component('components/card-location', [
                'location' => $location])
                @endcomponent
            @empty
                <div>
                    Aucune implantation actuellement
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('sidebar')
    @component('components/sidebar-locations', ['current' => 'index'])
    @endcomponent
@endsection
