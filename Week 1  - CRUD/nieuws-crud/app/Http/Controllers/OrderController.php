<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderStoreValidation;
use App\Http\Requests\ShippingValidationRequest;
use PDF;
//mail
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;

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

        Session::put('cart', $cartItems);


        return ['products' => $products, 'totalCartPrice' => $totalCartPrice, 'totalVat' => $totalVat, 'totalProductCount' => $totalProductCount];
    }

    public function cartIndex()
    {
        $cartItems = session('cart', []);
        $cartData = $this->processCartItems();

        Session::put('cart', $cartItems);

        return view('carts.index', $cartData);
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

    public function orderIndex()
    {
        $cartItems = session('cart', []);
        $cartData = $this->processCartItems();
        $shippingInfo = session('shippingInfo', []);

        Session::put('cart', $cartItems);

        return view('orders.index', $cartData , $shippingInfo);
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
            'type' => 'test staat in shippingInfo',
        ];

        session(['shippingInfo' => $shippingInfo]);

        return redirect()->route('order.shipping');
    }

    public function shipping(Request $request) 
    {
        $cartData = $this->processCartItems();
        $shippingInfo = session('shippingInfo', []);
    
        return view('orders.shipping', compact('cartData'));
    }

    public function process(ShippingValidationRequest $request, Order $order, Address $address)
    {
        // dd($request->all());
        $cartData = $this->processCartItems();
        $shippingInfo = session('shippingInfo', []);
    
        $order = new Order();
        if (Auth::check()) {
            $order->user_id = auth()->user()->id;
        } else {
            $order->user_id = null;
        }
        $order->email = $shippingInfo['email'];
        $order->telephone = $shippingInfo['telephone'];
        $order->total_excl = $cartData['totalCartPrice'];
        $order->vat = $cartData['totalVat'];
        $order->total_incl = $cartData['totalCartPrice'] + $cartData['totalVat'];
        $order->save();    

        $shippingName = $shippingInfo['name'];
        $shippingSurname = $shippingInfo['surname'];

        $shippingAddress = new Address();
        $shippingAddress->order_id = $order->id;
        $shippingAddress->type = 'Shipping';
        $shippingAddress->street = $shippingInfo['street'];
        $shippingAddress->street_number = $shippingInfo['street_number'];
        $shippingAddress->zip_code = $shippingInfo['zip_code'];
        $shippingAddress->city = $shippingInfo['city'];
        $shippingAddress->name = $shippingName;
        $shippingAddress->surname = $shippingSurname;
        $shippingAddress->save();
    
        if ($request->useDifferentBilling == false) {
            $billingAddress = new Address();
            $billingAddress->order_id = $order->id;
            $billingAddress->type = 'Invoice';
            $billingAddress->street = $request->input('billing_street');
            $billingAddress->street_number = $request->input('billing_street_number');
            $billingAddress->zip_code = $request->input('billing_zip_code');
            $billingAddress->city = $request->input('billing_city');
            $billingAddress->name = $shippingName; 
            $billingAddress->surname = $shippingSurname; 
            $billingAddress->save();
        }
    
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

        $addresses = Address::all();
        $address = $addresses->where('order_id', $order->id)->first();

        session(['cartData' => $cartData, 'address' => $address]);

        $email = $shippingInfo['email'];
        Mail::to($email)->send(new OrderPlaced($order));


        return redirect()->route('order.success')->with('success', 'Uw bestelling is geplaatst!');
    }

    public function success(Address $address)
    {
        $cartData = session('cartData');
        $address = session('address');
        $billingAddress = Address::where('order_id', $address->order_id)->where('type', 'Invoice')->first() ?? null;
        $view = view('orders.success', ['cartData' => $cartData, 'address' => $address, 'billingAddress' => $billingAddress])->with('success', 'Uw bestelling is geplaatst!');
        session()->forget('cart');
        return $view;
    }

    public function generatePDF(Address $address)
    {
        $cartData = session('cartData');
        $address = session('address');
        $billingAddress = Address::where('order_id', $address->order_id)->where('type', 'Invoice')->first() ?? null;
        $pdf = PDF::loadView('orders.pdf', ['cartData' => $cartData, 'address' => $address , 'billingAddress' => $billingAddress])->setPaper('a4', 'landscape');
        return $pdf->stream('factuur.pdf');
    }
}
