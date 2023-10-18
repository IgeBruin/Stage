<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;
use App\Models\Post as Post;
use App\Models\Category as Category;
use App\Models\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//start
Route::get('/', function () {
    $today = Carbon::today();
    $posts = Post::whereDate('publication_date', '<=', $today)->get();
    $categories = Category::all();
    return view("articles.index", ["posts" => $posts, "categories" => $categories]);
});

// admin
Route::middleware('admin')->group(function () {
    Route::get('/dashboard', function () {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::all(); 
        return view('articles.dashboard', compact('posts', 'categories')); 
    })->middleware(['auth', 'verified'])->name('dashboard');
});


Route::get("articles", [PostController::class, "index"])->name("articles.index");
Route::get('products/{product}/show', [UserController::class, 'showProduct'])->name('showProduct');
Route::get('products', [UserController::class, 'allProducts'])->name('products');
Route::get('products/searchProduct', [UserController::class, 'searchProduct'])->name('searchProduct');

Route::get('cart', [OrderController::class, 'cartIndex'])->name('cart.index');
Route::post('cart/add', [OrderController::class, 'add'])->name('cart.add');
Route::delete('/cart/{productId}/remove', [OrderController::class, 'remove'])->name('cart.remove');
Route::put('/cart/{productId}/update', [OrderController::class, 'update'])->name('cart.update');

Route::get('order', [OrderController::class, 'orderIndex'])->name('order.index');
Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/shipping', [OrderController::class, 'shipping'])->name('order.shipping');
Route::post('/order/process', [OrderController::class, 'process'])->name('order.process');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
Route::get('generate-pdf', [OrderController::class, 'generatePDF'])->name('order.generatePDF');

Route::get('recipes', [UserController::class, 'allrecipes'])->name('recipes');
Route::get('recipes/searchRecipe', [UserController::class, 'searchRecipe'])->name('searchRecipe');




// alleen ingelogde gebruikers
Route::middleware('auth')->group(function () {

    Route::prefix('user')->name('user.')->group(function () {
        //projects
        Route::get('projects', [UserController::class, 'myProjects'])->name('projects');
        Route::get('projects/search', [UserController::class, 'searchProject'])->name('search');
        Route::get('projects/{project}/show', [UserController::class, 'show'])->name('showProject');

        Route::get('myOrders', [UserController::class, 'myOrders'])->name('myOrders');
        Route::get('myOrders/{order}/show', [UserController::class, 'showOrder'])->name('showOrder');

        Route::get('myRecipes', [UserController::class, 'myRecipes'])->name('myRecipes');
        Route::get('myRecipes/{recipe}/show', [UserController::class, 'showRecipe'])->name('showRecipe');
    });
//admin only
    Route::middleware('admin')->group(function () {

        Route::prefix('dashboard')->name('dashboard.')->group(function () {

            //dus dashboard/articles/ en dan hier de naam van de functie
            Route::prefix('articles')->name('articles.')->group(function () {
                Route::get('', [PostController::class, 'dashboardAll'])->name('index');
                Route::get('create', [PostController::class, 'create'])->name('create');
                Route::post('', [PostController::class, 'store'])->name('store');
                Route::get('{post}/edit', [PostController::class, 'edit'])->name('edit');
                Route::put('{post}/update', [PostController::class, 'update'])->name('update');
                Route::delete('{post}/destroy', [PostController::class, 'destroy'])->name('destroy');
                Route::get('search', [PostController::class, 'search'])->name('search');
            });
            //dus dashboard/products/ en dan hier de naam van de functie
            Route::prefix('products')->name('products.')->group(function () {
                Route::get('', [ProductController::class, 'index'])->name('index');
                Route::get('create', [ProductController::class, 'create'])->name('create');
                Route::post('', [ProductController::class, 'store'])->name('store');
                Route::get('{product}/edit', [ProductController::class, 'edit'])->name('edit');
                Route::put('{product}', [ProductController::class, 'update'])->name('update');
                Route::delete('{product}/destroy', [ProductController::class, 'destroy'])->name('destroy');
                Route::get('search', [ProductController::class, 'search'])->name('search');
                Route::post('{product}/saveSpecifications', [ProductController::class, 'saveSpecifications'])->name('saveSpecifications');
                Route::post('{product}/addCategory', [ProductController::class, 'addCategory'])->name('addCategory');
            });

            //dus dashboard/recipes/ en dan hier de naam van de functie
            Route::prefix('recipes')->name('recipes.')->group(function () {
                Route::get('', [RecipeController::class, 'index'])->name('index');
                Route::get('create', [RecipeController::class, 'create'])->name('create');
                Route::post('', [RecipeController::class, 'store'])->name('store');
                Route::get('{recipe}/edit', [RecipeController::class, 'edit'])->name('edit');
                Route::put('{recipe}', [RecipeController::class, 'update'])->name('update');
                Route::delete('{recipe}/destroy', [RecipeController::class, 'destroy'])->name('destroy');
                Route::get('search', [RecipeController::class, 'search'])->name('search');
                Route::post('{recipe}/saveIngredients', [RecipeController::class, 'saveIngredients'])->name('saveIngredients');
                Route::post('{recipe}/addCategory', [RecipeController::class, 'addCategory'])->name('addCategory');
            });
            //dus dashboard/categories/ en dan hier de naam van de functie
            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('', [CategoryController::class, 'index'])->name('index');
                Route::get('create', [CategoryController::class, 'create'])->name('create');
                Route::post('', [CategoryController::class, 'store'])->name('store');
                Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('edit');
                Route::put('{category}', [CategoryController::class, 'update'])->name('update');
                Route::delete('{category}', [CategoryController::class, 'destroy'])->name('destroy');
                Route::get('search', [CategoryController::class, 'search'])->name('search');
            });
            //dus dashboard/projects/ en dan hier de naam van de functie
            Route::prefix('projects')->name('projects.')->group(function () {
                Route::get('', [ProjectController::class, 'index'])->name('index');
                Route::get('create', [ProjectController::class, 'create'])->name('create');
                Route::post('', [ProjectController::class, 'store'])->name('store');
                Route::get('{project}/edit', [ProjectController::class, 'edit'])->name('edit');
                Route::put('{project}', [ProjectController::class, 'update'])->name('update');
                Route::delete('{project}', [ProjectController::class, 'destroy'])->name('destroy');
                Route::get('search', [ProjectController::class, 'search'])->name('search');

                Route::get('{project}/users', [ProjectController::class, 'users'])->name('users');
                Route::put('{project}/users/{user}/updateRole', [ProjectController::class, 'updateRole'])->name('updateRole');
                Route::get('{project}/users/{user}/editRole', [ProjectController::class, 'editRole'])->name('editRole');
                Route::post('{project}/addUser', [ProjectController::class, 'addUser'])->name('addUser');
                Route::delete('projects/{project}/removeUser/{user}', [ProjectController::class, 'removeUser'])->name('removeUser');

                Route::get('{project}/tasks', [ProjectController::class, 'tasks'])->name('tasks');
                Route::get('{project}/tasks/create', [ProjectController::class, 'createTask'])->name('createTask');
                Route::post('{project}/tasks', [ProjectController::class, 'storeTask'])->name('storeTask');
                Route::get('{project}/tasks/{task}/edit', [ProjectController::class, 'editTask'])->name('editTask');
                Route::put('{project}/tasks/{task}', [ProjectController::class, 'updateTask'])->name('updateTask');
                Route::delete('{project}/tasks/{task}', [ProjectController::class, 'destroyTask'])->name('destroyTask');
                Route::get('{project}/reopentask/{task}', [ProjectController::class, 'reopenTask'])->name('reopenTask');
                Route::get('{project}/finishtask/{task}', [ProjectController::class, 'finishTask'])->name('finishTask');
            });
        
            //dus dashboard/roles/ en dan hier de naam van de functie
            Route::prefix('roles')->name('roles.')->group(function () {
                Route::get('', [RoleController::class, 'index'])->name('index');
                Route::get('create', [RoleController::class, 'create'])->name('create');
                Route::post('', [RoleController::class, 'store'])->name('store');
                Route::get('{role}/edit', [RoleController::class, 'edit'])->name('edit');
                Route::put('{role}', [RoleController::class, 'update'])->name('update');
                Route::delete('{role}', [RoleController::class, 'destroy'])->name('destroy');
                Route::get('search', [RoleController::class, 'search'])->name('search');
            });

            //dus dashboard/statuses/ en dan hier de naam van de functie
            Route::prefix('statuses')->name('statuses.')->group(function () {
                Route::get('', [StatusController::class, 'index'])->name('index');
                Route::get('create', [StatusController::class, 'create'])->name('create');
                Route::post('', [StatusController::class, 'store'])->name('store');
                Route::get('{status}/edit', [StatusController::class, 'edit'])->name('edit');
                Route::put('{status}', [StatusController::class, 'update'])->name('update');
                Route::delete('{status}', [StatusController::class, 'destroy'])->name('destroy');
                Route::get('search', [StatusController::class, 'search'])->name('search');
            });

            //dus dashboard/specifications/ en dan hier de naam van de functie
            Route::prefix('specifications')->name('specifications.')->group(function () {
                Route::get('', [SpecificationController::class, 'index'])->name('index');
                Route::get('create', [SpecificationController::class, 'create'])->name('create');
                Route::post('', [SpecificationController::class, 'store'])->name('store');
                Route::get('{specification}/edit', [SpecificationController::class, 'edit'])->name('edit');
                Route::put('{specification}', [SpecificationController::class, 'update'])->name('update');
                Route::delete('{specification}', [SpecificationController::class, 'destroy'])->name('destroy');
                Route::get('search', [SpecificationController::class, 'search'])->name('search');
            });
            //dus dashboard/roles/ en dan hier de naam van de functie
            Route::prefix('ingredients')->name('ingredients.')->group(function () {
                Route::get('', [IngredientController::class, 'index'])->name('index');
                Route::get('create', [IngredientController::class, 'create'])->name('create');
                Route::post('', [IngredientController::class, 'store'])->name('store');
                Route::get('{ingredient}/edit', [IngredientController::class, 'edit'])->name('edit');
                Route::put('{ingredient}', [IngredientController::class, 'update'])->name('update');
                Route::delete('{ingredient}', [IngredientController::class, 'destroy'])->name('destroy');
                Route::get('search', [IngredientController::class, 'search'])->name('search');
            });
        });
    // profile door breeze
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

//blijkbaar moet dit onderaan staan
require __DIR__ . '/auth.php';
