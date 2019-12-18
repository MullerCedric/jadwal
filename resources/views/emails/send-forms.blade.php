@component('mail::message')

{{ $email->body }}


@component('mail::button', [
    'url' => route('preferences.create', [
        'token' => $teacher->token,
        'exam_session' => $email->examSession->id
        ])
    ])
    Remplir mes préférences
@endcomponent

Vous avez jusqu'au {{ $email->examSession->deadline->format('d/m/y') }} **au plus tard** pour remplir le formulaire

Merci pour votre collaboration


@endcomponent
