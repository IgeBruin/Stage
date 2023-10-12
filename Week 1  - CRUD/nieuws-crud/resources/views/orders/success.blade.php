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
                        <h2>Bezorggegevens</h2>
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
                <div class="d my-2">
                    <a href="{{ route('products') }}" class="btn btn-lg btn-primary">Verder gaan met winkelen</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h2>Bestelde items</h2>

                        <a href="{{ route('order.generatePDF') }}" class="btn align-items-center d-flex">
                            <span class="mr-2 text-lg">Download PDF</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Prijs (Per product)</th>
                                    <th>Aantal</th>
                                    <th>Subtotaal (€)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartData['products'] as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>€ {{ number_format($product['price'], 2) }}</td>
                                        <td>{{ $product['quantity'] }}</td>
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
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
