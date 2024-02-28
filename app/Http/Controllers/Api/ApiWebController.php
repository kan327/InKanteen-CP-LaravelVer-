<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class ApiWebController extends Controller
{
    public function getAllStories()
    {
        $stories = Story::orderBy('updated_at', 'desc')->get()->map(function ($story) {
            $story->featured_image = 'http://127.0.0.1:8000/' . $story->featured_image;
            return $story;
        });
    
        return response()->json(['stories' => $stories]);
    }

    public function getStory(string $id)
    {
        $story = Story::findOrFail($id);
        return response()->json(['story' => $story]);
    }

    public function getAllPosts()
    {
        $stories = Story::orderBy('updated_at', 'desc')->get();
        return response()->json(['stories' => $stories]);
    }

    public function getPost(string $id)
    {
        $story = Story::findOrFail($id);
        return response()->json(['story' => $story]);
    }
}
