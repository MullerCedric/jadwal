@extends('layouts.app')

@section('title', $message->title)

@section('content')
    <div class="c-table-list">
        @component('components/table-list-item-msg', ['message' => $message, 'showActions' => false])
        @endcomponent
    </div>

    <div class="c-message">
        @markdown($message->body)
    </div>

    <p>
        Ce message {{ $message->isSent() ? 'a été' : 'sera' }} envoyé à l'implantation
        <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
            {{ $message->examSession->location->name }}
        </a> regroupant <i
            title="La liste affichée ici est une liste dynamique et affiche donc l'état actuel de l'implantation et non celle au moment de l'envoi">actuellement</i>
        @component('components/listing-teachers', [
        'total_count' => $message->examSession->location->teachers->count(),
        'teachers' => $message->examSession->location->teachers])
            @slot('none')
                aucun professeur (<a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
                    {{ $message->examSession->location->name }}
                </a> ne contient pas encore de professeurs)
            @endslot
            @slot('singular')
                de l'implantation <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
                    {{ $message->examSession->location->name }}
                </a>.
            @endslot
            @slot('plural') @if($message->examSession->location->teachers->count() > 3) professeurs @endif de l'implantation <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
                {{ $message->examSession->location->name }}
            </a>. @endslot
        @endcomponent
        @if($message->examSession->location->teachers->count() > 3)
            <a href="{{ route('locations.show', ['location' =>$message->examSession->location->id]) }}">
                Cliquez ici pour voir la liste complète
            </a>
        @endif
    </p>

    @if($message->examSession->isValidated() && $message->isValidated() && !$message->isSent())
        <form action="{{ route('send_messages.send', ['message' => $message->id]) }}"
              method="POST">
            @csrf
            <button type="submit" class="cta">@svg('send', 'c-side-nav__icon')Envoyer le message</button>
        </form>
    @endif
@endsection

@section('sidebar')
    @component('components/sidebar-messages', ['current' => 'show', 'message' => $message])
    @endcomponent
@endsection
