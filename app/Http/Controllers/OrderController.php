<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import the QR code facade

class OrderController extends Controller
{
    /**
     * Display the specified order with a QR code.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the order by its ID or fail if it doesn't exist
        $order = Order::findOrFail($id);

        // Generate a QR code for the order
        $qrCode = QrCode::size(200)->generate(route('order.show', $order->id));

        // Return the view with the order and QR code
        return view('order.show', compact('order', 'qrCode'));
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the view for creating a new order
        return view('order.create');
    }

    /**
     * Store a newly created order in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'total' => 'required|numeric',
            // Add other fields and validation rules as necessary
        ]);

        // Create a new order using the validated data
        $order = Order::create($request->all());

        // Redirect to the order show page with a success message
        return redirect()->route('order.show', $order->id)
                         ->with('success', 'Order created successfully.');
    }
}
