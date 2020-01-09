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
        <b>Message {{ $message->isSent() ? 'a été' : 'sera' }} envoyé à</b> l'implantation
        <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}">
            {{ $message->examSession->location->name }}
        </a> regroupant <i
            title="La liste affichée ici est une liste dynamique et affiche donc l'état actuel de l'implantation et non celle au moment de l'envoi">actuellement</i>
        @component('components/listing-teachers', [
        'total_count' => $message->examSession->location->teachers->count(),
        'teachers' => $message->examSession->location->teachers])
            @slot('none')
                aucun professeur.
            @endslot
            @slot('singular')@endslot
            @slot('plural')@endslot
        @endcomponent
        @if($message->examSession->location->teachers->count() > 3)
            <a href="{{ route('locations.show', ['location' => $message->examSession->location->id]) }}"
               class="button button--small">
                Voir l'ensemble des professeurs
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
