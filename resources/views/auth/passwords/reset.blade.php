@extends('layouts.logged_out')

@section('title', __('auth.reset_password'))

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="c-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email" class="c-form__label">{{ __('auth.email_address') }}</label>
        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
               class="c-form__input @error('email') is-invalid @enderror"
               required autocomplete="email" autofocus>
        @error('email')
        <span class="c-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="password" class="c-form__label">{{ __('auth.password') }}</label>
        <input id="password" type="password" name="password"
               class="c-form__input @error('password') is-invalid @enderror"
               placeholder="•••••••••" required autocomplete="new-password">
        @error('password')
        <span class="c-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="password-confirm" class="c-form__label">{{ __('auth.confirm_password') }}</label>
        <input id="password-confirm" type="password" name="password_confirmation" class="c-form__input"
               placeholder="•••••••••" required autocomplete="new-password">

        <button class="c-form__submit" type="submit">
            {{ __('auth.reset_password') }}
        </button>
    </form>
@endsection
