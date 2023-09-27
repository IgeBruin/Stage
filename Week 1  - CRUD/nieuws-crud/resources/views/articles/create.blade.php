<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            @include('_menu')

            <div class="col-md-10">
                <div class="d-flex flex-column justify-content-start">

                    <div class="card">
                        <div class="card-header fs-3">
                            Artikel Aanmaken
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.articles.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titel</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" placeholder="Titel" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="introduction" class="form-label">Introductie</label>
                                    <textarea class="form-control @error('introduction') is-invalid @enderror" id="introduction" name="introduction"
                                        rows="4" placeholder="Omschrijving">{{ old('introduction') }}</textarea>
                                    @error('introduction')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Inhoud</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4"
                                        placeholder="Inhoud">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Afbeelding</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Categorie</label>
                                    <select class="form-control categories" id="category_id" name="category_id">
                                        <option value="" selected disabled hidden>Selecteer een categorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="publication_date" class="form-label">Datum</label>
                                    <input type="date"
                                        class="form-control @error('publication_date') is-invalid @enderror"
                                        name="publication_date" id="publication_date"
                                        value="{{ old('publication_date') }}">
                                    @error('publication_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <a href="{{ route('dashboard.articles.index') }}"
                                        class="btn-lg btn btn-link m-2">Terug</a>
                                    <input type="submit" class="btn-lg btn btn-primary m-2" value="Artikel Toevoegen">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            window.addEventListener('load', () => {
                for (const name of ['content']) {
                    ClassicEditor.create(document.getElementById(name))
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
            $(document).ready(function() {
                $('.categories').select2();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection

</x-app-layout>
