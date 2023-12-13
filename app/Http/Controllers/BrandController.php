<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandUpdateValidation;
use App\Http\Requests\BrandStoreValidation;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'desc')->paginate(5);
        return view("brands.index", compact('brands'));
    }

    public function create()
    {   
        $brands = Brand::get(); 
        return view("brands.create", compact('brands'));
    }

    public function store(BrandStoreValidation $request, Brand $brand)
    {
        $brand->name = $request->name;

        $brand->save();

        return redirect()->route("dashboard.brands.index")->with('success', 'Merk aangemaakt');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        $brands = Brand::all();
        return view("brands.edit", compact('brands', 'brand'));
    }

    public function update(BrandUpdateValidation $request, Brand $brand)
    {
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route("dashboard.brands.index")->with('success', 'Merk aangepast');
    }


    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route("dashboard.brands.index")->with('success', 'Merk verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $brands = Brand::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("brands.index", ["brands" => $brands]);
    }
}
