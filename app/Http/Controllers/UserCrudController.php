<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserStoreValidation;
use App\Http\Requests\UserUpdateValidation;
use Illuminate\Support\Facades\Storage;

class UserCrudController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        return view("users.index", compact('users'));
    }

    public function edit(User $user)
    {
        $user = User::find($user->id);
        $users = User::all();
        return view("users.edit", compact('users', 'user',));
    }

    public function update(UserUpdateValidation $request, User $user)
    {
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
    
        $user->isAdmin = $request->filled('isAdmin') ? true : false;
    
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
    
        return redirect()->route("dashboard.users.index")->with('success', 'Gebruiker aangepast');
    }
    
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route("dashboard.users.index"))->with('success', 'Gebruiker verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("users.index", ["users" => $users]);
    }

    public function create()
    {
            $users = User::get();
            return view("users.create", compact('users',));
    }

    public function store(UserStoreValidation $request, User $user)
    {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone  = $request->phone;
            $user->address = $request->address;
            $user->isAdmin = $request->isAdmin;
            $user->password = bcrypt($request->password);
            $user->save();

            $user->save();

            return redirect()->route("dashboard.users.index")->with('success', 'Gebruiker aangemaakt');
    }
}
