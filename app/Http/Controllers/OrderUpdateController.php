<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Http\Requests\OrderUpdateValidation;

class OrderUpdateController extends Controller
{
    public function dashboard()
    {
        $orders = Order::orderby('created_at', 'desc')->paginate(5);
        return view("orders.dashboard", compact('orders'));
    }

    public function edit(Order $order)
    {
        $order = Order::with('items')->find($order->id);
    
        return view('orders.edit', compact('order'));
    }
    
    public function update(OrderUpdateValidation $request, Order $order)
    {
        $order->update([
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
        ]);
    
        $orderItemData = $request->input('order_items');
    
        if ($orderItemData == null) {
            return redirect()->route('dashboard.orders.dashboard')->with('success', 'Bestelling aangepast');
        } else {
            foreach ($orderItemData as $itemId => $itemAttributes) {
                $orderItem = OrderItem::find($itemId);
    
                if (isset($itemAttributes['_remove']) && $itemAttributes['_remove'] === '1') {
                    $orderItem->delete();
                } else {
                    $orderItem->update([
                        'quantity' => $itemAttributes['quantity'],
                    ]);
                }
            }
    
            $order->calculateTotals();
        }
    
        return redirect()->route('dashboard.orders.dashboard')->with('success', 'Bestelling aangepast');
    }
    
    
    
    public function destroy(Order $order)
    {

        Address::where('order_id', $order->id)->delete();
        Order::find($order->id)->delete();
        return redirect()->route("dashboard.orders.dashboard")->with('success', 'Bestelling verwijderd');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $orders = Order::where(function ($queryBuilder) use ($query) {
            $queryBuilder
                ->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery->where('name', 'like', "%$query%")
                        ->orWhere('email', 'like', "%$query%")
                        ->orWhere('telephone', 'like', "%$query%");
                })
                ->orWhere('email', 'like', "%$query%")
                ->orWhere('telephone', 'like', "%$query%");
        })->paginate(5)->withQueryString();
    
        return view("orders.dashboard", ["orders" => $orders]);
    }
}
