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
<body class="no-js">
@if(!empty(session('confirmBoxId')) && session('confirmBoxId') !== 'none')
    @if(View::hasSection(session('confirmBoxId')))
        @yield(session('confirmBoxId'))
    @endif
@endif
<header class="main-header">
    @if(View::hasSection('sidebar'))
        <div class="sr-only-focusable__container">
            <a class="sr-only-focusable" href="#side-nav">Accéder à la navigation</a>
        </div>
    @endif
    <div class="o-wrapper">
        <h1>@yield('title')</h1>
    </div>
    @if(!empty(session('notifications')))
        @component('components/notifications-list', ['notifications' => session('notifications')])
        @endcomponent
    @endif
</header>
<div id="content" class="content o-wrapper o-layout--holy">
    <main class="main-main @yield('main-type')">
        <div class="main-main__content">
            @yield('content')
        </div>
    </main>
    @if(View::hasSection('sidebar'))
        <div id="side-nav" class="o-sidebar c-side-nav">
            <input type="checkbox" class="c-burger__check"/>
            <div class="c-burger__lines">
                <div class="c-burger__line"></div>
                <div class="c-burger__line"></div>
                <div class="c-burger__line"></div>
            </div>
            <div class="c-burger__content">
                @yield('sidebar')
            </div>
        </div>
    @endif
</div>

<!-- Scripts -->
@routes
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
