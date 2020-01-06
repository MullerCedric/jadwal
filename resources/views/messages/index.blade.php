@extends('layouts.app')

@section('title', 'Vos messages envoyés')

@section('content')
    <div class="c-table-list">
        @forelse($messages as $message)
            @component('components/table-list-item-msg', ['message' => $message])
            @endcomponent
        @empty
            <div>
                Aucun message actuellement
            </div>
        @endforelse
    </div>
    <div class="c-pagination">
        <a href="{{ route('messages.create') }}" class="button button--small">
            Écrire un nouveau message
        </a>
        {{ $messages->onEachSide(2)->appends(request()->input())->links() }}
    </div>
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'index'])
    @endcomponent
@endsection
