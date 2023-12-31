<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="font-semibold text-heading3 leading-tight text-indigo-500">
                {{ __('Dashboard') }}
            </h1>
            @can('isAdmin', \App\Models\User::class)
                <a href="{{ route('dashboard.categories.create') }}" class="btn  btn-lg fs-5 btn-primary">Categorie
                    Aanmaken</a>
            @endcan
        </div>
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
                        <div class="card-header fs-3 d-flex justify-content-between">
                            <span>Categorieën</span>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('dashboard.categories.search') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="query" class="form-control" placeholder="Zoek...">
                                        <button type="submit" class="btn btn-primary">Zoeken</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="fs-5">Titel</th>
                                            <th class="d-none d-md-table-cell fs-5">Aanmaak datum</th>
                                            <th class="d-none d-md-table-cell fs-5">Laatst bewerkt</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{ $category->name }}</td>
                                                    <td class="d-none d-md-table-cell">
                                                        {{ date('d-m-Y', strtotime($category->created_at)) }}</td>
                                                    <td class="d-none d-md-table-cell">
                                                        {{ date('d-m-Y', strtotime($category->updated_at)) }}</td>
                                                    <td class="text-end">
                                                        <a class="btn"
                                                            href="{{ route('dashboard.categories.edit', $category->id) }}"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor"
                                                                class="bi bi-pen-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                                                            </svg></a>
                                                    </td>
                                                    <td class="text-start">
                                                        <form
                                                            action="{{ route('dashboard.categories.destroy', $category->id) }}"
                                                            method="post" class="d-inline"
                                                            onsubmit="return confirm('Weet je zeker dat je deze rol wilt verwijderen?');">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn " type="submit"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" fill="currentColor"
                                                                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                                </svg></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">Geen categorieën gevonden.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $categories->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
