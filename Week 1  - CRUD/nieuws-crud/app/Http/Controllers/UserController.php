<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\Status;

class UserController extends Controller
{
    public function myProjects()
    {
        $user = auth()->user();
        $projects = $user->projects; 
    
        return view('users.myProjects', compact('projects'));
    }

    public function searchProject(Request $request, User $user)
    {
        $user = auth()->user();
        
        $query = $request->input('query');
        
        $projects = $user->projects()->where('name', 'like', '%' . $query . '%')->get();

        return view('users.myProjects', compact('projects'));
    }


    public function show(Project $project, Status $status)
    {
        $user = auth()->user();
        $users = $project->users()->get();
        $statusOptions = Status::pluck('name', 'id');
        $allTasks = $user->tasks()->where('project_id', $project->id)->get();
        $userTasks = $user->tasks()->where('project_id', $project->id)->get();
        $completedTasks = $project->tasks()->where('status_id', 3)->get();
        $openTasks = $project->tasks()->whereNotIn('status_id', [3])->get();

        return view('users.showProject', compact('project', 'users', 'allTasks', 'userTasks', 'statusOptions', 'completedTasks', 'openTasks'));
    }

    public function reopenTask(Project $project, Task $task)
    {
        $task->status_id = 2;
        $task->save();
    
        return redirect()->back()->with('success', 'Taak is heropend');
    }
    
    public function finishTask(Project $project, Task $task)
    {
        $task->status_id = 3;
        $task->save();
    
        return redirect()->back()->with('success', 'Taak is afgerond en staat nu in "Afgeronde Taken"');
    }
}