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

    <div class="container-fluid max-w-7xl mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success ms-2">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-2 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start align-items-center h-100">
                    <ul class="list-group text-center">
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.articles.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Artikelen</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Categorieën</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.projects.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Projecten</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <a href="{{ route('dashboard.roles.index') }}"
                                class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Rollen</a>
                        </li>
                        <li class="list-group-item bg-light">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Uitloggen</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start">
                    <div class="card">
                        <div class="card-header fs-3">
                            Project Aanpassen
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h3>Gebruiker Toevoegen</h3>
                                <form action="{{ route('dashboard.projects.addUser', ['project' => $project]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <label for="user_id" class="form-label">Gebruiker</label>
                                        <select name="user_id"
                                            class="form-control categories @error('user_id') is-invalid @enderror">
                                            <option value="" selected disabled hidden>Selecteer een gebruiker
                                            </option>
                                            @foreach ($availableUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="role_id" class="form-label">Rol</label>
                                        <select name="role_id"
                                            class="form-control categories @error('role_id') is-invalid @enderror">
                                            <option value="" selected disabled hidden>Selecteer een rol</option>
                                            @foreach ($allRoles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="mt-3 d-flex justify-content-end">
                                        <a href="{{ route('dashboard.projects.edit', $project->id) }}"
                                            class="btn-lg btn btn-link m-2">Terug</a>
                                        <input type="submit" class="btn-lg btn btn-primary m-2" value="Toevoegen">
                                    </div>
                                </form>
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
        <script>
            window.addEventListener('load', () => {
                for (const name of ['content']) {
                    ClassicEditor.create(document.getElementById(name))
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
            $(document).ready(function() {
                $('.categories').select2();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection

</x-app-layout>
