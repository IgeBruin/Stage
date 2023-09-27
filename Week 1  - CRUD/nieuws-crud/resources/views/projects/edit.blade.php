<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

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
            @include('_menu')

            <div class="col-md-10 mb-md-0 mb-4">
                <div class="d-flex flex-column justify-content-start">
                    <div class="card">
                        <div class="card-header fs-3 d-flex justify-content-between">
                            <span>Project Aanpassen</span>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                        data-bs-target="#general" role="tab" aria-controls="general"
                                        aria-selected="true">Algemeen</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                                        role="tab" aria-controls="users" aria-selected="false">Gebruikers</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks"
                                        role="tab" aria-controls="tasks" aria-selected="false">Taken</button>
                                </li>

                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    <form action="{{ route('dashboard.projects.update', ['project' => $project]) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <h3 class="mt-3">Algemeen</h3>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Naam</label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                name="name" value="{{ $project->name }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="introduction" class="form-label">Introductie</label>
                                            <textarea class="form-control @error('introduction') is-invalid @enderror" id="introduction" name="introduction"
                                                rows="4">{{ $project->introduction }}</textarea>
                                            @error('introduction')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="content" class="form-label">Inhoud</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ $project->content }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Afbeelding</label>
                                            <input type="file"
                                                class="form-control @error('image') is-invalid @enderror" id="image"
                                                name="image">

                                            @if ($project->image && $project->image != 'images/projects/placeholder.png')
                                                <p>Huidige afbeelding:</p>
                                                <img src="{{ asset("images/projects/{$project->id}/{$project->image}") }}"
                                                    alt="{{ $project->title }}" width="100" height="100">
                                                <label for="delete_image" class="form-label">Verwijder
                                                    Afbeelding</label>
                                                <input type="checkbox" class="form-check-input" id="delete_image"
                                                    name="delete_image">
                                            @elseif ($project->image == 'images/projects/placeholder.png')
                                                <p>Huidige afbeelding:</p>
                                                <img src="{{ asset('images/projects/placeholder.png') }}"
                                                    alt="Placeholder" width="100" height="100">
                                            @endif
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Start Datum</label>
                                            <input type="date"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                                id="start_date" name="start_date"
                                                value="{{ $project->start_date }}">
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 d-flex justify-content-end">
                                            <a href="{{ route('dashboard.projects.index') }}"
                                                class="btn-lg btn btn-link m-2">Terug</a>
                                            <input type="submit" class="btn-lg btn btn-primary m-2"
                                                value="Project Bewerken">
                                        </div>
                                    </form>
                                </div>



                                <div class="tab-pane fade" id="users" role="tabpanel"
                                    aria-labelledby="users-tab">
                                    <div class="d-flex justify-content-between align-items-center ">
                                        <h3 class="mt-3">Gebruikers</h3>
                                    </div>
                                    @if ($project->users->isEmpty())
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" class="text-center">Geen gebruikers gevonden.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="fs-5">Naam</th>
                                                    <th class="fs-5">Rol</th>
                                                    <th class="fs-5"></th>
                                                    <th class="fs-5"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($project->users as $user)
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>
                                                            @if ($user->pivot->role_id)
                                                                {{ $user->roles->where('id', $user->pivot->role_id)->first()->name }}
                                                            @else
                                                                Geen rol toegewezen
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <a class="btn"
                                                                href="{{ route('dashboard.projects.editRole', ['project' => $project, 'user' => $user->id]) }}"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" fill="currentColor"
                                                                    class="bi bi-pen-fill" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                                                                </svg></a>
                                                        </td>
                                                        <td class="text-start">
                                                            <form
                                                                action="{{ route('dashboard.projects.removeUser', ['project' => $project, 'user' => $user]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Weet je zeker dat je deze persoon van het project wilt verwijderen?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn " type="submit"><svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="20" height="20"
                                                                        fill="currentColor" class="bi bi-trash-fill"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                                    </svg></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    <div class="mb-3 d-flex justify-content-end">
                                        <a href="{{ route('dashboard.projects.index') }}"
                                            class="btn-lg btn btn-link">Terug</a>
                                        <button type="button"
                                            class="btn btn-primary btn-lg py-0 px-1 d-flex align-items-center justify-content-center"
                                            onclick="window.location.href='{{ route('dashboard.projects.users', ['project' => $project]) }}'">
                                            Gebruiker Toevoegen
                                        </button>
                                    </div>

                                </div>


                                <div class="tab-pane fade" id="tasks" role="tabpanel"
                                    aria-labelledby="tasks-tab">
                                    <div class="d-flex justify-content-between align-items-center ">
                                        <h3 class="mt-3">Openstaande Taken</h3>
                                    </div>
                                    @if ($openTasks->isEmpty())
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" class="text-center">Geen openstaande taken
                                                        gevonden.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="fs-5">Titel</th>
                                                    <th class="fs-5">Gekoppeld</th>
                                                    <th class="fs-5">Status</th>
                                                    <th class="fs-5">Deadline</th>
                                                    <th class="fs-5"></th>
                                                    <th class="fs-5"></th>
                                                    <th class="fs-5"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($openTasks as $task)
                                                    <tr>
                                                        <td>{{ $task->title }}</td>
                                                        <td>
                                                            @if (count($userNamesForTasks[$task->id]) > 1)
                                                                {{ implode(', ', $userNamesForTasks[$task->id]) }}
                                                            @else
                                                                {{ $userNamesForTasks[$task->id][0] }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $statusOptions[$task->status_id] }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($task->deadline)) }}</td>
                                                        <td class="text-end">
                                                            <a class="btn"
                                                                href="{{ route('dashboard.projects.editTask', ['project' => $project, 'task' => $task->id, 'user', $user->id]) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" fill="currentColor"
                                                                    class="bi bi-pen-fill" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z" />
                                                                </svg>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="btn"
                                                                href="{{ route('dashboard.projects.finishTask', ['project' => $project, 'task' => $task->id, 'user', $user->id]) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                    height="25" fill="currentColor"
                                                                    class="bi bi-check" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                                </svg>
                                                            </a>
                                                        </td>
                                                        <td class="text-start">
                                                            <form
                                                                action="{{ route('dashboard.projects.destroyTask', ['project' => $project, 'user' => $user, 'task' => $task->id]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Weet je zeker dat je deze taak van het project wilt verwijderen?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn " type="submit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="20" height="20"
                                                                        fill="currentColor" class="bi bi-trash-fill"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="mt-3">Afgeronde Taken</h3>
                                    </div>

                                    @if ($completedTasks->isEmpty())
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" class="text-center">Geen afgeronde taken
                                                        gevonden.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="fs-5">Titel</th>
                                                    <th class="fs-5">Gekoppeld</th>
                                                    <th class="fs-5">Status</th>
                                                    <th class="fs-5">Deadline</th>
                                                    <th class="fs-5"></th>
                                                    <th class="fs-5"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($completedTasks as $task)
                                                    <tr>
                                                        <td>{{ $task->title }}</td>
                                                        <td>
                                                            @if (count($userNamesForTasks[$task->id]) > 1)
                                                                {{ implode(', ', $userNamesForTasks[$task->id]) }}
                                                            @else
                                                                {{ $userNamesForTasks[$task->id][0] }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $statusOptions[$task->status_id] }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($task->deadline)) }}</td>
                                                        <td class="text-end">
                                                            <a class="btn"
                                                                href="{{ route('dashboard.projects.reopenTask', ['project' => $project, 'task' => $task->id]) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" fill="currentColor"
                                                                    class="bi bi-arrow-up" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd"
                                                                        d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                                                </svg>
                                                            </a>
                                                        </td>

                                                        <td class="text-start"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif

                                    <div class="mb-3 d-flex justify-content-end">
                                        <a href="{{ route('dashboard.projects.index') }}"
                                            class="btn-lg btn btn-link">Terug</a>
                                        <button type="button"
                                            class="btn btn-primary btn-lg py-0 px-1 d-flex align-items-center justify-content-center"
                                            onclick="window.location.href='{{ route('dashboard.projects.tasks', ['project' => $project]) }}'">
                                            Taak Toevoegen
                                        </button>
                                    </div>
                                </div>

                            </div>
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

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
            </script>

</x-app-layout>
