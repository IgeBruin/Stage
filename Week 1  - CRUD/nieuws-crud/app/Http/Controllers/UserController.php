<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use App\Models\Project;
use App\Models\User;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Task;
use App\Models\Status;
use App\Models\Ingredient;
use App\Models\RecipeIngredient;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RecipeStoreValidation;
use App\Http\Requests\RecipeUpdateValidation;
use Illuminate\Support\Facades\Gate;

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
        $this->authorize('view', $project);
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

    public function allProducts(Product $product)
    {
        $products = Product::all();

        return view('users.allProducts', compact('products'));
    }

    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("users.allProducts", ["products" => $products]);
    }

    public function showProduct(Product $product)
    {
        return view('users.showProduct', compact('product'));
    }

    public function myOrders()
    {
        $user = auth()->user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        return view('users.myOrders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $user = auth()->user();
        $this->authorize('view', $order);

    
        $address = $order->address;
        return view('users.showOrder', compact('order', 'address'));
    }

    public function allRecipes()
    {
        $recipes = Recipe::all();

        return view('users.allRecipes', compact('recipes'));
    }

    public function myRecipes()
    {
        $user = auth()->user();
        $recipes = $user->recipes()->orderBy('created_at', 'desc')->get();

        return view('users.myRecipes', compact('recipes'));
    }

    public function showRecipe(Recipe $recipe)
    {
        $user = auth()->user();
        return view('users.showRecipe', compact('recipe'));
    }

    public function searchRecipe(Request $request)
    {
        $query = $request->input('query');
        $recipes = Recipe::where('title', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("users.allRecipes", ["recipes" => $recipes]);
    }

    public function createRecipe()
    {
        $ingredients = Ingredient::all();
        $recipes = Recipe::get();
        return view("users.createRecipe", compact('recipes', 'ingredients'));
    }

    public function storeRecipe(RecipeStoreValidation $request, User $user)
    {
        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->instructions = $request->instructions;
        $recipe->save();

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

        $recipe->save();

        if ($request->hasFile('image')) {
            $imageName = $recipe->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('recipes/' . $recipe->id , $imageName);
            $recipe->image = $imageName;
        } else {
            $recipe->image = 'images/recipes/placeholder.png';
        }

        $recipe->save();

        auth()->user()->recipes()->attach($recipe);

        return redirect()->route("user.myRecipes")->with('success', 'Recept aangemaakt');
    }

    public function destroyrecipe(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        if ($recipe->image && $recipe->image != 'images/recipes/placeholder.png') {
            Storage::delete('recipes/' . $recipe->id . '/' . $recipe->image);
        }

        $recipe->delete();

        return redirect(route("user.myRecipes"))->with('success', 'Recept verwijderd');
    }

    public function editRecipe(Recipe $recipe, Ingredient $ingredient)
    {
        $this->authorize('update', $recipe);
        $recipe = Recipe::find($recipe->id);
        $recipes = Recipe::all();
        $ingredients = Ingredient::all();
        return view("users.editRecipe", compact('recipes', 'recipe', 'ingredients'));
    }


    public function updateRecipe(RecipeUpdateValidation $request, Recipe $recipe)
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
    
        return redirect()->route("user.myRecipes")->with('success', 'Recept aangepast');
    }
}
