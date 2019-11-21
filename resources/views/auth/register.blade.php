@extends('layouts.logged_out')

@section('title', __('auth.register'))

@section('content')
    <form method="POST" action="{{ route('register') }}" class="c-form">
        @csrf
        <label for="name" class="c-form__label">{{ __('auth.name') }}</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}"
               class="c-form__input @error('name') is-invalid @enderror"
               placeholder="John Doe" required autocomplete="name" autofocus>
        @error('name')
        <span class="c-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="email" class="c-form__label">{{ __('auth.email_address') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               class="c-form__input @error('email') is-invalid @enderror"
               placeholder="email@gmail.com" required autocomplete="email">
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
            {{ __('auth.register') }}
        </button>
    </form>

    @if (Route::has('login'))
        <p>
            <a href="{{ route('login') }}">
                {{ __('auth.already_registered') }}
            </a>
        </p>
    @endif
@endsection
