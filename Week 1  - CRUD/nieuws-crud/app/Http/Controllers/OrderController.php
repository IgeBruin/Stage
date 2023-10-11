<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutFormvalidation;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\OrderStoreValidation;
use App\Http\Requests\ShippingValidationRequest;

class OrderController extends Controller
{
    private function processCartItems()
    {
        $cartItems = session('cart', []);
        $totalCartPrice = 0;
        $totalVat = 0;
        $products = [];
        $totalProductCount = 0; 

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

                $totalProductCount += $item['quantity'];
            }

            $totalCartPrice += $item['subtotal'];
            $totalVat += $item['vat_amount'];
        }

        return ['products' => $products, 'totalCartPrice' => $totalCartPrice, 'totalVat' => $totalVat, 'totalProductCount' => $totalProductCount];
    }


    public function index()
    {
        $cartItems = session('cart', []);
        $cartData = $this->processCartItems();

        Session::put('cart', $cartItems);

        return view('orders.index', $cartData);
    }

    public function store(OrderStoreValidation $request)
    {

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

        return redirect()->route('order.shipping');
    }

    public function shipping(Request $request) 
    {
        $cartData = $this->processCartItems();
        $shippingInfo = session('shippingInfo', []);
    
        $useDifferentBilling = $request->has('useDifferentBilling');
    
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

        return view('orders.shipping', compact('useDifferentBilling', 'shippingType', 'shippingStreet', 'shippingStreetNumber', 'shippingZipCode', 'shippingCity', 'cartData'));
    }

    public function process(Order $order, Request $request, Address $address)
    {
        $cartData = $this->processCartItems();
        $shippingInfo = session('shippingInfo', []);
    
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->email = $shippingInfo['email'];
        $order->telephone = $shippingInfo['telephone'];
        $order->total_excl = $cartData['totalCartPrice'];
        $order->vat = $cartData['totalVat'];
        $order->total_incl = $cartData['totalCartPrice'] + $cartData['totalVat'];
        $order->save();
    
        $shippingType = 'shipping';
        $shippingStreet = $shippingInfo['street'];
        $shippingStreetNumber = $shippingInfo['street_number'];
        $shippingZipCode = $shippingInfo['zip_code'];
        $shippingCity = $shippingInfo['city'];
        $shippingName = $shippingInfo['name'];
        $shippingSurname = $shippingInfo['surname'];

        if (!$request->has('useDifferentBilling')) {
            $shippingType = 'invoice';
            $shippingStreet = $request->input('shipping_street');
            $shippingStreetNumber = $request->input('shipping_street_number');
            $shippingZipCode = $request->input('shipping_zip_code');
            $shippingCity = $request->input('shipping_city');
        }

        $shippingAddress = new Address();
        $shippingAddress->order_id = $order->id;
        $shippingAddress->type = $shippingType;
        $shippingAddress->street = $shippingStreet;
        $shippingAddress->street_number = $shippingStreetNumber;
        $shippingAddress->zip_code = $shippingZipCode;
        $shippingAddress->city = $shippingCity;
        $shippingAddress->name = $shippingName;
        $shippingAddress->surname = $shippingSurname;
        $shippingAddress->save();
    
        foreach ($cartData['products'] as $product) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product['id'];
            $orderItem->quantity = $product['quantity'];
            $orderItem->price = $product['price'];
            $orderItem->name = $product['name'];
            $orderItem->vat = $product['vat'];
            $orderItem->save();
        }

        $orders = Order::all();
        $addresses = Address::all();
        $address = $addresses->where('order_id', $order->id)->first();

    
        return view('orders.success', ['cartData' => $cartData, 'orders' => $orders, 'address' => $address])->with('success', 'Uw bestelling is geplaatst!');
    }
}
