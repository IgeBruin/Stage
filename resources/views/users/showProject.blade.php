<x-app-layout>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-semibold text-heading3 leading-tight text-md-start text-center text-indigo-500">
            {{ __('Project Weergave') }}
        </h1>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            @include('menus.user_menu')
            <div class="col-md-10">
                <div class="d-flex flex-column justify-content-start">

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                @if ($project->image == 'images/projects/placeholder.png')
                                    <img src="{{ asset('images/projects/placeholder.png') }}" alt="Placeholder"
                                        class="card-img-top img-fluid object-cover" style="max-height: 200px;">
                                @elseif ($project->image)
                                    <img src="{{ asset("images/projects/{$project->id}/{$project->image}") }}"
                                        alt="{{ $project->title }}" class="card-img-top img-fluid object-cover"
                                        style=" max-height: 200px;">
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3 class="card-title">{{ $project->name }}</h3>
                                        <p class="card-text"><strong>Start Datum:</strong> {{ $project->start_date }}
                                        </p>
                                    </div>
                                    <p class="card-text">{{ $project->introduction }}</p>
                                    <p class="card-text">{!! $project->content !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="alle-taken-tab" data-bs-toggle="tab"
                                        href="#alle-taken" role="tab" aria-controls="alle-taken"
                                        aria-selected="true">Alle Taken</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="mijn-taken-tab" data-bs-toggle="tab" href="#mijn-taken"
                                        role="tab" aria-controls="mijn-taken" aria-selected="false">Mijn
                                        Taken</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="afgeronde-taken-tab" data-bs-toggle="tab"
                                        href="#afgeronde-taken" role="tab" aria-controls="afgeronde-taken"
                                        aria-selected="false">Afgeronde Taken</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="alle-taken" role="tabpanel"
                                    aria-labelledby="alle-taken-tab">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Gebruiker</th>
                                                <th>Rol</th>
                                                <th>Taak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                @php
                                                    $tasksForProject = $user->tasks->where('project_id', $project->id);
                                                @endphp

                                                @if ($tasksForProject->isEmpty())
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>
                                                            @if ($user->pivot->role_id)
                                                                {{ $user->roles->where('id', $user->pivot->role_id)->first()->name }}
                                                            @else
                                                                Geen rol toegewezen
                                                            @endif
                                                        </td>
                                                        <td>Geen taak toegewezen voor dit project.</td>
                                                    </tr>
                                                @else
                                                    @foreach ($tasksForProject as $task)
                                                        <tr>
                                                            <td>{{ $user->name }}</td>
                                                            <td>
                                                                @if ($user->pivot->role_id)
                                                                    {{ $user->roles->where('id', $user->pivot->role_id)->first()->name }}
                                                                @else
                                                                    Geen rol toegewezen
                                                                @endif
                                                            </td>
                                                            <td>{{ $task->title }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="mijn-taken" role="tabpanel"
                                    aria-labelledby="mijn-taken-tab">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Taak</th>
                                                <th>Status</th>
                                                @if (isset($task))
                                                    @can('manage', App\models\Project::class)
                                                        <th>Voltooien</th>
                                                    @endcan
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($userTasks as $task)
                                                <tr>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $statusOptions[$task->status_id] }}</td>
                                                    @can('manage', App\models\Project::class)
                                                        <td class="text-start">
                                                            <a class="btn"
                                                                href="{{ route('dashboard.projects.finishTask', ['project' => $project, 'task' => $task->id, 'user', $user->id]) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="25"
                                                                    height="25" fill="currentColor" class="bi bi-check"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    @endcan
                                                </tr>
                                            @endforeach
                                            @if ($userTasks->isEmpty())
                                                <tr>
                                                    <td>Geen taken toegewezen voor dit project.</td>
                                                    <td>Geen status beschikbaar</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                </div>




                                <div class="tab-pane fade" id="afgeronde-taken" role="tabpanel"
                                    aria-labelledby="afgeronde-taken-tab">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Taak</th>
                                                <th>Status</th>
                                                @if (isset($task) && $task->status_id == 3)
                                                    @can('manage', App\models\Project::class)
                                                        <th>Terugzetten</th>
                                                    @endcan
                                                @else
                                                    <th></th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($completedTasks as $task)
                                                <tr>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $statusOptions[$task->status_id] }}</td>
                                                    @if (isset($task) && $task->status_id == 3)
                                                        @can('manage', App\models\Project::class)
                                                            <td class="text-start">
                                                                <a class="btn"
                                                                    href="{{ route('dashboard.projects.reopenTask', ['project' => $project, 'task' => $task->id]) }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" fill="currentColor"
                                                                        class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        @endcan
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>Geen voltooide taken voor dit project.</td>
                                                    <td>Geen status beschikbaar</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>


                                <div class="mb-3 d-flex justify-content-end">
                                    <a href="{{ route('user.projects') }}" class="btn-lg btn btn-link m-2">Terug</a>
                                </div>
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
        {{-- <script>
            var myTab = new bootstrap.Tab(document.getElementById('alle-taken-tab'));
            myTab.show();
        </script> --}}
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</x-app-layout>
