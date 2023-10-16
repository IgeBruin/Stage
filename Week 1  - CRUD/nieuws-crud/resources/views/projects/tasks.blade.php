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
            @include('menus.admin_menu')

            <div class="col-md-10 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start">
                    <div class="card">
                        <div class="card-header fs-3">
                            Taak toevoegen
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                            
                                <form action="{{ route('dashboard.projects.storeTask', ['project' => $project]) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <label for="title" class="form-label">Titel</label>
                                        <input type="text" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Titel" value="{{ old('title') }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="description" class="form-label">Beschrijving</label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Beschrijving">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="deadline" class="form-label">Deadline</label>
                                        <input type="date" name="deadline"
                                            class="form-control @error('deadline') is-invalid @enderror"
                                            value="{{ old('deadline') }}">
                                        @error('deadline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="user_id" class="form-label">Gebruiker</label>
                                        <select name="user_id[]" multiple="multiple" placeholder="Selecteer een gebruiker"
                                        
                                            class="form-control select2 @error('user_id') is-invalid @enderror">
                                            @foreach ($project->users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ in_array($user->id, old('user_id', [])) ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
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
                for (const name of ['description']) {
                    ClassicEditor.create(document.getElementById(name))
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
    @endsection

</x-app-layout>
