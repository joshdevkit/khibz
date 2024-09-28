@extends('layouts.admin')

@section('title', 'Add Event')

@section('content')
<div class="bg-white p-6 rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Add Event</h2>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="border border-gray-300 p-2 w-full" value="{{ old('title') }}">
            @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="dj_name" class="block text-gray-700">DJ Name</label>
            <input type="text" name="dj_name" id="dj_name" class="border border-gray-300 p-2 w-full" value="{{ old('dj_name') }}">
            @error('dj_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="event_date" class="block text-gray-700">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="border border-gray-300 p-2 w-full" value="{{ old('event_date') }}">
            @error('event_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" class="border border-gray-300 p-2 w-full" rows="5">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700">Event Image</label>
            <input type="file" name="image" id="image" class="border border-gray-300 p-2 w-full">
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Button Group with Add and Cancel -->
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Event</button>
            
            <!-- Cancel Button -->
            <a href="{{ route('admin.events') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript to Restrict Past Dates -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventDateInput = document.getElementById('event_date');
        const today = new Date().toISOString().split('T')[0];
        eventDateInput.setAttribute('min', today);
    });
</script>
@endsection
