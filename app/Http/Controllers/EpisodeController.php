<?php

namespace App\Http\Controllers;
/**
 * @OA\Tag(name="Episodes")
 */
use App\Models\Episode;
use App\Models\Podcast;
use App\Http\Requests\StoreEpisodeRequest;
use App\Http\Requests\UpdateEpisodeRequest;
use App\Http\Requests\UploadEpisodeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EpisodeController extends Controller
{
    public function index($podcast_id)
    {
        $episodes = Episode::where('podcast_id', $podcast_id)->get();
        return response()->json($episodes);
    }

    public function show($id)
    {
        $episode = Episode::with('podcast')->find($id);
        
        if (!$episode) {
            return response()->json([
                'message' => 'Episode not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($episode);
    }

    public function store(StoreEpisodeRequest $request, $podcast_id)
    {
        $data = $request->validated();
        $data['podcast_id'] = $podcast_id;
        
        $episode = Episode::create($data);
        return response()->json($episode, Response::HTTP_CREATED);
    }

    public function storeWithFile(UploadEpisodeRequest $request, $podcast_id)
    {
        $data = $request->validated();
        $data['podcast_id'] = $podcast_id;

        if ($request->hasFile('audio_file')) {
            $path = $request->file('audio_file')->store('episodes/audio', 'public');
            $data['audio_file'] = $path;
        }

        $episode = Episode::create($data);
        return response()->json($episode, Response::HTTP_CREATED);
    }

    public function update(UpdateEpisodeRequest $request, $id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json([
                'message' => 'Episode not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $episode->update($request->validated());
        return response()->json($episode);
    }

    public function destroy($id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json([
                'message' => 'Episode not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $episode->delete();
        return response()->json([
            'message' => 'Episode deleted successfully'
        ]);
    }
}