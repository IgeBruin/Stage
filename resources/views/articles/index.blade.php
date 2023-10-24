<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    </head>

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Artikelen') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="d-flex justify-content-end align-items-center">

        </div>
        <div class="row">
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if ($post->image == 'images/articles/placeholder.png')
                                <img src="{{ asset('images/articles/placeholder.png') }}" alt="Placeholder"
                                    class="card-img-top img-fluid object-cover" style="max-height: 200px;">
                            @elseif ($post->image)
                                <img src="{{ asset("images/articles/{$post->id}/{$post->image}") }}"
                                    alt="{{ $post->title }}" class="card-img-top img-fluid object-cover"
                                    style=" max-height: 200px;">
                            @endif
                            <div class="card-body">
                                <h2 class="card-title">{{ $post->title }}</h2>
                                <p class="card-text">{!! $post->introduction !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <h1>Er zijn geen berichten beschikbaar.</h1>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
