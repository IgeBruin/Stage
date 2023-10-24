<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    </head>

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Afrekenen') }}
        </h1>
        <div class="text-md-start text-center mt-3">
            <a href="{{ route('cart.index') }}" class="btn btn-lg d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Terug naar winkelwagen
            </a>
        </div>

    </x-slot>

    <div class="container mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <h2>Bezorgadres</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Naam</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ session('shippingInfo.name') ?? old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="surname" class="form-label">Achternaam</label>
                                        <input type="text"
                                            class="form-control @error('surname') is-invalid @enderror" id="surname"
                                            name="surname" value="{{ session('shippingInfo.surname') ?? old('surname') }}">
                                        @error('surname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="street" class="form-label">Straat</label>
                                        <input type="text" class="form-control @error('street') is-invalid @enderror"
                                            id="street" name="street" value="{{ session('shippingInfo.street') ?? old('street') }}">
                                        @error('street')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="street_number" class="form-label">Huisnummer</label>
                                        <input type="text"
                                            class="form-control @error('street_number') is-invalid @enderror"
                                            id="street_number" name="street_number" value="{{ session('shippingInfo.street_number') ??  old('street_number') }}">
                                        @error('street_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="zip_code" class="form-label">Postcode</label>
                                        <input type="text"
                                            class="form-control @error('zip_code') is-invalid @enderror" id="zip_code"
                                            name="zip_code" value="{{ session('shippingInfo.zip_code') ?? old('zip_code') }}">
                                        @error('zip_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">Plaats</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            id="city" name="city" value="{{ session('shippingInfo.city') ?? old('city') }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Telefoonnummer</label>
                                        <input type="text"
                                            class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                                            name="telephone" value="{{ session('shippingInfo.telephone') ?? old('telephone') }}">
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            name="email" value="{{ session('shippingInfo.email') ?? old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="info d-flex justify-content-between align-items-center">
                            <h4 class="card-title ">Samenvatting</h4>
                            <p class="text-sm">Aantal producten: {{ $totalProductCount }}</p>
                        </div>
                        <hr>
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="text-lg">
                                    <td>Totaal bedrag van de winkelwagen:</td>
                                    <td>€ {{ number_format($totalCartPrice, 2) }}</td>
                                </tr>
                                <tr class="text-lg">
                                    <td>Totaal BTW:</td>
                                    <td>€ {{ number_format($totalVat, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="font-bold text-lg">
                                    <td>Totaal bedrag inclusief BTW:</td>
                                    <td>€ {{ number_format($totalCartPrice + $totalVat, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">Doorgaan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>


    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
