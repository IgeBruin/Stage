<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
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

        return view('orders.index', compact('products', 'totalCartPrice', 'totalVat', 'cartItems'));
    }

    public function store(Request $request)
    {
        // Retrieve cart items from the session
        $cartItems = session('cart', []);

        // Calculate the total cart price and total VAT
        $totalCartPrice = 0;
        $totalVat = 0;

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

        $shippingInfo = [
        'street' => $request->input('street'),
        'street_number' => $request->input('street_number'),
        'zip_code' => $request->input('zip_code'),
        'city' => $request->input('city'),
        'name' => $request->input('name'),
        'surname' => $request->input('surname'),
        'email' => $request->input('email'),
        'telephone' => $request->input('telephone'),
        ];

       
        session(['shippingInfo' => $shippingInfo]);

        // Redirect to the shipping page
        return redirect()->route('order.shipping');
    }


    public function shipping(Request $request, Order $order, Address $address)
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

        $shippingInfo = session('shippingInfo', []);
        // dd($shippingInfo);


        // Check if the checkbox is checked (useDifferentBilling)
        $useDifferentBilling = $request->has('useDifferentBilling');

    // Create shipping address (if applicable)
        if ($useDifferentBilling) {
            $shippingType = 'shipping';
            $shippingStreet = $request->input('shipping_street');
            $shippingStreetNumber = $request->input('shipping_street_number');
            $shippingZipCode = $request->input('shipping_zip_code');
            $shippingCity = $request->input('shipping_city');
        } else {
            $shippingType = 'invoice';
            $shippingStreet = $shippingInfo['street']; 
            $shippingStreetNumber = $shippingInfo['street_number']; 
            $shippingZipCode = $shippingInfo['zip_code']; 
            $shippingCity = $shippingInfo['city'];
        }

    
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->email = $shippingInfo['email'];
        $order->telephone = $shippingInfo['telephone'];
        $order->total_excl = $totalCartPrice;
        $order->vat = $totalVat;
        $order->total_incl = $totalCartPrice + $totalVat;
        $order->save();


        $shippingAddress = new Address();
        $shippingAddress->order_id = $order->id;
        $shippingAddress->type = $shippingType;
        $shippingAddress->street = $shippingStreet;
        $shippingAddress->street_number = $shippingStreetNumber;
        $shippingAddress->zip_code = $shippingZipCode;
        $shippingAddress->city = $shippingCity;
        $shippingAddress->name = $shippingInfo['name'];
        $shippingAddress->surname = $shippingInfo['surname'];
        $shippingAddress->save();


        foreach ($cartItems as $productId => $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->name = $item['name'];
                $orderItem->vat = $item['vat'];
                $orderItem->save();
        }

        return view('orders.shipping', compact('products', 'totalCartPrice', 'totalVat', 'useDifferentBilling', 'cartItems'));
    }
}
