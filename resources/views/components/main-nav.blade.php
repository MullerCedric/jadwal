<nav class="o-wrapper c-main-nav" id="main-nav">
    <h2 class="sr-only">Navigation rapide</h2>
    <ul class="c-main-nav__list">
        <li class="sr-only"><a href="#content">Revenir au contenu</a></li>
        @auth
            @if (Route::has('dashboard'))
                <li class="c-main-nav__item">
                    <a href="{{ route('dashboard') }}" class="c-main-nav__link">
                        {{ __('Dashboard') }}
                    </a>
                </li>
            @endif
            @if (Route::has('exam_sessions.create'))
                <li class="c-main-nav__item">
                    <a href="{{ route('exam_sessions.create') }}" class="c-main-nav__link">
                        {{ __('exam_sessions.new_session') }}
                    </a>
                </li>
            @endif
            @if (Route::has('locations.index'))
                <li class="c-main-nav__item">
                    <a href="{{ route('locations.index') }}" class="c-main-nav__link">
                        {{ __('Implantations') }}
                    </a>
                </li>
            @endif
            <li class="c-main-nav__item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="c-main-nav__form">
                    @csrf
                    <button class="link c-main-nav__link">{{ __('auth.logout') }}</button>
                </form>
            </li>
        @endauth
    </ul>
</nav>
