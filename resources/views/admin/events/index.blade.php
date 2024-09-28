@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.events.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            <i class="fas fa-plus mr-2"></i> Add Event
        </a>
    </div>

    <!-- Table for Events -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left font-semibold text-gray-700">Title</th>
                    <th class="py-3 px-6 text-left font-semibold text-gray-700">DJ</th>
                    <th class="py-3 px-6 text-left font-semibold text-gray-700">Event Date</th>
                    <th class="py-3 px-6 text-left font-semibold text-gray-700">Image</th>
                    <th class="py-3 px-6 text-left font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr class="border-b">
                        <td class="py-4 px-6">{{ $event->title }}</td>
                        <td class="py-4 px-6">{{ $event->dj_name }}</td>
                        <td class="py-4 px-6">{{ $event->event_date->format('F j, Y') }}</td>
                        <td class="py-4 px-6">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 flex space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <!-- Delete Form Button -->
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
