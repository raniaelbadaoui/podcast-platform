<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Http\Requests\StoreHostRequest;
use App\Http\Requests\UpdateHostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HostController extends Controller
{
    public function index()
    {
        $hosts = Host::with('user')->get();
        return response()->json($hosts);
    }

    public function show($id)
    {
        $host = Host::with(['user', 'podcasts'])->find($id);
        
        if (!$host) {
            return response()->json([
                'message' => 'Host not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($host);
    }

    public function store(StoreHostRequest $request)
    {
        $host = Host::create($request->validated());
        return response()->json($host, Response::HTTP_CREATED);
    }

    public function update(UpdateHostRequest $request, $id)
    {
        $host = Host::find($id);

        if (!$host) {
            return response()->json([
                'message' => 'Host not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $host->update($request->validated());
        return response()->json($host);
    }

    public function destroy($id)
    {
        $host = Host::find($id);

        if (!$host) {
            return response()->json([
                'message' => 'Host not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $host->delete();
        return response()->json([
            'message' => 'Host deleted successfully'
        ]);
    }
}