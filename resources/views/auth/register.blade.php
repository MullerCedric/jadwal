@extends('layouts.logged_out')

@section('title', __('auth.register'))

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="guest-main__form_group">
            <label for="name" class="guest-main__form_label">{{ __('auth.name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="guest-main__form_input @error('name') is-invalid @enderror"
                   placeholder="John Doe" required autocomplete="name" autofocus>
            @error('name')
            <span role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="guest-main__form_group">
            <label for="email" class="guest-main__form_label">{{ __('auth.email_address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="guest-main__form_input @error('email') is-invalid @enderror"
                   placeholder="email@gmail.com" required autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="guest-main__form_group">
            <label for="password" class="guest-main__form_label">{{ __('auth.password') }}</label>
            <input id="password" type="password" name="password"
                   class="guest-main__form_input @error('password') is-invalid @enderror"
                   placeholder="•••••••••" required autocomplete="new-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="guest-main__form_group">
            <label for="password-confirm" class="guest-main__form_label">{{ __('auth.confirm_password') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" class="guest-main__form_input"
                   placeholder="•••••••••" required autocomplete="new-password">
        </div>

        <div class="guest-main__form_group">
            <button type="submit">
                {{ __('auth.register') }}
            </button>
        </div>

        @if (Route::has('login'))
            <p>
                <a href="{{ route('login') }}">
                    {{ __('auth.already_registered') }}
                </a>
            </p>
        @endif
    </form>
@endsection
