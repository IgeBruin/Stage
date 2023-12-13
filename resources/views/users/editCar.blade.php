<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __($car->title . ' Bewerken') }}
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
                            <span>Auto Aanpassen</span>
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
                                        data-bs-target="#specifications" role="tab" aria-controls="specifications"
                                        aria-selected="false">Specificatie</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="images-tab" data-bs-toggle="tab"
                                        data-bs-target="#images" role="tab" aria-controls="images"
                                        aria-selected="false">Foto's</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    <form action="{{ route('user.cars.updateCar', ['car' => $car]) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Titel</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   id="title" name="title" value="{{ old('title', $car->title) }}">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Omschrijving</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                                      name="description" rows="4">{{ old('description', $car->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="brand_id" class="form-label">Merk</label>
                                            <select class="form-control select2 @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id">
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ ($brand->id == old('brand_id', $car->brand_id)) ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="type_id" class="form-label">Type</label>
                                            <select class="form-control select2 @error('type_id') is-invalid @enderror" id="type_id" name="type_id">
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}" {{ ($type->id == old('type_id', $car->type_id)) ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="fuel_id" class="form-label">Brandstof</label>
                                            <select class="form-control select2 @error('fuel_id') is-invalid @enderror" id="fuel_id" name="fuel_id">
                                                @foreach ($fuels as $fuel)
                                                    <option value="{{ $fuel->id }}" {{ ($fuel->id == old('fuel_id', $car->fuel_id)) ? 'selected' : '' }}>
                                                        {{ $fuel->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fuel_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="year" class="form-label">Bouwjaar</label>
                                            <input type="text" class="form-control @error('year') is-invalid @enderror" id="year" name="year"
                                                   value="{{ old('year', $car->year) }}">
                                            @error('year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="mileage" class="form-label">Kilometerstand</label>
                                            <input type="text" class="form-control @error('mileage') is-invalid @enderror" id="mileage" name="mileage"
                                                   value="{{ old('mileage', $car->mileage) }}">
                                            @error('mileage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="mot" class="form-label">MOT</label>
                                            <input type="date" class="form-control @error('mot') is-invalid @enderror" id="mot" name="mot"
                                                   value="{{ old('mot', $car->mot) }}">
                                            @error('mot')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Prijs</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                                   value="{{ old('price', $car->price) }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        @if($car->images->isNotEmpty())
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Huidige Afbeeldingen</label>
                                            <div>
                                                    @foreach ($car->images as $image)
                                                        <img src="{{ asset('images/cars/' . $car->id . '/' . $image->image) }}"
                                                            alt="Car Image" width="100" height="100">
                                                        <label>
                                                            <input type="checkbox" name="remove_images[]"
                                                                value="{{ $image->id }}"> Verwijder
                                                        </label>
                                                    @endforeach
                                               
                                            </div>
                                        </div>
                                        @endif

                                        <div class="mb-3 d-flex flex-column">
                                            <label for="images" class="form-label">Afbeelding(en) toevoegen</label>
                                            <input type="file" name="images[]" multiple accept="image/*">
                                        </div>

                                        <div class="mb-3 d-flex justify-content-end">
                                            <a href="{{ route('user.cars.showCar', ['car' => $car->id]) }}"
                                                class="btn-lg btn btn-link m-2">Terug</a>
                                            <input type="submit" class="btn-lg btn btn-primary m-2"
                                                value="Auto Opslaan">
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="specifications" role="tabpanel"
                                    aria-labelledby="specifications-tab">
                                    <form method="POST"
                                        action="{{ route('user.cars.saveCarSpecifications', $car) }}">
                                        @csrf
                                        @method('post')
                                        @foreach ($specifications as $specification)
                                            <div class="form-group">
                                                <label
                                                    for="specifications[{{ $specification->id }}]">{{ $specification->name }}</label>
                                                <input type="text" name="specifications[{{ $specification->id }}]"
                                                    class="form-control @error('specifications.' . $specification->id) is-invalid @enderror"
                                                    value="{{ old('specifications.' . $specification->id, $car->specifications->where('id', $specification->id)->first() ? $car->specifications->where('id', $specification->id)->first()->pivot->value : '') }}">
                                                @error('specifications.' . $specification->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach

                                        <div class="mb-3 d-flex justify-content-end">
                                            <a href="{{ route('user.cars.showCar', ['car' => $car->id]) }}"
                                                class="btn-lg btn btn-link m-2">Terug</a>
                                            <input type="submit" class="btn-lg btn btn-primary m-2"
                                                value="Specificatie(s) doorvoeren">
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="images" role="tabpanel"
                                    aria-labelledby="images-tab">
                                    <form action="{{ route('user.cars.carImages', ['car' => $car]) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        @if ($car->images->isNotEmpty())
                                            <div class="mb-3">
                                                <label for="images" class="form-label">Huidige Afbeeldingen</label>
                                                <div class="row">
                                                    @foreach ($car->images as $image)
                                                        <div class="col-md-2 mb-3">
                                                            <img src="{{ asset('images/cars/' . $car->id . '/' . $image->image) }}"
                                                                alt="Car Image" class="img-fluid" width="200"
                                                                height="100">
                                                            <label>
                                                                <input type="checkbox" name="remove_images[]"
                                                                    value="{{ $image->id }}"> Verwijder
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mb-3 d-flex flex-column">
                                            <label for="images" class="form-label">Afbeelding(en) toevoegen</label>
                                            <input type="file" name="images[]" multiple accept="image/*">
                                        </div>

                                        <div class="mb-3 d-flex justify-content-end">
                                            <a href="{{ route('user.cars.showCar', ['car' => $car->id]) }}"
                                                class="btn-lg btn btn-link m-2">Terug</a>
                                            <input type="submit" class="btn-lg btn btn-primary m-2"
                                                value="Auto Opslaan">
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
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

</x-app-layout>
