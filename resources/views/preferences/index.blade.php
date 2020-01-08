@extends('layouts.app')

@section('title', 'Vos préférences')

@section('content')
    <p>
        Connecté en tant que : {{ $teacher->name }}
    </p>
    <div class="c-table-list">
        @forelse($teachersExamSessions as $examSession)
            @component('components/table-list-item-pref', [
                'examSession' => $examSession,
                'preference' => $examSession->preferences->firstWhere('teacher_id', $teacher->id),
                'emptyExamSessions' => $emptyExamSessions,
                'teacher' => $teacher,
                'token' => $token])
            @endcomponent
        @empty
            <div>
                Aucune session d'examens ne nécessite vos préférences actuellement. Attendez un e-mail l'annonçant&nbsp;!
            </div>
        @endforelse
    </div>
    <div class="c-pagination">
        {{ $teachersExamSessions->onEachSide(2)->appends(request()->input())->links() }}
    </div>
@endsection
