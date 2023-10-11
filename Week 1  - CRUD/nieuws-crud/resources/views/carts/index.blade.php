<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    </head>

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Winkelwagen') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row">
            @if (!empty($products))
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Productnaam</th>
                                        <th>Prijs per stuk</th>
                                        <th>Aantal</th>
                                        <th>Subtotaal</th>
                                        <th>BTW</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr id="row-{{ $product['id'] }}">
                                            <td class="d-flex">
                                                <img style="height: 70px; margin-right: 10px;"
                                                    src="{{ asset("images/products/{$product['image']}") }}">
                                                <div>{{ $product['name'] }}</div>
                                            </td>
                                            <td>€ {{ number_format($product['price'], 2) }}</td>
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('cart.update', ['productId' => $product['id']]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-transparent"
                                                        name="action" value="decrease">-</button>
                                                    <span
                                                        id="quantity-{{ $product['id'] }}">{{ $product['quantity'] }}</span>
                                                    <button type="submit" class="btn btn-sm btn-transparent"
                                                        name="action" value="increase">+</button>
                                                </form>
                                            </td>
                                            <td>€ {{ number_format($product['price'] * $product['quantity'], 2) }}</td>
                                            <td>€
                                                {{ number_format(($product['subtotal'] * $product['vat']) / 100, 2) }}
                                            </td>
                                            <td class="text-start">
                                                <form
                                                    action="{{ route('cart.remove', ['productId' => $product['id']]) }}"
                                                    method="post" class="d-inline"
                                                    onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn " type="submit"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" fill="currentColor" class="bi bi-trash-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                        </svg></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('order.index') }}" class="btn btn-lg btn-primary">Afrekenen</a>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <p>Je winkelwagen is leeg.</p>
            @endif
        </div>
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
