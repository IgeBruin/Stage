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
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="surname" class="form-label">Achternaam</label>
                                        <input type="text" class="form-control" id="surname" name="surname"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="street" class="form-label">Straat</label>
                                        <input type="text" class="form-control" id="street" name="street"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="street_number" class="form-label">Huisnummer</label>
                                        <input type="text" class="form-control" id="street_number"
                                            name="street_number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="zip_code" class="form-label">Postcode</label>
                                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">Plaats</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Telefoonnummer</label>
                                        <input type="text" class="form-control" id="telephone" name="telephone"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-lg btn-primary">Volgende</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="info d-flex justify-content-between align-items-center">
                            <h4 class="card-title ">Samenvatting</h4>
                            <p class="text-sm">Aantal producten: {{ count($cartItems) }}</p>
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