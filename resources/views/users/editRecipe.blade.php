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

    <div class="container-fluid max-w-7xl mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success ms-2">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row">
            @include('menus.user_menu')

            <div class="col-md-10 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start">
                    <div class="card">
                        <div class="card-header fs-3 d-flex justify-content-between">
                            <span>Recept Aanpassen</span>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                        data-bs-target="#general" role="tab" aria-controls="general"
                                        aria-selected="true">Algemeen</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab"
                                        data-bs-target="#ingredients" role="tab" aria-controls="ingredients"
                                        aria-selected="false">Ingredienten</button>
                                </li>

                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    <h3 class="mt-3">Algemeen</h3>
                                    <form action="{{ route('user.recipes.updateRecipe', ['recipe' => $recipe]) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Titel</label>
                                            <input type="text"
                                                class="form-control @error('title') is-invalid @enderror" id="title"
                                                name="title" value="{{ old('title', $recipe->title) }}">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Omschrijving</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="4">{{ old('description', $recipe->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="instructions" class="form-label">instructies</label>
                                            <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions"
                                                rows="4">{{ old('instructions', $recipe->instructions) }}</textarea>
                                            @error('instructions')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Afbeelding</label>
                                            <input type="file"
                                                class="form-control @error('image') is-invalid @enderror" id="image"
                                                name="image">


                                            @if ($recipe->image && $recipe->image != 'images/recipes/placeholder.png')
                                                <p>Huidige afbeelding:</p>
                                                <img src="{{ asset("images/recipes/{$recipe->id}/{$recipe->image}") }}"
                                                    alt="{{ $recipe->title }}" width="100" height="100">
                                                <label for="delete_image" class="form-label">Verwijder
                                                    Afbeelding</label>
                                                <input type="checkbox" class="form-check-input" id="delete_image"
                                                    name="delete_image">
                                            @elseif ($recipe->image == 'images/recipes/placeholder.png')
                                                <p>Huidige afbeelding:</p>
                                                <img src="{{ asset('images/recipes/placeholder.png') }}"
                                                    alt="Placeholder" width="100" height="100">
                                            @endif
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 d-flex justify-content-end">
                                            <a href="{{ route('dashboard.products.index') }}"
                                                class="btn-lg btn btn-link m-2">Terug</a>
                                            <input type="submit" class="btn-lg btn btn-primary m-2"
                                                value="Recept Aanpassen">
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="ingredients" role="tabpanel" aria-labelledby="ingredients-tab">
                                    <h3 class="mt-3">Ingredienten</h3>
                                    <form method="POST" action="{{ route('user.recipes.saveIngredients', $recipe) }}">
                                        @csrf
                                        @method('post')
                                
                                        <div class="form-group">
                                            <label for="selectedIngredients">Selecteer ingrediënten:</label>
                                            <select id="selectedIngredients" class="form-control" multiple="multiple" style="width: 100%">
                                                @foreach ($ingredients as $ingredient)
                                                    @php
                                                        $selected = in_array($ingredient->id, $recipe->ingredients->pluck('id')->toArray());
                                                    @endphp
                                                    <option value="{{ $ingredient->id }}" {{ $selected ? 'selected' : '' }}>{{ $ingredient->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                
                                        <div id="ingredientInputs"></div>
                                
                                        <div class="mb-3 d-flex justify-content-end">
                                            <a href="{{ route('dashboard.recipes.index') }}" class="btn-lg btn btn-link m-2">Terug</a>
                                            <input type="submit" class="btn-lg btn btn-primary m-2" value="Ingrediënten Opslaan">
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            window.addEventListener('load', () => {
                for (const name of ['description', 'instructions']) {
                    ClassicEditor.create(document.getElementById(name))
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
        </script>

<script>
    let ingredientsData = @json($ingredients);
    console.log(ingredientsData);
    var ingredients = {}; 

    @foreach ($ingredients as $ingredient)
        var ingredientId = {{ $ingredient->id }};
        var pivotAmount = @json($recipe->ingredients->where('id', $ingredient->id)->first() ? $recipe->ingredients->where('id', $ingredient->id)->first()->pivot->amount : '');

        ingredients[ingredientId] = pivotAmount;
    @endforeach

    console.log(ingredients); 

    $(document).ready(function() {
    $('#selectedIngredients').select2();

    // Functie om de invoervelden te genereren en bij te werken
    function generateInputFields(selectedIngredients) {
        var inputFields = '';
        var recipeId = {{ $recipe->id }};

        var selectedIngredientsData = {};

        selectedIngredients.forEach(function(ingredientId) {
            var ingredient = ingredientsData[ingredientId - 1];
            var pivotAmount = ingredients[ingredientId];

            selectedIngredientsData[ingredientId] = pivotAmount;

            inputFields += `
                <div class="form-group">
                    <label for="ingredients[${ingredientId}]">${ingredient.name}</label>
                    <input type="text" name="ingredients[${ingredientId}]"
                        class="form-control"
                        value="${pivotAmount}">
                </div>
            `;
        });

        for (var ingredientId in ingredients) {
            if (!selectedIngredientsData.hasOwnProperty(ingredientId)) {
                ingredients[ingredientId] = '';
                inputFields += `
                    <input type="hidden" name="ingredients[${ingredientId}]" value="">
                `;
            }
        }

        return inputFields;
    }

    $('#selectedIngredients').on('change', function() {
        var selectedIngredients = $(this).val();
        var inputFields = generateInputFields(selectedIngredients);

        $('#ingredientInputs').html(inputFields);
    });

    var selectedIngredients = $('#selectedIngredients').val() || [];
    var inputFields = generateInputFields(selectedIngredients);
    $('#ingredientInputs').html(inputFields);
});


</script>


    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

</x-app-layout>
