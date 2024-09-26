<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'table_id' => 'required|string',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Create the order in the database
        $order = Order::create([
            'table_id' => $validatedData['table_id'],
            'total_price' => collect($validatedData['items'])->sum(function($item) {
                return $item['price'] * $item['quantity'];
            })
        ]);

        // Save each order item
        foreach ($validatedData['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Order placed successfully.']);
    }

    public function index()
    {
        $orders = Order::with('items')->get();
        $orders = Order::orderByRaw("FIELD(status, 'Pending', 'Cancelled', 'Completed')")->get();

        
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        $order->load('items'); // Load related order items
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        try {
            // Delete related order items
            $order->items()->delete();
    
            // Delete the order
            $order->delete();
    
            // Return a success response in JSON
            return response()->json(['success' => true, 'message' => 'Order deleted successfully.']);
        } catch (\Exception $e) {
            // Catch any errors and return a failure response
            return response()->json(['success' => false, 'message' => 'Failed to delete order.']);
        }
    }
    
    
    public function updateStatus(Request $request, $orderId)
    {
        // Validate that the status is either Pending, Completed, or Cancelled
        $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled',
        ]);
    
        // Find the order by ID and update the status
        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();
    
        return response()->json(['success' => true]);
    }
    

}