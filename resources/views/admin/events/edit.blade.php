@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Edit Event</h2>

    <!-- Show validation errors if any -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Event Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required>
        </div>

        <div class="mb-4">
            <label for="dj_name" class="block text-gray-700 font-medium mb-2">DJ Name</label>
            <input type="text" name="dj_name" id="dj_name" class="form-control" value="{{ old('dj_name', $event->dj_name) }}" required>
        </div>

        <div class="mb-4">
            <label for="event_date" class="block text-gray-700 font-medium mb-2">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-medium mb-2">Event Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="mt-3" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
@endsection
