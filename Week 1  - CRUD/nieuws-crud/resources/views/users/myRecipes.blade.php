<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Mijn Overzicht') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">

            @include('menus.user_menu')

            <div class="col-md-10">
                <div class="d-flex flex-column justify-content-start">
                    <div class="d-flex justify-content-between">
                        @if (count($recipes) == 1)
                        <h1>Mijn recept</h1>
      
                        @elseif (count($recipes) > 1)
                        <h1>Mijn recepten</h1>
                        @else 
                        <h1>U heeft nog geen recepten</h1>
                        @endif
                        
                    </div>
                    @if (count($recipes) > 0)
                        <div class="row">
                            @foreach ($recipes as $recipe)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('user.showRecipe', ['recipe' => $recipe->id]) }}"
                                        class="text-decoration-none">
                                        <div class="card text-center shadow">
                                            <div class="card-body">
                                                <p class="card-email"><strong>{{ $recipe->title }}</strong></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</x-app-layout>

