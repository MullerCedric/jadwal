@component('mail::message')
    # Vos préférences ont été modifiées

    Bonjour,
    vous recevez cet e-mail car les préférences que vous avez envoyés pour _{!! $preference->examSession->title !!}_ le {{ $preference->sent_at->format('d/m/y')  }} ont été modifiées par la personne gérant cette session d'examen ({{ $username }}).

    Vous trouverez attaché à ce message un PDF reprennant vos préférences telles qu'elles sont depuis ces modifications
@endcomponent
