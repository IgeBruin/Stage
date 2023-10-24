<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SpecificationStoreValidation;
use App\Http\Requests\SpecificationUpdateValidation;
use App\Models\Specification;

class SpecificationController extends Controller
{
    public function index()
    {

        $specifications = Specification::orderby('created_at', 'desc')->paginate(5);
        return view("specifications.index", compact('specifications'));
    }

    public function create()
    {   

        $specifications = Specification::get();
        return view("specifications.create", compact('specifications'));
    }

    public function store(SpecificationStoreValidation $request, Specification $specification)
    {
        $specification->name = $request->name;

        $specification->save();

        return redirect()->route("dashboard.specifications.index")->with('success', 'Status aangemaakt');
    }

    public function edit($id)
    {
        $specification = Specification::find($id);
        $specifications = Specification::all();
    
        return view("specifications.edit", compact('specifications', 'specification'));
    }
    
    

    public function update(SpecificationUpdateValidation $request, Specification $specification)
    {

        $specification->name = $request->name;
        $specification->save();

        return redirect()->route("dashboard.specifications.index")->with('success', 'Specificatie aangepast');
    }

    public function destroy(Specification $specification)
    {

        $specification->delete();

        return redirect()->route("dashboard.specifications.index")->with('success', 'Specificatie verwijderd'); 
    }

    public function search(Request $request)
    {

        $query = $request->input('query');
        $specifications = Specification::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("specifications.index", ["specifications" => $specifications]);
    }
}
