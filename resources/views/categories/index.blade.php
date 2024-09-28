@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex items-center justify-between mb-6">
        <!-- Back button to navigate to the admin dashboard or previous page -->
        <a href="{{ route('admin.menu') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition ease-in-out duration-300">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
        
        <!-- Add button for new categories -->
        <a href="{{ route('categories.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-md font-semibold transition ease-in-out duration-300 hover:from-blue-600 hover:to-blue-700">
            <i class="fas fa-plus mr-1"></i> Add New Category
        </a>
    </div>

    <!-- Display the categories -->
    @if($categories->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-lg">
            <p>No categories available. Please add some.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50 transition ease-in-out duration-200">
                            <td class="border px-6 py-4">{{ $category->id }}</td>
                            <td class="border px-6 py-4">{{ $category->name }}</td>
                            <td class="border px-6 py-4 flex space-x-3">
                                <!-- Edit Button -->
                                <a href="{{ route('categories.edit', $category->id) }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2 rounded-lg shadow-md transition ease-in-out duration-300 hover:from-blue-600 hover:to-blue-700">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Form with SweetAlert2 confirmation -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-2 rounded-lg shadow-md transition ease-in-out duration-300 hover:from-red-600 hover:to-red-700 delete-btn">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "you want to delete this category?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if confirmed
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
