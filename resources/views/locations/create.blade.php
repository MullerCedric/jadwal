@extends('layouts.app')

@section('title', 'Ajouter une implantation')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('locations.store') }}" class="o-form" enctype="multipart/form-data">
        @csrf
        <label for="name" class="o-form__label">Nom de l'implantation</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}"
               class="o-form__input @error('name') is-invalid @enderror"
               placeholder="INPRES" required autofocus>
        @error('name')
        <span class="o-form__error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        @if($allTeachers && $allTeachers->isNotEmpty())
            <div class="o-form__label">Ajouter des professeurs d'autres implantations</div>
            <ul style="max-height: 175px; overflow: auto; padding: 0; margin: 0;">
                @foreach($allTeachers as $teacher)
                    <li>
                        <input type="checkbox" name="teacher{{ $teacher->id }}" id="teacher{{ $teacher->id }}"
                               class="o-form__input"
                            {{ old('teacher' . $teacher->id) ? 'checked' : '' }}>
                        <label for="teacher{{ $teacher->id }}">{{ $teacher->name }}</label>
                    </li>
                @endforeach
            </ul>
        @endif

        <hr class="o-form__full">

        <label for="from_file" class="o-form__label">Importer des professeurs via un fichier</label>
        <input id="from_file" type="file" name="from_file" value="{{ old('from_file') }}"
               class="o-form__input @error('from_file') is-invalid @enderror">
        @error('from_file')
        <span class="o-form__error" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="o-form__label">En cas de conflit</div>
        <div class="o-form__input">
            <div class="o-form__input">
                <label for="keep_file_data" class="o-form__label">Écraser les données par celles du fichier</label>
                <input type="radio" name="when_conflict" id="keep_file_data" value="keep_file_data"
                    {{ old('when_conflict') !== 'keep_db_data' ? 'checked' : '' }}>
            </div>
            <div class="o-form__input">
                <label for="keep_db_data" class="o-form__label">Garder les données de la base de données</label>
                <input type="radio" name="when_conflict" id="keep_db_data" value="keep_db_data"
                    {{ old('when_conflict') === 'keep_db_data' ? 'checked' : '' }}>
            </div>
        </div>
        @error('when_conflict')
        <span class="o-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <button type="submit" class="o-form__submit cta">
            Enregistrer l'implantation
        </button>
    </form>
@endsection

@section('sidebar')
    @component('components/sidebar-locations', ['current' => 'create'])
    @endcomponent
@endsection
