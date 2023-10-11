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
                <form method="POST" action="{{ route('order.process') }}">
                    @csrf
                    @method('POST')
                    <h4>Huidige bestelling:</h4>
                    <p>Naam: {{ session('shippingInfo.name') }} {{ session('shippingInfo.surname') }}</p>
                    <p>Email: {{ session('shippingInfo.email') }}</p>
                    <p>Straat en huisnummer: {{ session('shippingInfo.street') }}
                        {{ session('shippingInfo.street_number') }}</p>
                    <p>Postcode: {{ session('shippingInfo.zip_code') }}</p>
                    <p>Stad: {{ session('shippingInfo.city') }}</p>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="useDifferentBilling"
                            name="useDifferentBilling" {{ old('useDifferentBilling') ? 'checked' : '' }}>
                        <label class="form-check-label" for="useDifferentBilling">
                            Bezorg- en factuuradres zijn hetzelfde
                        </label>
                    </div>
                    <div id="differentShippingFields">
                        <h5>Bezorgadres:</h5>
                        <div class="mb-3">
                            <label for="shipping_street" class="form-label">Straat</label>
                            <input type="text" class="form-control @error('shipping_street') is-invalid @enderror"
                                id="shipping_street" name="shipping_street">
                            @error('shipping_street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="shipping_street_number" class="form-label">Huisnummer</label>
                            <input type="text"
                                class="form-control @error('shipping_street_number') is-invalid @enderror"
                                id="shipping_street_number" name="shipping_street_number">
                            @error('shipping_street_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="shipping_zip_code" class="form-label">Postcode</label>
                            <input type="text" class="form-control @error('shipping_zip_code') is-invalid @enderror"
                                id="shipping_zip_code" name="shipping_zip_code">
                            @error('shipping_zip_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="shipping_city" class="form-label">Stad</label>
                            <input type="text" class="form-control @error('shipping_city') is-invalid @enderror"
                                id="shipping_city" name="shipping_city">
                            @error('shipping_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Betalen</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="info d-flex justify-content-between align-items-center">
                            <h4 class="card-title ">Samenvatting</h4>
                            <p class="text-sm">Aantal producten: {{ $cartData['totalProductCount'] }}</p>
                        </div>
                        <hr>
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="text-lg">
                                    <td>Totaal bedrag van de winkelwagen:</td>
                                    <td>€ {{ number_format($cartData['totalCartPrice'], 2) }}</td>
                                </tr>
                                <tr class="text-lg">
                                    <td>Totaal BTW:</td>
                                    <td>€ {{ number_format($cartData['totalVat'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="font-bold text-lg">
                                    <td>Totaal bedrag inclusief BTW:</td>
                                    <td>€ {{ number_format($cartData['totalCartPrice'] + $cartData['totalVat'], 2) }}
                                    </td>
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
        <script>
            $(document).ready(function() {
                if ($('#useDifferentBilling').is(':checked')) {
                    $('#differentShippingFields').hide();
                } else {
                    $('#differentShippingFields').show();
                }

                $('#useDifferentBilling').change(function() {
                    if (this.checked) {
                        $('#differentShippingFields').hide();
                    } else {
                        $('#differentShippingFields').show();
                    }
                });
            });
        </script>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
