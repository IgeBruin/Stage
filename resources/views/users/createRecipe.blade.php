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
                            <span>Recept Aanmaken</span>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('user.recipes.storeRecipe') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titel</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Omschrijving</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="instructions" class="form-label">Instructies</label>
                                    <textarea class="form-control @error('instructions') is-invalid @enderror" id="instructions" name="instructions"
                                        rows="4">{{ old('instructions') }}</textarea>
                                    @error('instructions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="selectedIngredients">Selecteer ingrediënten:</label>
                                        <select id="selectedIngredients" class="form-control" multiple="multiple" style="width: 100%">
                                            @foreach ($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div id="ingredientInputs"></div>
                                </div>
                                
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">Afbeelding</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <a href="{{ route('dashboard.recipes.index') }}"
                                        class="btn-lg btn btn-link m-2">Terug</a>
                                    <input type="submit" class="btn-lg btn btn-primary m-2" value="Recept Toevoegen">
                                </div>
                            </form>
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
                for (const name of ['description']) {
                    ClassicEditor.create(document.getElementById(name))
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>


<script>
    $(document).ready(function() {
        $('#selectedIngredients').select2();

        function generateInputFields(selectedIngredients) {
            var inputFields = '';

            selectedIngredients.forEach(function(ingredientId) {
                var ingredientName = $('#selectedIngredients option[value="' + ingredientId + '"]').text();
                var pivotAmount = '';
                var ingredientInput = $('#ingredientInput_' + ingredientId);

                if (ingredientInput.length) {
                    pivotAmount = ingredientInput.val();
                }

                inputFields += `
                    <div class="form-group">
                        <label for="ingredients[${ingredientId}]">${ingredientName}</label>
                        <input type="text" id="ingredientInput_${ingredientId}" name="ingredients[${ingredientId}]"
                            class="form-control"
                            value="${pivotAmount}">
                    </div>
                `;
            });

            return inputFields;
        }

        $('#selectedIngredients').on('change', function() {
            var selectedIngredients = $(this).val();
            var inputFields = generateInputFields(selectedIngredients);
            $('#ingredientInputs').html(inputFields);
        });
    });
</script>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

</x-app-layout>
