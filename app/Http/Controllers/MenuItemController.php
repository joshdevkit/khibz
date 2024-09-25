<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category; // Import the Category model
use Illuminate\Support\Facades\Storage;


class MenuItemController extends Controller
{
    /**
     * Display the manage menu view with categories and their menu items.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all categories with their associated menu items
        $categories = Category::with('menuItems')->get();

        // Pass the categories to the 'manage-menu' view
        return view('admin.manage-menu', compact('categories'));
    }

    /**
     * Show the form for creating a new menu item.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('menu-items.create', compact('categories'));
    }

    /**
     * Store a newly created menu item in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
        ]);
    
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store the image in the public disk
        }
    
        MenuItem::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
        ]);
    
        return redirect()->route('menu-items.index')->with('success', 'Menu item added successfully.');
    }
    
    
    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image
        ]);
    
        $data = $request->all();
    
        // Handle the image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
    
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $data['image'] = $imagePath;
        }
    
        $menuItem->update($data);
    
        return redirect()->route('menu-items.index')->with('success', 'Menu item updated successfully.');
    }
    
    
    public function edit(MenuItem $menuItem)
    {
        // Fetch all categories for the dropdown
        $categories = Category::all();

        // Return the edit view with the menu item and categories
        return view('menu-items.edit', compact('menuItem', 'categories'));
    }


    /**
     * Remove the specified menu item from the database.
     *
     * @param  MenuItem  $menuItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted successfully.');
    }
}
