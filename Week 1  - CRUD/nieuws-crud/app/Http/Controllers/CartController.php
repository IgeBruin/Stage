<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []); 
        $totalCartPrice = 0;
        $totalVat = 0;

        $products = []; 

        foreach ($cartItems as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                $item['id'] = $product->id;
                $item['name'] = $product->name;
                $item['price'] = $product->price;
                $item['vat'] = $product->vat;
                $item['image'] = $product->image === 'images/products/placeholder.png' ? "placeholder.png" : $product->id . '/' . $product->image;
                $item['subtotal'] = $item['price'] * $item['quantity'];
                $item['vat_amount'] = ($item['subtotal'] * $item['vat']) / 100;
                $products[] = $item;
            } 
    
            $totalCartPrice += $item['subtotal'];
            $totalVat += $item['vat_amount'];
        }

        Session::put('cart', $cartItems);

        return view('carts.index', compact('products', 'totalCartPrice', 'totalVat', 'cartItems'));
    }


    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::find($productId);

        if ($product) {
            $cart = Session::get('cart', []);

            if (array_key_exists($productId, $cart)) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                'quantity' => $quantity,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'vat' => $product->vat,
                'image' => $product->image === 'images/products/placeholder.png' ? "placeholder.png" : $product->id . '/' . $product->image,
                ];
            }

            Session::put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Product is toegevoegd aan het winkelmandje.');
        } else {
            return redirect()->route('cart.index')->with('error', 'Product not found.');
        }
    }


    public function remove(Request $request, $productId)
    {
        $cart = Session::get('cart', []);

        if (array_key_exists($productId, $cart)) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product is verwijderd uit het winkelmandje.');
    }

    public function update(Request $request, $productId)
    {
        $action = $request->input('action');

        if ($action === 'increase') {
            $this->increaseQuantity($productId);
        } elseif ($action === 'decrease') {
            $this->decreaseQuantity($productId);
        }

        return redirect()->route('cart.index')->with('success', 'Aantal producten is bijgewerkt.');
    }

    private function increaseQuantity($productId)
    {
        $cart = Session::get('cart', []);

        if (array_key_exists($productId, $cart)) {
            $cart[$productId]['quantity']++;
            Session::put('cart', $cart);
        }
    }

    private function decreaseQuantity($productId)
    {
        $cart = Session::get('cart', []);

        if (array_key_exists($productId, $cart)) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                unset($cart[$productId]);
            }
            Session::put('cart', $cart);
        }
    }
}
