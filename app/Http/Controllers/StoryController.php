<?php

namespace App\Http\Controllers;

use App\Http\Requests\Story\StoreRequest;
use App\Http\Requests\Story\UpdateRequest;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->view('story.index', [
            'stories' => Story::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('story.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
             // put image in the public storage
            $filePath = Storage::disk('public')->put('images/story/featured-images', request()->file('featured_image'));
            $validated['featured_image'] = $filePath;
        }

        // insert only requests that already validated in the StoreRequest
        $create = Story::create($validated);

        if($create) {
            // add flash for the success notification
            session()->flash('notif.success', 'Story created successfully!');
            return redirect()->route('story.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view('story.show', [
            'story' => Story::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('story.form', [
            'story' => Story::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $story = Story::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            // delete image
            Storage::disk('public')->delete($story->featured_image);

            $filePath = Storage::disk('public')->put('images/story/featured-images', request()->file('featured_image'), 'public');
            $validated['featured_image'] = $filePath;
        }

        $update = $story->update($validated);

        if($update) {
            session()->flash('notif.success', 'story updated successfully!');
            return redirect()->route('story.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $story = Story::findOrFail($id);

        Storage::disk('public')->delete($story->featured_image);
        
        $delete = $story->delete($id);

        if($delete) {
            session()->flash('notif.success', 'story deleted successfully!');
            return redirect()->route('story.index');
        }

        return abort(500);
    }
}


