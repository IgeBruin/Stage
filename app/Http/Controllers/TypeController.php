<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeUpdateValidation;
use App\Http\Requests\TypeStoreValidation;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::orderBy('created_at', 'desc')->paginate(5);
        return view("types.index", compact('types'));
    }

    public function create()
    {   
        $types = Type::get(); 
        return view("types.create", compact('types'));
    }

    public function store(TypeStoreValidation $request, Type $type)
    {
        $type->name = $request->name;

        $type->save();

        return redirect()->route("dashboard.types.index")->with('success', 'Merk aangemaakt');
    }

    public function edit($id)
    {
        $type = Type::find($id);
        $types = Type::all();
        return view("types.edit", compact('types', 'type'));
    }

    public function update(TypeUpdateValidation $request, Type $type)
    {
        $type->name = $request->name;
        $type->save();

        return redirect()->route("dashboard.types.index")->with('success', 'Type model aangepast');
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->route("dashboard.types.index")->with('success', 'Type model verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $types = Type::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("types.index", ["types" => $types]);
    }
}
