<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleUpdateValidation;
use App\Http\Requests\RoleStoreValidation;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderby('created_at', 'desc')->paginate(5);
        return view("roles.index", compact('roles'));
    }

    public function create()
    {   
        $roles = Role::get(); 
        return view("roles.create", compact('roles'));
    }

    public function store(RoleStoreValidation $request, Role $role)
    {
        $role->name = $request->name;

        $role->save();

        return redirect()->route("dashboard.roles.index")->with('success', 'Rol aangemaakt');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $roles = Role::all();
        return view("roles.edit", compact('roles', 'role'));
    }


    public function update(RoleUpdateValidation $request, Role $role)
    {
        $role->name = $request->name;
        $role->save();

        return redirect()->route("dashboard.roles.index")->with('success', 'Rol aangepast');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route("dashboard.roles.index")->with('success', 'Rol verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $roles = Role::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("roles.index", ["roles" => $roles]);
    }
}
