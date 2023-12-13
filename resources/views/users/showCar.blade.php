<x-app-layout>

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __($car->title . ' Weergave') }}
        </h1>
        <a href="{{ route('cars.overview') }}" class="btn btn-lg d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
            </svg>
            Terug naar Overzicht
        </a>
    </x-slot>

    <div class="container-fluid mt-5 ">
        <div class="row mx-5 d-flex align-items-stretch">
            <div class="col-md-7">
                <div id="slider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if ($car->images->isNotEmpty())
                            @foreach ($car->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images/cars/' . $car->id . '/' . $image->image) }}"
                                        class="card-img-top object-cover car-image" alt="Car Image"
                                        style="max-height: 400px;">
                                </div>
                            @endforeach
                        @endif
                        <button class="carousel-control-prev" type="button" data-bs-target="#slider"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#slider"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            

            <div class="col-md-5">
                <div class="card">
                    <div class="card-body d-flex flex-column ml-4">
                        <h5 class="card-title fs-2 mb-2">{{ $car->title }}</h5>
                        <p class="card-text mb-1">{!! $car->description !!}</p>
                        <p class="card-text mb-1">
                            <h2 class="card-price fs-2 fw-bolder">€{{ $car->price }},-</h2>
                        </p>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Kilometerstand:</strong> {{ $car->mileage }} Km</li>
                            <li><strong>Brandstof:</strong> {{ $car->fuel->name }}</li>
                            <li><strong>Type auto:</strong> {{ $car->type->name }}</li>
                        </ul>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('cars.overview') }}" class="btn-lg btn btn-link m-0">Terug</a>
                            <a href="#" class="btn-lg btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#contactModal">Contact aanbieder</a>
                        </div>
                    </div>
                    @can('update', $car)
                        <a class="btn" style="position: absolute; top: 10px; right: 40px;"
                            href="{{ route('user.cars.editCar', $car->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path
                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                            </svg>
                        </a>
                    @endcan
                    @can('delete', $car)
                        <form action="{{ route('user.cars.destroyCar', $car->id) }}" method="post"
                            class="d-inline" style="position: absolute; top: 10px; right: 10px;"
                            onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?');">
                            @csrf
                            @method('delete')
                            <button class="btn" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                            </button>
                        </form>
                    @endcan
                </div>
                
            </div>
        </div>
            </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" class="img-fluid" id="modalImage" alt="Car Image"
                        style="object-fit: contain; width: 200%; height: 200%; min-width: 200px; min-height: 150px;">
                </div>
            </div>
        </div>
    </div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    window.addEventListener('load', () => {
        for (const name of ['message']) {
            ClassicEditor.create(document.getElementById(name))
                .catch(error => {
                    console.error(error);
                });
        }
    });

    document.querySelectorAll('.car-image').forEach(function(image, index) {
            image.addEventListener('click', function() {
                document.getElementById('modalImage').src = image.src;
                $('#imageModal').modal('show');
            });
        });
    
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>
@include('cars.modal.contact')
@endsection

</x-app-layout>
