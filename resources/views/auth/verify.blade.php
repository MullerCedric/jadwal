@extends('layouts.logged_out')

@section('title', __('auth.verify_your_email'))

@section('content')
    @if (session('resent'))
        <div role="alert">
            {{ __('auth.verification_link_sent') }}
        </div>
    @endif

    <p>{{ __('auth.check_for_verification_link') }}</p>
    <p>{{ __('auth.if_email_not_received') }},</p>
    <form class="d-inline" method="POST" action="{{--{{ route('verification.resend') }}--}}" class="o-form">
        @csrf
        <button type="submit" class="o-form__submit cta">
            {{ __('auth.click_to_send_another') }}
        </button>
    </form>
@endsection
