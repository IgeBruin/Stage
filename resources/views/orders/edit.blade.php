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

            <div class="col-md-10">
                <div class="d-flex flex-column justifd-content-start">

                    <div class="card">
                        <div class="card-header fs-3">
                            Bestelling Aanpassen
                        </div>
                        <div class="card-body">
                            <h2>Bewerk bestelling</h2>
                            <form method="post" action="{{ route('dashboard.orders.update', $order) }}">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $order->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="telephone">Telephone:</label>
                                    <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                        id="telephone" name="telephone"
                                        value="{{ old('telephone', $order->telephone) }}">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if ($order->items->count() > 0)


                                    @foreach ($order->items as $orderItem)
                                        <div class="order-item">
                                            <h4>Product {{ $orderItem->name }}</h4>

                                            <div class="form-group">
                                                <label for="order_items[{{ $orderItem->id }}][quantity]">Aantal:</label>
                                                <input type="text"
                                                    class="form-control @error('order_items.' . $orderItem->id . '.quantity') is-invalid @enderror"
                                                    name="order_items[{{ $orderItem->id }}][quantity]"
                                                    value="{{ old('order_items.' . $orderItem->id . '.quantity', $orderItem->quantity) }}">
                                                @error('order_items.' . $orderItem->id . '.quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="order_items[{{ $orderItem->id }}][_remove]">Verwijder
                                                    Product:</label>
                                                <input type="hidden" name="order_items[{{ $orderItem->id }}][_remove]"
                                                    value="0">
                                                <input type="checkbox"
                                                    name="order_items[{{ $orderItem->id }}][_remove]" value="1">
                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    <p class="mt-4 fs-4">geen producten gevonden</p>
                                @endif

                                <input type="submit" class="btn-lg btn btn-primary m-2" value="Bestelling Bewerken">
                            </form>
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