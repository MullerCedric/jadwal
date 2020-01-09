@extends('layouts.app')

@section('title', 'Les sessions d\'examens')
@section('main-type', 'main-main--index')

@section('content')
    <nav>
        <h2 class="sr-only">Voir les sessions...</h2>
        <div class="c-tabs">
            <a href="{{ route('exam_sessions.index') }}"
               class="c-tabs__tab{{ $currentTab !== 'closed' ? ' c-tabs__tab--current' : ''}}">
                En cours
            </a>
            <a href="{{ route('closed_exam_sessions.index') }}"
               class="c-tabs__tab{{ $currentTab === 'closed' ? ' c-tabs__tab--current' : ''}}">
                Clôturées
            </a>
        </div>
    </nav>
    @forelse($examSessions as $examSession)
        @component('components/card-session', [
        'examSession' => $examSession,
        'today' => $today])
        @endcomponent
    @empty
        <div>
            {{ $currentTab !== 'closed'
                ? 'Aucune session n\'a été créée actuellement'
                : 'Aucune session n\'a été clôturée actuellement'
            }}
        </div>
    @endforelse
    <div class="c-pagination">
        @if($currentTab !== 'closed')
            <a href="{{ route('exam_sessions.create') }}" class="button button--small">
                {{ __('exam_sessions.new_session') }}
            </a>
        @endif
        {{ $examSessions->onEachSide(2)->appends(request()->input())->links() }}
    </div>
@endsection

@section('sidebar')
    @component('components/sidebar-exam_sessions', ['current' => 'index'])
    @endcomponent
@endsection
