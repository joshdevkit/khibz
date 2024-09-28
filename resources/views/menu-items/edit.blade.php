@extends('layouts.admin')

@section('title', 'Edit Menu Item')

@section('content')
<div class="bg-white p-6 rounded shadow-lg mb-6">
    <h2 class="text-xl font-bold mb-4">Edit Menu Item</h2>

    <form action="{{ route('menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Category Selection -->
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700">Category:</label>
            <select name="category_id" id="category_id" class="w-full border-gray-300 rounded p-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Item Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Item Name:</label>
            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded p-2" value="{{ $menuItem->name }}" required>
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="block text-gray-700">Price:</label>
            <input type="number" name="price" id="price" class="w-full border-gray-300 rounded p-2" step="0.01" value="{{ $menuItem->price }}" required>
        </div>

        <!-- Image Upload -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Image:</label>
            <input type="file" name="image" id="image" class="w-full border-gray-300 rounded p-2">
            @if ($menuItem->image)
                <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="w-32 h-32 mt-2 object-cover rounded-md">
            @endif
        </div>

        <!-- Action Buttons (Update and Cancel) -->
        <div class="flex justify-between items-center mt-8">
            <!-- Update Button on the Left -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                Update Menu Item
            </button>

            <!-- Cancel Button on the Right -->
            <a href="{{ route('menu-items.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
