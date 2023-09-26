<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start align-items-center h-100">
                    <ul class="list-group text-center">
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.articles.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Artikelen</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Categorieën</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.projects.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Projecten</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.roles.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Rollen</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Uitloggen</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10">
                <div class="d-flex flex-column justify-content-start">
                    <div class="card">
                        <div class="card-header fs-3">
                            Categorie Aanpassen
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.categories.update', ['category' => $category]) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Naam</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $category->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label ">Omschrijving</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ $category->description }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Afbeelding</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image">


                                    @if ($category->image && $category->image != 'images/categories/placeholder.png')
                                        <p>Huidige afbeelding:</p>
                                        <img src="{{ asset("images/categories/{$category->id}/{$category->image}") }}"
                                            alt="{{ $category->title }}" width="100" height="100">
                                        <label for="delete_image" class="form-label">Verwijder Afbeelding</label>
                                        <input type="checkbox" class="form-check-input" id="delete_image"
                                            name="delete_image">
                                    @elseif ($category->image == 'images/categories/placeholder.png')
                                        <p>Huidige afbeelding:</p>
                                        <img src="{{ asset('images/categories/placeholder.png') }}" alt="Placeholder"
                                            width="100" height="100">
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 d-flex justify-content-end">
                                    <a href="{{ route('dashboard.categories.index') }}"
                                        class="btn-lg btn btn-link m-2">Terug</a>
                                    <input type="submit" class="btn-lg btn btn-primary m-2" value="Categorie Bewerken">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</x-app-layout>
