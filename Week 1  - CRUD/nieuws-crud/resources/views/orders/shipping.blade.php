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
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('order.process') }}">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Factuuradres:</h4>
                                    {{ session('shippingInfo.name') }} {{ session('shippingInfo.surname') }}<br>
                                    {{ session('shippingInfo.email') }}<br>
                                    {{ session('shippingInfo.street') }} {{ session('shippingInfo.street_number') }}<br>
                                    {{ session('shippingInfo.zip_code') }} {{ session('shippingInfo.city') }}<br>
                                </div>
                                <div class="col-md-6">
                                    <h4>Afleveradres:</h4>
                                    {{ session('shippingInfo.name') }} {{ session('shippingInfo.surname') }}<br>
                                    {{ session('shippingInfo.email') }}<br>
                                    {{ session('shippingInfo.street') }} {{ session('shippingInfo.street_number') }}<br>
                                    {{ session('shippingInfo.zip_code') }} {{ session('shippingInfo.city') }}<br>
                                </div>
                            </div>
                            
                    
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="useDifferentBilling"
                                    name="useDifferentBilling" {{ old('useDifferentBilling', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="useDifferentBilling">
                                    Factuur- en afleveradres zijn hetzelfde
                                </label>
                            </div>

                            <div id="differentShippingFields">
                                <h5>Factuuradres:</h5>
                                <div class="mb-3">
                                    <label for="billing_street" class="form-label">Straat</label>
                                    <input type="text"
                                        class="form-control @error('billing_street') is-invalid @enderror"
                                        id="billing_street" name="billing_street" value="{{ old('billing_street') }}">
                                    @error('billing_street')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="billing_street_number" class="form-label">Huisnummer</label>
                                    <input type="text"
                                        class="form-control @error('billing_street_number') is-invalid @enderror"
                                        id="billing_street_number" name="billing_street_number" value="{{ old('billing_street_number') }}">
                                    @error('billing_street_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="billing_zip_code" class="form-label">Postcode</label>
                                    <input type="text"
                                        class="form-control @error('billing_zip_code') is-invalid @enderror"
                                        id="billing_zip_code" name="billing_zip_code" value="{{ old('billing_zip_code') }}">
                                    @error('billing_zip_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="billing_city" class="form-label">Stad</label>
                                    <input type="text"
                                        class="form-control @error('billing_city') is-invalid @enderror"
                                        id="billing_city" name="billing_city" value="{{ old('billing_city') }}">
                                    @error('billing_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                <div class="mt-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('order.index', ['shippingInfo' => session('shippingInfo')]) }}" class="btn btn-link">
                            Bezorggegevens Bewerken
                        </a>
                        
                        <button type="submit" class="btn btn-primary btn-lg">Plaats bestelling</button>
                    </div>
                </div>
            </div>
            </form>
            <div class="col-md-8 mb-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>Winkelmand</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Prijs (Per product)</th>
                                <th>Aantal</th>
                                <th>BTW</th>
                                <th>Subtotaal (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartData['products'] as $product)
                                <tr>
                                        <td class="d-flex">
                                            <img style="height: 70px; margin-right: 10px;"
                                                src="{{ asset("images/products/{$product['image']}") }}">
                                            <div>{{ $product['name'] }}</div>
                                        </td>
                                    </div>
                                    <td>€ {{ number_format($product['price'], 2) }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>€ {{ number_format($cartData['totalVat'], 2) }}</td>
                                    <td>€ {{ number_format($product['subtotal'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="card-text text-end m-0">Totaal exclusief BTW: € {{ number_format($cartData['totalCartPrice'], 2) }}</p>
                    <p class="card-text text-end m-0">BTW: € {{ number_format($cartData['totalVat'], 2) }}</p>
                    <h4 class="card-text text-end mt-1">Totaal inclusief BTW: € {{ number_format($cartData['totalCartPrice'] + $cartData['totalVat'], 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                @if ($errors->any())
                    $('#useDifferentBilling').prop('checked', false);
                    $('#differentShippingFields').show();
                @else
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
                @endif
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
