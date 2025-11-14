<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Http\Requests\StorePodcastRequest;
use App\Http\Requests\UpdatePodcastRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class PodcastController extends Controller
{
    public function index()
    {
        $podcasts = Podcast::with(['host.user', 'category'])->get();
        return response()->json($podcasts);
    }

    public function show($id)
    {
        $podcast = Podcast::with(['host.user', 'category', 'episodes'])->find($id);
        
        if (!$podcast) {
            return response()->json([
                'message' => 'Podcast not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($podcast);
    }

     public function store(StorePodcastRequest $request)
    {
        $podcast = Podcast::create($request->validated());
        return response()->json($podcast, Response::HTTP_CREATED);
    }

     public function update(UpdatePodcastRequest $request, $id)
    {
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return response()->json([
                'message' => 'Podcast not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $podcast->update($request->validated());
        return response()->json($podcast);
    }

    public function destroy($id)
    {
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return response()->json([
                'message' => 'Podcast not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $podcast->delete();
        return response()->json([
            'message' => 'Podcast deleted successfully'
        ]);
    }
}
