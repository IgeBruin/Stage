<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Bestelling Weergave') }}
        </h1>
        <a href="{{ route('user.myOrders') }}" class="btn btn-lg d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
            </svg>
            Terug naar overzicht
        </a>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h4 class="card-title">Details van de bestelling</h4>
                        <p class="card-text"><strong>Datum van de bestelling:</strong> {{ \Carbon\Carbon::parse($order->created_at)->locale('nl_NL')->isoFormat('D MMMM YYYY') }}</p>
                        <p class="card-text"><strong>Naam:</strong> {{ $address->name }} {{ $address->surname }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $order->email }}</p>
                        <p class="card-text"><strong>Totaalprijs:</strong> €{{ number_format($order->total_incl, 2) }}</p>

                        <h4 class="card-title">Adresgegevens</h4>
                        <p class="card-text"><strong>Straat:</strong> {{ $address->street }} {{ $address->street_number }}</p>
                        <p class="card-text"><strong>Postcode:</strong> {{ $address->zip_code }}</p>
                        <p class="card-text"><strong>Stad:</strong> {{ $address->city }}</p>
        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Bestelde producten</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Aantal</th>
                                    <th>Prijs per stuk</th>
                                    <th>BTW</th>
                                    <th>Subtotaal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>€{{ number_format($item->price, 2) }}</td>
                                        <td>€{{ number_format($item->price * $item->vat * $item->quantity / 100, 2) }}</td>
                                        <td>€{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                <h3 class="text-end"><strong>Totaalprijs:</strong> €{{ number_format($order->total_incl, 2) }}</h3>
            </div>
        </div>

    </div>
            



    @section('scripts')
        <script></script>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</x-app-layout>
