@extends('layouts.admin')

@section('title', 'Add Menu Item')

@section('content')
<div class="bg-white p-6 rounded shadow-lg">
    <h2 class="text-xl font-bold mb-4">Add New Menu Item</h2>

    <!-- Display validation errors, if any -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menu-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" class="border rounded w-full py-2 px-3">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Item Name</label>
            <input type="text" name="name" id="name" class="border rounded w-full py-2 px-3" value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
            <input type="number" name="price" id="price" step="0.01" class="border rounded w-full py-2 px-3" value="{{ old('price') }}">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold mb-2">Image</label>
            <input type="file" name="image" id="image" class="border rounded w-full py-2 px-3">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Item</button>
            <a href="{{ route('menu-items.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded text-center">Cancel</a>
        </div>
    </form>
</div>
@endsection
