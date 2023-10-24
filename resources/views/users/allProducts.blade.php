<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Producten') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-column justify-content-start">
                    <div class="d-flex justify-content-end align-items-center">

                        <form action="{{ route('searchProduct') }}" method="GET">
                            <div class="input-group mb-2">
                                <input type="text" name="query" class="form-control" placeholder="Zoek...">
                                <button type="submit" class="btn btn-primary">Zoeken</button>
                            </div>
                        </form>

                    </div>

                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('showProduct', ['product' => $product->id]) }}"
                                    class="text-decoration-none">
                                    <div class="card h-100">
                                        @if ($product->image == 'images/products/placeholder.png')
                                            <img src="{{ asset('images/products/placeholder.png') }}" alt="Placeholder"
                                                class="card-img-top img-fluid object-cover" style="max-height: 200px;">
                                        @elseif ($product->image)
                                            <img src="{{ asset("images/products/{$product->id}/{$product->image}") }}"
                                                alt="{{ $product->title }}" class="card-img-top img-fluid object-cover"
                                                style=" max-height: 200px;">
                                        @endif
                                        <div class="card-body">
                                            <h3 class="card-title">{{ $product->name }}</h3>
                                            <p class="card-text">{!! $product->description !!}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</x-app-layout>
