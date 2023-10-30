<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            @include('menus.admin_menu')

            <div class="col-md-10 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start">
                    <div class="card">
                        <div class="card-header fs-3 d-flex justify-content-between">
                            <span>Bestelling Aanpassen</span>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                        data-bs-target="#order" role="tab" aria-controls="order"
                                        aria-selected="true">Bestelling</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="address-tab" data-bs-toggle="tab"
                                        data-bs-target="#address" role="tab" aria-controls="address"
                                        aria-selected="false">Adres</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="order" role="tabpanel"
                                    aria-labelledby="order-tab">
                                    <form method="post" action="{{ route('dashboard.orders.update', $order) }}">
                                        @csrf
                                        @method('put')

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2>Algemene Informatie</h2>
                                                <div class="form-group">
                                                    <x-form-field type="text" name="email" label="Email"
                                                        :value="$order->email" :errors="$errors" />
                                                </div>

                                                <div class="form-group">
                                                    <x-form-field type="text" name="telephone" label="Telefoon"
                                                        :value="$order->telephone" :errors="$errors" />
                                                </div>

                                                <h2 class="mt-4">Product Toevoegen</h2>
                                                <div class="add-product">
                                                    <div class="form-group">
                                                        <label for="product">Product:</label>
                                                        <select class="form-control" name="product">
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <x-form-field type="text" name="quantity" label="Aantal"
                                                            :value="old('quantity')" :errors="$errors" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <h2>Producten</h2>
                                                @if ($order->items->count() > 0)
                                                    @foreach ($order->items as $orderItem)
                                                        <div class="order-item">
                                                            <h4>Product {{ $orderItem->name }}</h4>

                                                            <div class="form-group">
                                                                <x-form-field type="text"
                                                                    name="order_items[{{ $orderItem->id }}][quantity]"
                                                                    label="Aantal" :value="old(
                                                                        'order_items.' . $orderItem->id . '.quantity',
                                                                        $orderItem->quantity,
                                                                    )"
                                                                    :errors="$errors" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    for="order_items[{{ $orderItem->id }}][_remove]">Verwijder
                                                                    Product:</label>
                                                                <input type="hidden"
                                                                    name="order_items[{{ $orderItem->id }}][_remove]"
                                                                    value="0">
                                                                <input type="checkbox"
                                                                    name="order_items[{{ $orderItem->id }}][_remove]"
                                                                    value="1">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p class="mt-4 fs-4">Geen producten gevonden</p>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="submit" class="btn-lg btn btn-primary m-2"
                                            value="Bestelling Bewerken">
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <form method="POST" action="{{ route('dashboard.orders.updateAdress', $order) }}">
                                        @csrf
                                        @method('PATCH')

                                        @if ($order->billingAddress)
                                            <h2 class="mt-2">Factuuradres</h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-form-field type="text" name="billing_street" label="Straat"
                                                        :value="$order->billingAddress->street" :errors="$errors" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-form-field type="text" name="billing_street_number"
                                                        label="Huisnummer" :value="$order->billingAddress->street_number" :errors="$errors" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-form-field type="text" name="billing_zip_code"
                                                        label="Postcode" :value="$order->billingAddress->zip_code" :errors="$errors" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-form-field type="text" name="billing_city" label="Stad"
                                                        :value="$order->billingAddress->city" :errors="$errors" />
                                                </div>
                                            </div>
                                        @endif

                                        <h2 class="mt-4">Verzendadres</h2>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-form-field type="text" name="shipping_street" label="Straat"
                                                    :value="$order->shippingAddress->street" :errors="$errors" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-form-field type="text" name="shipping_street_number"
                                                    label="Huisnummer" :value="$order->shippingAddress->street_number" :errors="$errors" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-form-field type="text" name="shipping_zip_code"
                                                    label="Postcode" :value="$order->shippingAddress->zip_code" :errors="$errors" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-form-field type="text" name="shipping_city" label="Plaats"
                                                    :value="$order->shippingAddress->city" :errors="$errors" />

                                            </div>
                                        </div>

                                        <input type="submit" class="btn-lg btn btn-primary m-2"
                                            value="Adres Bewerken">
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection
</x-app-layout>
