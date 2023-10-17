<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use App\Http\Requests\RecipeStoreValidation;
use App\Http\Requests\RecipeUpdateValidation;
use App\Http\Requests\RecipeIngredientValidation;
use App\Models\RecipeIngredient;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::orderBy('created_at', 'desc')->paginate(5);
        return view("recipes.index", compact('recipes'));
    }

    public function create()
    {

        $recipes = Recipe::get();
        return view("recipes.create", compact('recipes'));
    }

    public function store(RecipeStoreValidation $request)
    {
    
        $recipe = new Recipe();
        $recipe->name = $request->name;
        $recipe->description = $request->description;
        $recipe->price = $request->price;
        $recipe->vat = $request->vat;
        $recipe->stock = $request->stock;


        $recipe->save();

        if ($request->hasFile('image')) {
            $imageName = $recipe->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('recipes/' . $recipe->id , $imageName);
            $recipe->image = $imageName;
        } else {
            $recipe->image = 'images/recipes/placeholder.png';
        }

        $recipe->save();

        return redirect()->route("dashboard.recipes.index")->with('success', 'recipe aangemaakt');
    }


    public function edit(Recipe $recipe, Ingredient $ingredient)
    {
        $recipe = Recipe::find($recipe->id);
        $recipes = Recipe::all();
        $ingredients = Ingredient::all();
        return view("recipes.edit", compact('recipes', 'recipe', 'ingredients'));
    }


    public function update(RecipeUpdateValidation $request, Recipe $recipe)
    {
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->instructions = $request->instructions;


        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::delete('recipes/' . $recipe->id . '/' . $recipe->image);
            }
            $imageName = $recipe->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('recipes/' . $recipe->id , $imageName);
            $recipe->image = $imageName;
        } elseif ($request->input('delete_image')) {
            if ($recipe->image) {
                Storage::delete('recipes/' . $recipe->id . '/' . $recipe->image);
                $recipe->image = "images/recipes/placeholder.png";
            }
        }

        $recipe->save();
    
        return redirect()->route("dashboard.recipes.index")->with('success', 'Recept aangepast');
    }
    

    public function destroy(Recipe $recipe)
    {

        if ($recipe->image && $recipe->image != 'images/recipes/placeholder.png') {
            Storage::delete('recipes/' . $recipe->id . '/' . $recipe->image);
        }

        $recipe->delete();

        return redirect(route("dashboard.recipes.index"))->with('success', 'Recept verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $recipes = Recipe::where('title', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("recipes.index", ["recipes" => $recipes]);
    }

    public function saveIngredients(Request $request, Recipe $recipe)
    {
        $ingredients = $request->input('ingredients');
    
        foreach ($ingredients as $ingredientId => $amount) {
            if (!empty($amount)) {
                $existingRecipeIngredient = RecipeIngredient::where('recipe_id', $recipe->id)
                    ->where('ingredient_id', $ingredientId)->first();
    
                if ($existingRecipeIngredient) {
                    $existingRecipeIngredient->update(['amount' => $amount]);
                } else {
                    RecipeIngredient::create([
                        'recipe_id' => $recipe->id,
                        'ingredient_id' => $ingredientId,
                        'amount' => $amount,
                    ]);
                }
            } else {
                RecipeIngredient::where('recipe_id', $recipe->id)
                    ->where('ingredient_id', $ingredientId)->delete();
            }
        }
    
        return redirect()->route('dashboard.recipes.index')->with('success', 'Ingredienten opgeslagen');
    }
}
