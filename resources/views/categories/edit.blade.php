@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white p-6 rounded shadow-lg mb-6">
    <h2 class="text-xl font-bold mb-4">Edit Category</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Category Name Input Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Category Name:</label>
            <input type="text" name="name" id="name" class="border border-gray-300 p-2 w-full rounded" value="{{ $category->name }}" required>
        </div>

        <!-- Action Buttons (Update and Cancel) -->
        <div class="flex justify-between items-center mt-8">
            <!-- Update Button on the Left -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                Update Category
            </button>

            <!-- Cancel Button on the Right -->
            <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
