<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Product Weergave') }}
        </h1>
    </x-slot>

    <div class="container-fluid mt-5 ">
        <div class="row mx-5">
            <div class="col-md-7">
                <div class="card">
                    @if ($product->image == 'images/products/placeholder.png')
                        <img src="{{ asset('images/products/placeholder.png') }}" alt="Placeholder"
                            class="card-img-top img-fluid" style="width: 100%; height: auto;">
                    @elseif ($product->image)
                        <img src="{{ asset("images/products/{$product->id}/{$product->image}") }}"
                            alt="{{ $product->title }}" class="card-img-top img-fluid"
                            style="width: 100%; height: auto;">
                    @endif
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{ $product->name }}</h3>
                        <p class="card-text">{!! $product->description !!}</p>
                        <p class="card-text">
                            Prijs: € {{ $product->price }} <small class="text-muted">excl. btw</small>
                        </p>
                        <form action="{{ route('cart.add') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label for="quantity">Aantal:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1"
                                    class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Toevoegen aan winkelmandje</button>
                        </form>
                    </div>
                </div>
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
