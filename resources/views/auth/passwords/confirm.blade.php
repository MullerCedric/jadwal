@extends('layouts.logged_out')

@section('title', __('auth.confirm_password'))

@section('content')
    {{ __('auth.please_confirm_password') }}

    <form method="POST" action="{{ route('password.confirm') }}" class="o-form">
        @csrf

        <label for="password" class="o-form__label">{{ __('auth.password') }}</label>
        <input id="password" type="password" name="password"
               class="o-form__input @error('password') is-invalid @enderror"
               placeholder="•••••••••" required autocomplete="current-password">
        @error('password')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <button type="submit" class="o-form__submit cta">
            {{ __('auth.confirm_password') }}
        </button>
    </form>
    @if (Route::has('password.request'))
        <p>
            <a href="{{ route('password.request') }}">
                {{ __('auth.forgotten_password') }}
            </a>
        </p>
    @endif
    @if (Route::has('register'))
        <p>
            <a href="{{ route('register') }}">
                {{ __('auth.no_account') }}
            </a>
        </p>
    @endif
@endsection
