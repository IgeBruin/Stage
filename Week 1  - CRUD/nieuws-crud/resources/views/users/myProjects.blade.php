<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Mijn Overzicht') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">

            @include('menus.user_menu')

            <div class="col-md-10">
                <div class="d-flex flex-column justify-content-start">
                    <div class="d-flex justify-content-between">
                        @if (count($projects) == 0)
                            <h1>Je bent niet aan een project gekoppeld</h1>
                        @elseif (count($projects) == 1)
                            <h1>Mijn project</h1>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('user.search') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="query" class="form-control" placeholder="Zoek...">
                                        <button type="submit" class="btn btn-primary">Zoeken</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <h1>Mijn projecten</h1>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('user.search') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="query" class="form-control" placeholder="Zoek...">
                                        <button type="submit" class="btn btn-primary">Zoeken</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if (count($projects) > 0)
                        <div class="row">
                            @foreach ($projects as $project)
                                <div class="col-md-4 mb-4">
                                    <a href="{{ route('user.showProject', ['project' => $project->id]) }}"
                                        class="text-decoration-none">
                                        <div class="card">
                                            @if ($project->image == 'images/projects/placeholder.png')
                                                <img src="{{ asset('images/projects/placeholder.png') }}"
                                                    alt="Placeholder" class="card-img-top img-fluid object-cover"
                                                    style="max-height: 200px;">
                                            @elseif ($project->image)
                                                <img src="{{ asset("images/projects/{$project->id}/{$project->image}") }}"
                                                    alt="{{ $project->title }}"
                                                    class="card-img-top img-fluid object-cover"
                                                    style=" max-height: 200px;">
                                            @endif
                                            <div class="card-body">
                                                <h3 class="card-title">{{ $project->name }}</h3>
                                                <p class="card-text">{!! $project->introduction !!}</p>
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
