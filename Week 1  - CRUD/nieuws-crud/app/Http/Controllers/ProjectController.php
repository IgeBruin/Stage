<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateTaskValidation;
use App\Http\Requests\ProjectUpdateTaskValidation;
use App\Http\Requests\ProjectUpdateValidation;
use App\Http\Requests\ProjectStoreValidation;
use App\Http\Requests\ProjectAddUserValidation;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(5);
        return view("projects.index", compact('projects'));
    }

    public function create()
    {
        $projects = Project::get();
        return view("projects.create", compact('projects'));
    }

    public function store(ProjectStoreValidation $request)
    {
        $data = $request->validated();
    
        $project = new Project();
        $project->name = $data['name'];
        $project->introduction = $data['introduction'];
        $project->content = $data['content'];
        $project->start_date = $data['start_date'];

        $project->save();

        if ($request->hasFile('image')) {
            $imageName = $project->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('projects/' . $project->id , $imageName);
            $project->image = $imageName;
        } else {
            $project->image = 'images/projects/placeholder.png';
        }
    
        $project->save();

        return redirect()->route("dashboard.projects.index")->with('success', 'Project aangemaakt');
    }


    public function edit(Project $project)
    {
        $users = User::all();

        $userNamesForTasks = [];
        foreach ($project->tasks as $task) {
            $users = $task->users;
            foreach ($users as $user) {
                $userName = $user->name;
                if (!in_array($userName, $userNamesForTasks)) {
                    $userNamesForTasks[] = $userName;
                }
            }
        }

        $completedTasks = $project->tasks->where('status', 'Voltooid');

        return view("projects.edit", compact('project', 'users', 'userNamesForTasks', 'completedTasks'));
    }



    public function update(ProjectUpdateValidation $request, Project $project)
    {
        $project->name = $request->name;
        $project->introduction = $request->introduction;
        $project->content = $request->content;
        $project->start_date = $request->start_date;

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete('projects/' . $project->id . '/' . $project->image);
            }
            $imageName = $project->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('projects/' . $project->id , $imageName);
            $project->image = $imageName;
        } elseif ($request->input('delete_image')) {
            if ($project->image) {
                Storage::delete('projects/' . $project->id . '/' . $project->image);
                $project->image = "images/projects/placeholder.png";
            }
        }

        $project->save();
    
        return redirect()->route("dashboard.projects.index")->with('success', 'Project aangepast');
    }
    

    public function destroy(Project $project)
    {

        if ($project->image && $project->image != 'images/projects/placeholder.png') {
            Storage::delete('projects/' . $project->id . '/' . $project->image);
        }

        $project->delete();

        return redirect(route("dashboard.projects.index"))->with('success', 'Project verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $projects = Project::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("projects.index", ["projects" => $projects]);
    }

    public function users(Project $project)
    {
        $allUsers = User::all();
        $allRoles = Role::all();
        $projectUsers = $project->users()->pluck('users.id')->toArray(); // pluck is voor als je 1of meerdere specifieke dingen wil ophalen, en met d epunt kan je in nested  !!

        $availableUsers = $allUsers->filter(function ($user) use ($projectUsers) {
            return !in_array($user->id, $projectUsers);
        });

        return view('projects.addUser', compact('project', 'availableUsers', 'allRoles'));
    }

    public function addUser(ProjectAddUserValidation $request, Project $project)
    {
        $project->user_id = $request->user_id;
        $roleId = $request->input('role_id');

        $project->users()->attach([$request->user_id => ['role_id' => $roleId]]);
        return redirect()->route('dashboard.projects.edit', ['project' => $project, 'tab' => 'users'])
        ->with('success', 'Gebruiker is aan het project toegevoegd');
    }

    public function removeUser(Project $project, User $user)
    {
        $project->users()->detach($user->id);

        return redirect()->back()->with('success', 'Gebruiker is van het project verwijderd');
    }

    public function editRole(Project $project, $userId)
    {
        $user = User::find($userId);
        $allRoles = Role::all();

        return view('projects.editRole', compact('project', 'user', 'allRoles'));
    }


    public function updateRole(Request $request, Project $project, User $user)
    {
        $project->users()->updateExistingPivot($user->id, ['role_id' => $request->role_id]);
        return redirect()->route('dashboard.projects.edit', ['project' => $project])
        ->with('success', 'Gebruikersrol is bijgewerkt');
    }

    public function tasks(Project $project)
    {
        $allUsers = User::all();
        $allTasks = Task::all();

        return view('projects.tasks', compact('project', 'allUsers', 'allTasks', ));
    }

    public function createTask(Request $request, Project $project)
    {
        $allUsers = User::all();
        $allTasks = Task::all();

        $userId = $request->input('user_id');

        return view('projects.tasks', compact('project', 'allUsers', 'allTasks'));
    }

    public function storeTask(ProjectCreateTaskValidation $request, Project $project)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->project_id = $project->id;
        $task->save();

        $task->users()->attach($request->user_id);

        return redirect()->route('dashboard.projects.edit', ['project' => $project, 'tab' => 'tasks'])
        ->with('success', 'Taak is aangemaakt');
    }

    public function editTask(Project $project, Task $task)
    {
        $allUsers = User::all();
        $statusOptions = ['Niet gestart', 'In uitvoering', 'Voltooid'];

        return view('projects.editTask', compact('project', 'task', 'allUsers', 'statusOptions'));
    }

    public function updateTask(ProjectUpdateTaskValidation $request, Project $project, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->status = $request->status;

        $task->users()->sync([$request->user_id]);

        $task->save();

        return redirect()->route('dashboard.projects.edit', ['project' => $project, 'tab' => 'tasks'])
        ->with('success', 'Taak is bijgewerkt');
    }

    public function destroyTask(Project $project, Task $task)
    {

        $task->delete();

        return redirect()->route('dashboard.projects.edit', ['project' => $project, 'tab' => 'tasks'])
        ->with('success', 'Taak is verwijderd');
    }

    public function reopenTask(Project $project, Task $task)
    {
        $task->status = 'In uitvoering';
        $task->save();

        return redirect()->back()->with('success', 'Taak is heropend en staat nu op "In uitvoering"');
    }
    public function finishTask(Project $project, Task $task)
    {
        $task->status = 'Voltooid';
        $task->save();

        return redirect()->back()->with('success', 'Taak is afgerond en staat nu in "Afgeronde Taken"');
    }
}