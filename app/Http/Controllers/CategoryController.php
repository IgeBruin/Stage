<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryUpdateValidation;
use App\Http\Requests\CategoryStoreValidation;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderby('created_at', 'desc')->paginate(5);
        return view("categories.index", compact('categories'));
    }

    public function create()
    {   
        $categories = Category::get(); 
        return view("categories.create", compact('categories'));
    }

    public function store(CategoryStoreValidation $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('categories/' . $category->id . '/' . $category->image);
            }
            $imageName = $category->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('categories/' . $category->id , $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect()->route("dashboard.categories.index")->with('success', 'Categorie aangemaakt');
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        $category = Category::find($category->id);
        return view("categories.edit", compact('categories' , 'category'));
    }

    public function update(CategoryUpdateValidation $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete('categories/' . $category->id . '/' . $category->image);
            }
            $imageName = $category->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('categories/' . $category->id , $imageName);
            $category->image = $imageName;
        } elseif ($request->input('delete_image')) {
            if ($category->image) {
                Storage::delete('categories/' . $category->id . '/' . $category->image);
                $category->image = "images/categories/placeholder.png";
            }
        }

        $category->save();

        return redirect()->route("dashboard.categories.index")->with('success', 'Categorie aangepast');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route("dashboard.categories.index")->with('success', 'Categorie verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("categories.index", ["categories" => $categories]);
    }
}
