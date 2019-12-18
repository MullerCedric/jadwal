@extends('layouts.logged_out')

@section('title', __('auth.reset_password'))

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="o-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email" class="o-form__label">{{ __('auth.email_address') }}</label>
        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
               class="o-form__input @error('email') is-invalid @enderror"
               required autocomplete="email" autofocus>
        @error('email')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="password" class="o-form__label">{{ __('auth.password') }}</label>
        <input id="password" type="password" name="password"
               class="o-form__input @error('password') is-invalid @enderror"
               placeholder="•••••••••" required autocomplete="new-password">
        @error('password')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="password-confirm" class="o-form__label">{{ __('auth.confirm_password') }}</label>
        <input id="password-confirm" type="password" name="password_confirmation" class="o-form__input"
               placeholder="•••••••••" required autocomplete="new-password">

        <button class="o-form__submit" type="submit">
            {{ __('auth.reset_password') }}
        </button>
    </form>
@endsection
