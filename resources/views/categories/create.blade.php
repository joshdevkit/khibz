@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="bg-white p-6 rounded shadow-lg mb-6">
    <h2 class="text-xl font-bold mb-4">Create Category</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Category Name:</label>
            <input type="text" name="name" id="name" class="border border-gray-300 p-2 w-full" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Category</button>
    </form>
</div>
@endsection
