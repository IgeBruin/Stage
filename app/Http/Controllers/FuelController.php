<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandUpdateValidation;
use App\Http\Requests\BrandStoreValidation;
use Illuminate\Http\Request;
use App\Models\Fuel;

class FuelController extends Controller
{
    public function index()
    {
        $fuels = Fuel::orderBy('created_at', 'desc')->paginate(5);
        return view("fuels.index", compact('fuels'));
    }

    public function create()
    {   
        $fuels = Fuel::get(); 
        return view("fuels.create", compact('fuels'));
    }

    public function store(BrandStoreValidation $request, Fuel $fuel)
    {
        $fuel->name = $request->name;

        $fuel->save();

        return redirect()->route("dashboard.fuels.index")->with('success', 'Brandstof aangemaakt');
    }

    public function edit($id)
    {
        $fuel = Fuel::find($id);
        $fuels = Fuel::all();
        return view("fuels.edit", compact('fuels', 'fuel'));
    }

    public function update(BrandUpdateValidation $request, Fuel $fuel)
    {
        $fuel->name = $request->name;
        $fuel->save();

        return redirect()->route("dashboard.fuels.index")->with('success', 'Brandstof aangepast');
    }


    public function destroy(Fuel $fuel)
    {
        $fuel->delete();
        return redirect()->route("dashboard.fuels.index")->with('success', 'Brandstof verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $fuels = Fuel::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("fuels.index", ["fuels" => $fuels]);
    }
}
