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


        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Huidige bestelling:</h4>
                <p>Naam: {{ session('shippingInfo.name') }} {{ session('shippingInfo.surname') }}</p>
                <p>Email: {{ session('shippingInfo.email') }}</p>
                <p>Straat en huisnummer: {{ session('shippingInfo.street') }}
                    {{ session('shippingInfo.street_number') }}</p>
                <p>Postcode: {{ session('shippingInfo.zip_code') }}</p>
                <p>Stad: {{ session('shippingInfo.city') }}</p>
                @if (session('shippingInfo.shipping_address'))
                    <h5>Bezorgadres:</h5>
                    <p>Naam: {{ session('shippingInfo.shipping_address.name') }}
                        {{ session('shippingInfo.shipping_address.surname') }}</p>
                    <p>Straat en huisnummer: {{ session('shippingInfo.shipping_address.street') }}
                        {{ session('shippingInfo.shipping_address.street_number') }}</p>
                    <p>Postcode: {{ session('shippingInfo.shipping_address.zip_code') }}</p>
                    <p>Stad: {{ session('shippingInfo.shipping_address.city') }}</p>
                @endif
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="useDifferentBilling" name="useDifferentBilling"
                        {{ old('useDifferentBilling') ? 'checked' : '' }}>
                    <label class="form-check-label" for="useDifferentBilling">
                        Verzend naar een ander adres
                    </label>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="info d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Samenvatting</h4>
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
