@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="bg-white p-6 rounded shadow-lg mb-6">
    <div class="flex items-center justify-between mb-4">
        <!-- Back button to navigate to the admin dashboard or previous page -->
        <a href="{{ route('admin.menu') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
        
        <!-- Add button for new categories -->
        <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Category</a>
    </div>

    <!-- Display the categories -->
    @if($categories->isEmpty())
        <p>No categories available. Please add some.</p>
    @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="border px-4 py-2">{{ $category->id }}</td>
                        <td class="border px-4 py-2">{{ $category->name }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
