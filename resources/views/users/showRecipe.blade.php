<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __($recipe->title) }}
        </h1>
        <a href="{{ route('user.projects') }}" class="btn btn-lg d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
            </svg>
            Terug naar Overzicht
        </a>
    </x-slot>

    <div class="container mt-5">
        <div class="row  d-flex justify-content-around">
            <div class="col-md-6">
                <div class="card shadow" style="position: relative;">
                    @if ($recipe->image == 'images/recipes/placeholder.png')
                        <img src="{{ asset('images/recipes/placeholder.png') }}" alt="Placeholder"
                            class="card-img-top img-fluid" style="width: 100%; height: auto;">
                    @elseif ($recipe->image)
                        <img src="{{ asset("images/recipes/{$recipe->id}/{$recipe->image}") }}"
                            alt="{{ $recipe->title }}" class="card-img-top img-fluid"
                            style="width: 100%; height: auto;">
                    @endif
                    @can('update', $recipe)
                        <a class="btn" style="position: absolute; top: 10px; right: 10px;"
                            href="{{ route('user.recipes.editRecipe', $recipe->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path
                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                            </svg>
                        </a>
                    @endcan
                    @can('delete', $recipe)
                        <form action="{{ route('user.recipes.destroyRecipe', $recipe->id) }}" method="post"
                            class="d-inline" style="position: absolute; top: 10px; left: 10px;"
                            onsubmit="return confirm('Weet je zeker dat je dit recept wilt verwijderen?');">
                            @csrf
                            @method('delete')
                            <button class="btn" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                            </button>
                        </form>
                    @endcan

                    <div class="card-body">
                        <h2 class="card-title">{{ $recipe->title }}</h2>
                        <p class="card-text">{!! $recipe->description !!}</p>
                    </div>
                </div>

            </div>
            <div class="col-md-6 d-flex">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 card shadow justify-content-end">
                        <div class="card-body">
                            <h3 class="card-title">Ingrediënten</h3>
                            <ul class="list-group list-group-flush">
                                @foreach ($recipe->ingredients as $ingredient)
                                    <li class="list-group-item">• {{ $ingredient->name }}:
                                        {{ $ingredient->pivot->amount }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card shadow mt-3 col-md-12">
                        <div class="card-body">
                            <h3 class="card-title">Bereidingsinstructies</h3>
                            <p class="card-text">{!! $recipe->instructions !!}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @section('scripts')
        <script></script>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</x-app-layout>
