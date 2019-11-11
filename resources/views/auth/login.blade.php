@extends('layouts.logged_out')

@section('title', __('auth.login'))

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="guest-main__form_group">
            <label for="email" class="guest-main__form_label">{{ __('auth.email_address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="guest-main__form_input @error('email') is-invalid @enderror"
                   placeholder="email@gmail.com" required autocomplete="email" autofocus>
            @error('email')
            <span role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="guest-main__form_group">
            <label for="password" class="guest-main__form_label">{{ __('auth.password') }}</label>
            <input id="password" type="password" name="password"
                   class="guest-main__form_input @error('password') is-invalid @enderror"
                   placeholder="•••••••••" required autocomplete="current-password">
            @error('password')
            <span role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="guest-main__form_group">
            <label for="remember" class="guest-main__form_label">{{ __('auth.remember_me') }}</label>
            <input type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
        </div>

        <div class="guest-main__form_group">
            <button type="submit">
                {{ __('auth.login') }}
            </button>
        </div>
        @if (Route::has('register'))
            <p>
                <a href="{{ route('register') }}">
                    {{ __('auth.no_account') }}
                </a>
            </p>
        @endif
        @if (Route::has('password.request'))
            <p>
                <a href="{{ route('password.request') }}">
                    {{ __('auth.forgotten_password') }}
                </a>
            </p>
        @endif
    </form>
@endsection
