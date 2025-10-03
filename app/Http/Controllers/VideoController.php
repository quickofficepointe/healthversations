<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('healthversations.admin.videos.index', compact('videos'));
    }
    public function showVideos()
{
    $videos = Video::all();
    return view('frontendviews.videos.index', compact('videos'));
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'link' => 'required|url',
    ]);

    // Create and save the video in the database
    Video::create([
        'title' => $request->title,
        'link' => $request->link,
    ]);

    return redirect()->route('videos.index')->with('success', 'Video link saved successfully!');
}



    public function edit($id)
    {
        $editVideo = Video::findOrFail($id);
        $videos = Video::all();
        return view('healthversations.admin.videos.index', compact('editVideo', 'videos'));
    }

   public function update(Request $request, Video $video)
{
    $video->title = $request->title;
    $video->link = $request->link;
    $video->save();

    return redirect()->route('videos.index')->with('success', 'Video updated successfully');
}


    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video link deleted successfully!');
    }
}
