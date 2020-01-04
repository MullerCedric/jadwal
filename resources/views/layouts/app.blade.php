<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Jadwal') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<header class="main-header">
    <a class="sr-only-focusable" href="#main-nav">Navigation rapide</a>
    @if(View::hasSection('sidebar'))
        <a class="sr-only-focusable" href="#side-nav">Navigation secondaire</a>
    @endif
    <div class="o-wrapper">
        <h1>@yield('title')</h1>
    </div>
    @if(!empty(session('notifications')))
        @component('components.notifications-list', ['notifications' => session('notifications')])
        @endcomponent
    @endif
</header>
<div id="content" class="content o-wrapper o-layout--holy">
    <main class="main-main @yield('main-type')">
        @yield('content')
    </main>
    @if(View::hasSection('sidebar'))
        <div id="side-nav" class="sidebar c-side-nav">
            @yield('sidebar')
        </div>
    @endif
</div>
<footer class="main-footer">
    @component('components.main-nav')
    @endcomponent
</footer>
</body>
</html>
