<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::get('/test-host', function () {
        return response()->json(['message' => 'Host access granted!']);
    })->middleware('host');
    
    Route::get('/test-admin', function () {
        return response()->json(['message' => 'Admin access granted!']);
    })->middleware('admin');

    Route::get('/categories', [CategoryController::class, 'index']);

    Route::get('/podcasts', [PodcastController::class, 'index']);
    Route::get('/podcasts/{id}', [PodcastController::class, 'show']);
    Route::post('/podcasts', [PodcastController::class, 'store'])->middleware('host');
    Route::post('/podcasts/upload', [PodcastController::class, 'storeWithFile'])->middleware('host');
    Route::put('/podcasts/{id}', [PodcastController::class, 'update'])->middleware(['host', 'podcast.owner']);
    Route::delete('/podcasts/{id}', [PodcastController::class, 'destroy'])->middleware(['host', 'podcast.owner']);

    Route::get('/podcasts/{podcast_id}/episodes', [EpisodeController::class, 'index']);   
    Route::get('/episodes/{id}', [EpisodeController::class, 'show']);
    Route::post('/podcasts/{podcast_id}/episodes', [EpisodeController::class, 'store'])->middleware('host');
    Route::post('/podcasts/{podcast_id}/episodes/upload', [EpisodeController::class, 'storeWithFile'])->middleware('host');
    Route::put('/episodes/{id}', [EpisodeController::class, 'update'])->middleware('host');
    Route::delete('/episodes/{id}', [EpisodeController::class, 'destroy'])->middleware('host');

    Route::get('/hosts', [HostController::class, 'index']);
    Route::get('/hosts/{id}', [HostController::class, 'show']);
    Route::post('/hosts', [HostController::class, 'store'])->middleware('admin');
    Route::put('/hosts/{id}', [HostController::class, 'update'])->middleware('admin');
    Route::delete('/hosts/{id}', [HostController::class, 'destroy'])->middleware('admin');

    Route::get('/users', [UserController::class, 'index'])->middleware('admin');
    Route::post('/users', [UserController::class, 'store'])->middleware('admin');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('admin');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('admin');
});

Route::get('/search/podcasts', [SearchController::class, 'searchPodcasts']);
Route::get('/search/episodes', [SearchController::class, 'searchEpisodes']);