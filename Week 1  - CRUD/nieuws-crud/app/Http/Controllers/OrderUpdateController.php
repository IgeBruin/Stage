<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;

class OrderUpdateController extends Controller
{
    public function dashboard()
    {
        $orders = Order::orderby('created_at', 'desc')->paginate(5);
        return view("orders.dashboard", compact('orders'));
    }

    public function edit(Order $order)
    {
        // Load the order and its associated order items
        $order = Order::with('items')->find($order->id);
    
        return view('orders.edit', compact('order'));
    }
    
    public function update(Request $request, Order $order)
    {
        // Validate the request data as needed
    
        // Update the order
        $order->update([
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
        ]);
    
        // Update or delete order items
        $orderItemData = $request->input('order_items');
    
        foreach ($orderItemData as $itemId => $itemAttributes) {
            $orderItem = OrderItem::find($itemId);
    
            if (!$orderItem) {
                // Handle the case where the item no longer exists or an invalid ID is provided
                continue;
            }
    
            // Check if the item should be removed
            if (isset($itemAttributes['_remove']) && $itemAttributes['_remove'] === '1') {
                $orderItem->delete();
            } else {
                $orderItem->update([
                    'quantity' => $itemAttributes['quantity'],
                ]);
            }
        }
    
        // You might also want to delete order items that are not in the updated list
    
        return redirect()->route('dashboard.orders.dashboard')->with('success', 'Bestelling aangepast');
    }

    public function deleteOrderItem(Order $order, OrderItem $orderItem)
    {
    // You can add validation or additional checks here
        $orderItem->delete();

        return redirect()->route('dashboard.orders.edit', $order)->with('success', 'OrderItem verwijderd');
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
