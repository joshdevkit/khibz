<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Import the Reservation model
use App\Models\MenuItem; // Import the MenuItem model

class MenuController extends Controller
{
    /**
     * Show the menu based on the table ID from the QR code.
     *
     * @param  string  $tableId
     * @return \Illuminate\View\View
     */
    public function show($tableId)
    {
        // Store the table ID in the session
        session(['current_table_id' => $tableId]);
    
        // Fetch the menu items for the specific table ID from the database
        $menuItems = MenuItem::with('category') // Load the category relationship
            ->get()
            ->groupBy(function ($item) {
                return $item->category ? $item->category->name : 'Uncategorized'; // Use 'Uncategorized' for items without a category
            });
    
        // Return the view with the menu data
        return view('menu', compact('menuItems', 'tableId'));
    }
    
    

    /**
     * Check the table status before allowing access to the menu.
     *
     * @param  string  $tableId
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkTableStatus($tableId)
    {
        // Query the database for the table's reservation status
        $reservation = Reservation::where('table_number', $tableId)->where('status', 'Completed')->first();

        // Check if the table exists and is marked as 'Completed'
        if ($reservation) {
            // Fetch the menu items from the database and group by category
            $menuItems = MenuItem::with('category')
                ->get()
                ->groupBy(function ($item) {
                    return $item->category ? $item->category->name : 'Uncategorized';
                })
                ->map(function ($items) {
                    return $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'price' => $item->price,
                            'image' => $item->image ? asset('storage/' . $item->image) : null, // Full path for images
                        ];
                    });
                });

            return response()->json(['success' => true, 'menu' => $menuItems]);
        }

        // If the table does not exist or is not completed, return an error
        return response()->json(['success' => false]);
    }
}
