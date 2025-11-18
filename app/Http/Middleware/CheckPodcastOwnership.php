<?php

namespace App\Http\Middleware;

use App\Models\Podcast;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPodcastOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $podcastId = $request->route('id') ?? $request->route('podcast_id');
        $podcast = Podcast::find($podcastId);
        
        $user = $request->user();
        
        if (!$podcast) {
            return response()->json([
                'message' => 'Podcast not found'
            ], 404);
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($user->isHost() && $podcast->host_id === $user->host->id) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized. You can only modify your own podcasts.'
        ], 403);
    }
}