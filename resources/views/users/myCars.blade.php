<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    </head>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="font-semibold text-heading3 leading-tight text-indigo-500">
                {{ __("Auto's") }}
            </h1>
            @auth
                <a href="{{ route('user.cars.createCar') }}" class="btn btn-lg fs-5 btn-primary">Auto Aanmaken</a>
            @endauth
        </div>
    </x-slot>

    <div class="container mt-5">

        <div class="d-flex justify-content-end align-items-center">
            <form action="{{ route('searchCar') }}" method="GET">
                <div class="input-group mb-2">
                    <input type="text" name="query" class="form-control" placeholder="Zoek...">
                    <button type="submit" class="btn btn-primary">Zoeken</button>
                </div>
            </form>
        </div>
        <div class="row">
            @include('menus.user_menu')
            <div class="col-md-10">

                <div class="d-flex flex-column justify-content-start">

                    <div class="d-flex justify-content-between">
                        @if (count($cars) == 1)
                            <h1>Mijn Auto</h1>
                        @elseif (count($cars) > 1)
                            <h1>Mijn auto's</h1>
                        @else
                            <h1>U heeft nog geen auto aangeboden</h1>
                        @endif

                    </div>
                    @if (count($cars) > 0)
                        <div class="row">
                            @foreach ($cars as $car)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('showCar', ['car' => $car->id]) }}" class="text-decoration-none">
                                        <div class="card h-100">
                                            <div id="carousel{{ $car->id }}" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @if ($car->images->isNotEmpty())
                                                        <div class="carousel-item active">
                                                            <img src="{{ asset('images/cars/' . $car->id . '/' . $car->images[0]->image) }}"
                                                                class="card-img-top object-cover" alt="Car Image"
                                                                style="max-height: 250px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>                                           
                                            <div class="info d-flex">
                                                <div class="card-body row">
                                                    <div class="col-md-6">
                                                        <div class="left">
                                                            <h5 class="card-title">{{ $car->title }}</h5>
                                                            <h2 class="card-price fs-4 fw-bolder">€{{ $car->price }},-
                                                            </h2>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="right text-end text-muted small">
                                                            <p class="mb-1">{{ $car->year }}</p>
                                                            <p class="mb-1">{{ $car->fuel->name }}</p>
                                                            <p class="mb-0">{{ $car->mileage }} KM</p>
                                                        </div>
                                                    </div>
                                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8IT8L1I5LVVMXEFW1v8Z2FOZn4MS5P2b70DIjz6JqU/bXK7cY/kL3I+fbYeg" crossorigin="anonymous">
    </script>
    @vite('resources/js/app.js')

</x-app-layout>
