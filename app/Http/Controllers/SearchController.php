<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\Episode;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchPodcasts(Request $request)
    {
        $query = Podcast::with(['host', 'category']);

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        if ($request->has('host')) {
            $query->whereHas('host', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->host . '%');
            });
        }

        $podcasts = $query->get();
        return response()->json($podcasts);
    }

    public function searchEpisodes(Request $request)
    {
        $query = Episode::with('podcast');

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('podcast')) {
            $query->whereHas('podcast', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->podcast . '%');
            });
        }
        if ($request->has('date')) {
    $query->whereDate('created_at', $request->date);
}

        $episodes = $query->get();
        return response()->json($episodes);
    }
}