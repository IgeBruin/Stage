<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    </head>

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Bestelling voltooid') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Factuur</h2>
                    </div>
                    <div class="card-body">

                        @if ($address)
                            <p class="card-text">Naam: {{ $address->name }} {{ $address->surname }}</p>
                            <p class="card-text">Straat: {{ $address->street }} {{ $address->street_number }}</p>
                            <p class="card-text">Postcode: {{ $address->zip_code }}</p>
                            <p class="card-text">Plaats: {{ $address->city }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Bestelde items</h2>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach ($cartData['products'] as $product)
                                <li class="mt-4">
                                    <p class="card-text">
                                        Naam: {{ $product['name'] }}<br>
                                        Prijs: € {{ $product['price'] }}<br>
                                        Aantal: {{ $product['quantity'] }}<br>
                                        Subtotaal: € {{ number_format($product['subtotal'],2) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                        <p class="card-text">Totaal exclusief BTW: € {{ number_format($cartData['totalCartPrice'],2) }}</p>
                        <p class="card-text">BTW: € {{ number_format($cartData['totalVat'],2) }}</p>
                        <p class="card-text">Totaal inclusief BTW: €
                            {{ number_format($cartData['totalCartPrice'] + $cartData['totalVat'],2) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <a href="{{ route('products') }}" class="btn btn-lg btn-primary">Verder gaan met winkelen</a>
            <a href="{{ route('order.generatePDF') }}" class="btn btn-lg btn-secondary">Download PDF Factuur</a>
        </div>
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
