<article class="c-card">
    <header class="c-card__header">
        <h2>
            <a href="{{ route('locations.show', ['location' => $location->id]) }}">
                {{ $location->name }}
            </a>
        </h2>
    </header>

    <main class="c-card__main">
        @component('components/listing-teachers', [
        'total_count' => $location->teachers_count,
        'teachers' => $location->teachers])
            @slot('none')
                Aucune professeur n'enseigne dans cette implantation
            @endslot
            @slot('singular')
                enseigne dans cette implantation
            @endslot
            @slot('plural')
                enseignent dans cette implantation
            @endslot
        @endcomponent
    </main>

    <footer class="c-card__footer">
        <div>
        </div>
        <div>
            <a href="{{ route('locations.edit', ['location' => $location->id]) }}"
               class="button button--small">
                Modifier
            </a>
            <a href="{{ route('locations.show', ['location' => $location->id]) }}"
               class="button button--small">
                Voir
            </a>
        </div>
    </footer>
</article>
