@extends('layouts.logged_out')

@section('title', __('auth.reset_password'))

@section('content')
    @if (session('status'))
        <div role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="o-form">
        @csrf

        <label for="email" class="o-form__label">{{ __('auth.email_address') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               class="o-form__input @error('email') is-invalid @enderror"
               placeholder="email@gmail.com" required autocomplete="email" autofocus>
        @error('email')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <button type="submit" class="o-form__submit cta">
            {{ __('auth.send_password_reset_link') }}
        </button>
    </form>
@endsection
