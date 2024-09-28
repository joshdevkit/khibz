@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg mb-10">
    <!-- Header: Add Event Button -->
    <div class="flex justify-between items-center mb-8">
        <!-- Add Event Button -->
        <a href="{{ route('admin.events.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-6 py-3 rounded-lg shadow-md font-semibold flex items-center space-x-2 transition ease-in-out duration-300 hover:from-blue-600 hover:to-indigo-600 hover:shadow-lg">
            <i class="fas fa-plus"></i>
            <span>Add Event</span>
        </a>
    </div>

    <!-- Events Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Title</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">DJ</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Event Date</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Image</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($events as $event)
                    <tr class="hover:bg-gray-50 transition ease-in-out duration-150">
                        <td class="py-4 px-6 text-sm text-gray-900">{{ $event->title }}</td>
                        <td class="py-4 px-6 text-sm text-gray-900">{{ $event->dj_name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-900">{{ $event->event_date->format('F j, Y') }}</td>
                        <td class="py-4 px-6">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 flex space-x-4">
                            <!-- Edit Button (Blue) -->
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg shadow-md font-semibold flex items-center space-x-1 transition ease-in-out duration-300 hover:from-blue-600 hover:to-blue-700">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>

                            <!-- Delete Button (Red) with SweetAlert2 confirmation -->
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg shadow-md font-semibold flex items-center space-x-1 transition ease-in-out duration-300 hover:from-red-600 hover:to-red-700 delete-btn">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
                    text: "You won't be able to revert this!",
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
