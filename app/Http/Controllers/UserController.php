<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreValidation;
use App\Http\Requests\CarUpdateValidation;
use App\Http\Requests\CarSpecificationsValidation;
use Illuminate\Http\Request;
use App\models\Product;
use App\Models\Project;
use App\Models\User;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Task;
use App\Models\Specification;
use App\Models\Status;
use App\Models\Ingredient;
use App\Models\RecipeIngredient;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarSpecification;
use App\Models\Fuel;
use App\Models\Brand;
use App\Models\Type;
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
        return redirect()->route('user.myRecipes')->with('success', 'Ingredienten opgeslagen');
    }

    public function showCar(Car $car)
    {
        return view('users.showCar', compact('car'));
    }

    public function myCars()
    {
        $user = auth()->user();
        $cars = $user->cars()->orderBy('created_at', 'desc')->get();

        return view('users.myCars', compact('cars'));
    }

    public function destroyCar(Car $car)
    {
        $this->authorize('delete', $car);
        Storage::deleteDirectory("cars/{$car->id}");
        $car->delete();

        return redirect(route("user.myCars"))->with('success', 'Auto verwijderd');
    }

    public function searchCar(Request $request)
    {
        $query = $request->input('query');
    
        $cars = Car::where('title', 'like', "%$query%")
                    ->orWhereHas('brand', function ($brandQuery) use ($query) {
                        $brandQuery->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('fuel', function ($fuelQuery) use ($query) {
                        $fuelQuery->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('type', function ($typeQuery) use ($query) {
                        $typeQuery->where('name', 'like', "%$query%");
                    })
                    ->paginate(5)
                    ->withQueryString();
    
        return view("cars.overview", ["cars" => $cars])->with('success', 'hier het aantal auto\'s dat voldoet aan de zoekopdracht');
    }

    public function createCar()
    {
        $cars = Car::get();
        $brands = Brand::all();
        $types = Type::all();
        $fuels = Fuel::all();
        return view("users.createCar", compact('cars', 'brands', 'types', 'fuels'));
    }

    public function storeCar(CarStoreValidation $request)
    {
        $car = new Car();
        $car->title = $request->title;
        $car->description = $request->description;
        $car->brand_id = $request->brand_id;
        $car->type_id = $request->type_id;
        $car->fuel_id = $request->fuel_id;
        $car->year = $request->year;
        $car->mileage = $request->mileage;
        $car->mot = $request->mot;
        $car->price = $request->price;
        $car->user_id = auth()->user()->id;    
        $car->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $car->id . '_' .  $image->getClientOriginalName();
                $image->storeAs('cars/' . $car->id, $imageName);

                $car->images()->create([
                'image' => $imageName,
                ]);
            }
        }

        return redirect()->route("user.cars.showCar", $car)->with('success', 'Auto aangemaakt');
    }

    public function editCar(Car $car)
    {
        $this->authorize('update', $car);

        $car = Car::with('images')->find($car->id);
        $brands = Brand::all();
        $types = Type::all();
        $fuels = Fuel::all();
        $specifications = Specification::all();
        return view("users.editCar", compact('car', 'brands', 'types', 'specifications', 'fuels'));
    }
    
    public function updateCar(CarUpdateValidation $request, Car $car)
    {
        $this->authorize('update', $car);
        $car->title = $request->title;
        $car->description = $request->description;
        $car->brand_id = $request->brand_id;
        $car->type_id = $request->type_id;
        $car->fuel_id = $request->fuel_id;
        $car->year = $request->year;
        $car->mileage = $request->mileage;
        $car->mot = $request->mot;
        $car->price = $request->price;
        $car->user_id = auth()->user()->id;
        $car->save();
    

        if ($request->has('remove_images')) {
            $removedImages = $request->remove_images;
        
            if (!empty($removedImages)) {
                foreach ($removedImages as $imageId) {
                    $carImage = CarImage::find($imageId);
        
                    if ($carImage) {
                        $imagePath = "cars/{$car->id}/" . $carImage->image;
                        Storage::delete($imagePath);
        
                        $carImage->delete();
                    }
                }
            }
        }
    

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $car->id . '_' . $image->getClientOriginalName();
                $image->storeAs('cars/' . $car->id, $imageName);

                $car->images()->create([
                'image' => $imageName,
                ]);
            }
        }

        return redirect()->route("user.cars.showCar", $car)->with('success', 'Auto aangepast');
    }
    public function saveCarSpecifications(CarSpecificationsValidation $request, Car $car)
    {
        $specifications = $request->input('specifications');
    
        foreach ($specifications as $specificationId => $value) {
            if ($value === null || $value === '') {
                $existingCarSpecification = CarSpecification::where('car_id', $car->id)
                    ->where('specification_id', $specificationId)->first();
    
                if ($existingCarSpecification) {
                    $existingCarSpecification->delete();
                }
                continue;
            }
    
            $existingCarSpecification = CarSpecification::where('car_id', $car->id)
                ->where('specification_id', $specificationId)->first();
    
            if ($existingCarSpecification) {
                $existingCarSpecification->update(['value' => $value]);
            } else {
                CarSpecification::create([
                    'car_id' => $car->id,
                    'specification_id' => $specificationId,
                    'value' => $value,
                ]);
            }
        }
    
        return redirect()->route("user.cars.showCar", $car)->with('success', 'Specificaties aangepast');
    }

    public function carImages(Request $request, Car $car)
    {
        if ($request->has('remove_images')) {
            $removedImages = $request->remove_images;
        
            if (!empty($removedImages)) {
                foreach ($removedImages as $imageId) {
                    $carImage = CarImage::find($imageId);
        
                    if ($carImage) {
                        $imagePath = "cars/{$car->id}/" . $carImage->image;
                        Storage::delete($imagePath);
        
                        $carImage->delete();
                    }
                }
            }
        }
    

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $car->id . '_' . $image->getClientOriginalName();
                $image->storeAs('cars/' . $car->id, $imageName);

                $car->images()->create([
                'image' => $imageName,
                ]);
            }
        }
        return redirect()->route("user.cars.showCar", $car)->with('success', "Foto's aangepast");
    }
}
