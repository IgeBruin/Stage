<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Overzicht') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">

            @include('menus.user_menu')

            <div class="col-md-10">
                <div class="d-flex flex-column justify-content-start">
                    <div class="d-flex justify-content-between">
                        @if (count($orders) == 1)
                        <h1>Mijn bestelling</h1>
      
                        @elseif (count($orders) > 1)
                        <h1>Mijn bestellingen</h1>
                        @else 
                        <h1>U heeft nog geen bestellingen</h1>
                        @endif
                        
                    </div>

                    @if (count($orders) > 0)
                        <div class="row">
                            @foreach ($orders as $order)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('user.showOrder', ['order' => $order->id]) }}"
                                        class="text-decoration-none">
                                        <div class="card text-center shadow">
                                            <div class="card-body">
                                                <p class="card-email"><strong>{{ $order->email }}</strong></p>
                                                <p>Datum: <strong>{{ $order->created_at->format('d-m-Y') }}</strong></p>
                                                <p>Totaalprijs: <strong>€{{ number_format($order->total_incl, 2) }}</strong></p>
                                                <p>Aantal producten: <strong>{{ $order->items->sum('quantity') }}</strong></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                        
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            window.addEventListener('load', () => {
                for (const name of ['content']) {
                    ClassicEditor.create(document.getElementById(name))
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
        </script>
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</x-app-layout>
