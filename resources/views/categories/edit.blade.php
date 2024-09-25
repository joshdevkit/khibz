@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white p-6 rounded shadow-lg mb-6">
    <h2 class="text-xl font-bold mb-4">Edit Category</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Category Name:</label>
            <input type="text" name="name" id="name" class="border border-gray-300 p-2 w-full" value="{{ $category->name }}" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Category</button>
    </form>
</div>
@endsection
