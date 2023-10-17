<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Http\Requests\IngredientStoreValidation;
use App\Http\Requests\IngredientUpdateValidation;	

class IngredientController extends Controller
{
    public function index()
    {

        $ingredients = Ingredient::orderby('created_at', 'desc')->paginate(5);
        return view("ingredients.index", compact('ingredients'));
    }

    public function create()
    {   

        $ingredients = Ingredient::get();
        return view("ingredients.create", compact('ingredients'));
    }

    public function store(IngredientStoreValidation $request, Ingredient $ingredient)
    {
        $ingredient->name = $request->name;

        $ingredient->save();

        return redirect()->route("dashboard.ingredients.index")->with('success', 'Ingredient aangemaakt');
    }

    public function edit($id)
    {
        $ingredient = Ingredient::find($id);
        $ingredients = Ingredient::all();
    
        return view("ingredients.edit", compact('ingredients', 'ingredient'));
    }
    
    

    public function update(IngredientUpdateValidation $request, Ingredient $ingredient)
    {

        $ingredient->name = $request->name;
        $ingredient->save();

        return redirect()->route("dashboard.ingredients.index")->with('success', 'Ingredient aangepast');
    }

    public function destroy(Ingredient $ingredient)
    {

        $ingredient->delete();

        return redirect()->route("dashboard.ingredient.index")->with('success', 'Ingredient verwijderd'); 
    }

    public function search(Request $request)
    {

        $query = $request->input('query');
        $ingredients = Ingredient::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("ingredients.index", ["ingredients" => $ingredients]);
    }
}
