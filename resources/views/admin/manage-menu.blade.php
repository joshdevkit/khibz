@extends('layouts.admin')

@section('title', 'Manage Menu')

@section('content')
<div class="bg-white p-6 rounded shadow-lg mb-6">
    <!-- Button to view all categories -->
    <a href="{{ route('categories.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">View All Categories</a>

    <!-- Add button for new menu items -->
    <a href="{{ route('menu-items.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Menu Item</a>

    <!-- Display the menu items grouped by category -->
    @foreach ($categories as $category)
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
            @if ($category->menuItems->isEmpty())
                <p>No items available in this category. Please add some.</p>
            @else
                <table class="min-w-full bg-white border mb-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Image</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category->menuItems as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->id }}</td>
                                <td class="border px-4 py-2">{{ $item->name }}</td>
                                <td class="border px-4 py-2">{{ $item->price }}</td>
                                <td class="border px-4 py-2">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('menu-items.edit', $item->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('menu-items.destroy', $item->id) }}" method="POST" class="inline-block">
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
    @endforeach
</div>
@endsection
