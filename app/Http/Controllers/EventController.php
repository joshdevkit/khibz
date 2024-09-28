<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::all(); // Fetch all events from the database
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'dj_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('events', 'public');

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'dj_name' => $request->dj_name,
            'event_date' => $request->event_date,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.events')->with('success', 'Event created successfully');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id); // Find the event by ID
        return view('admin.events.edit', compact('event'));
    }

    // Update function to handle the form submission
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'dj_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $event = Event::findOrFail($id);

        // Update the event with new data
        $event->update([
            'title' => $request->input('title'),
            'dj_name' => $request->input('dj_name'),
            'event_date' => $request->input('event_date'),
            'description' => $request->input('description'),
        ]);

        // Handle the image upload if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($event->image) {
                Storage::delete('public/' . $event->image);
            }

            // Store the new image
            $path = $request->file('image')->store('events', 'public');
            $event->update(['image' => $path]);
        }

        return redirect()->route('admin.events')->with('success', 'Event updated successfully.');
    }
}


