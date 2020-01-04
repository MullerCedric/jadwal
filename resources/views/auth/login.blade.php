@extends('layouts.logged_out')

@section('title', __('auth.login'))

@section('content')
    <form method="POST" action="{{ route('login') }}" class="o-form">
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

        <label for="password" class="o-form__label">{{ __('auth.password') }}</label>
        <input id="password" type="password" name="password"
               class="o-form__input @error('password') is-invalid @enderror"
               placeholder="•••••••••" required autocomplete="current-password">
        @error('password')
        <span class="o-form__error" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="remember" class="o-form__label">{{ __('auth.remember_me') }}</label>
        <input type="checkbox" name="remember" id="remember" class="o-form__input"
            {{ old('remember') ? 'checked' : '' }}>

        <button type="submit" class="o-form__submit cta">
            {{ __('auth.login') }}
        </button>
    </form>

    @if (Route::has('register'))
        <p class="c-smaller">
            <a href="{{ route('register') }}">
                {{ __('auth.no_account') }}
            </a>
        </p>
    @endif
    @if (Route::has('password.request'))
        <p class="c-smaller">
            <a href="{{ route('password.request') }}">
                {{ __('auth.forgotten_password') }}
            </a>
        </p>
    @endif
@endsection
