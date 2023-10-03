<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUpdateValidation;
use App\Http\Requests\ProductStoreValidation;
use App\Http\Requests\ProductSpecificationsValidation;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Specification;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(5);
        return view("products.index", compact('products'));
    }

    public function create()
    {

        $products = Product::get();
        return view("products.create", compact('products'));
    }

    public function store(ProductStoreValidation $request)
    {
    
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->vat = $request->vat;
        $product->stock = $request->stock;


        $product->save();

        if ($request->hasFile('image')) {
            $imageName = $product->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('products/' . $product->id , $imageName);
            $product->image = $imageName;
        } else {
            $product->image = 'images/products/placeholder.png';
        }

        $product->save();

        return redirect()->route("dashboard.products.index")->with('success', 'product aangemaakt');
    }


    public function edit(Product $product)
    {
        $product = Product::find($product->id);
        $products = Product::all();
        $specifications = Specification::all();
        return view("products.edit", compact('products', 'product', 'specifications'));
    }


    public function update(ProductUpdateValidation $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->vat = $request->vat;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('products/' . $product->id . '/' . $product->image);
            }
            $imageName = $product->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('products/' . $product->id , $imageName);
            $product->image = $imageName;
        } elseif ($request->input('delete_image')) {
            if ($product->image) {
                Storage::delete('products/' . $product->id . '/' . $product->image);
                $product->image = "images/products/placeholder.png";
            }
        }

        $product->save();
    
        return redirect()->route("dashboard.products.index")->with('success', 'Product aangepast');
    }
    

    public function destroy(Product $product)
    {

        if ($product->image && $product->image != 'images/products/placeholder.png') {
            Storage::delete('products/' . $product->id . '/' . $product->image);
        }

        $product->delete();

        return redirect(route("dashboard.products.index"))->with('success', 'Product verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("products.index", ["products" => $products]);
    }

    public function saveSpecifications(ProductSpecificationsValidation $request, Product $product)
    {
        $specifications = $request->input('specifications');

        foreach ($specifications as $specificationId => $value) {
            $existingProductSpecification = ProductSpecification::where('product_id', $product->id)
            ->where('specification_id', $specificationId)
            ->first();

            if ($existingProductSpecification) {
                $existingProductSpecification->update(['value' => $value]);
            } else {
                ProductSpecification::create([
                'product_id' => $product->id,
                'specification_id' => $specificationId,
                'value' => $value,
                ]);
            }
        }

        return redirect()->route('dashboard.products.index')->with('success', 'Specificaties opgeslagen');
    }
}
