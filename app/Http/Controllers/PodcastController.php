<?php

namespace App\Http\Controllers;
/**
 * @OA\Tag(name="Podcasts") 
 */
use App\Models\Podcast;
use App\Http\Requests\StorePodcastRequest;
use App\Http\Requests\UpdatePodcastRequest;
use App\Http\Requests\UploadPodcastRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
        $host = $request->user()->host;
        
        if (!$host) {
            return response()->json([
                'message' => 'User is not a host'
            ], Response::HTTP_FORBIDDEN);
        }

        $data = $request->validated();
        $data['host_id'] = $host->id;
        $data['slug'] = Str::slug($data['title']);
        
        $podcast = Podcast::create($data);
        return response()->json($podcast, Response::HTTP_CREATED);
    }

    public function storeWithFile(UploadPodcastRequest $request)
    {
        $host = $request->user()->host;
        
        if (!$host) {
            return response()->json([
                'message' => 'User is not a host'
            ], Response::HTTP_FORBIDDEN);
        }

        $data = $request->validated();
        $data['host_id'] = $host->id;
        $data['slug'] = Str::slug($data['title']);

        // تحميل cover image إذا وجد
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('podcasts/covers', 'public');
            $data['cover_image'] = $path;
        }

        $podcast = Podcast::create($data);
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