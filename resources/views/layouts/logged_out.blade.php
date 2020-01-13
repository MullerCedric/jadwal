<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Jadwal') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="content o-layout--centered">
    <div class="c-app-name">
        @if (Route::has('login'))
            <a href="{{ route('login') }}" class="c-app-name__link">
                {{ config('app.name', 'Jadwal') }}
            </a>
        @else
            <span class="c-app-name__link">{{ config('app.name', 'Jadwal') }}</span>
        @endif
    </div>
    <div class="o-wrapper guest-main">
        <header class="guest-header">
            <h1 class="guest-header__heading">@yield('title')</h1>
        </header>
        <main id="content">
            @yield('content')
        </main>
    </div>
</div>

<!-- Scripts -->
@routes
<script src="{{ asset('js/app.js') }}" defer></script>
<script type="text/javascript">
    if (localStorage.getItem('userApiToken')) {
        localStorage.removeItem('userApiToken');
    }
</script>
</body>
</html>
