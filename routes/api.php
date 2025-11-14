<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/test-host', function () {
        return response()->json(['message' => 'Host access granted!']);
    })->middleware('host');
    
    Route::get('/test-admin', function () {
        return response()->json(['message' => 'Admin access granted!']);
    })->middleware('admin');

    // Podcast Routes
    Route::get('/podcasts', [PodcastController::class, 'index']);
    Route::get('/podcasts/{id}', [PodcastController::class, 'show']);
    Route::post('/podcasts', [PodcastController::class, 'store'])->middleware('host');
    Route::put('/podcasts/{id}', [PodcastController::class, 'update'])->middleware('host');
    Route::delete('/podcasts/{id}', [PodcastController::class, 'destroy'])->middleware('host');

    // Episode Routes
    Route::get('/podcasts/{podcast_id}/episodes', [EpisodeController::class, 'index']);
    Route::get('/episodes/{id}', [EpisodeController::class, 'show']);
    Route::post('/podcasts/{podcast_id}/episodes', [EpisodeController::class, 'store'])->middleware('host');
    Route::put('/episodes/{id}', [EpisodeController::class, 'update'])->middleware('host');
    Route::delete('/episodes/{id}', [EpisodeController::class, 'destroy'])->middleware('host');

    // Host Routes
    Route::get('/hosts', [HostController::class, 'index']);
    Route::get('/hosts/{id}', [HostController::class, 'show']);
    Route::post('/hosts', [HostController::class, 'store'])->middleware('admin');
    Route::put('/hosts/{id}', [HostController::class, 'update'])->middleware('admin');
    Route::delete('/hosts/{id}', [HostController::class, 'destroy'])->middleware('admin');

    // Admin Users Management
    Route::get('/users', [UserController::class, 'index'])->middleware('admin');
    Route::post('/users', [UserController::class, 'store'])->middleware('admin');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('admin');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('admin');
});

// Search Routes (Public)
Route::get('/search/podcasts', [SearchController::class, 'searchPodcasts']);
Route::get('/search/episodes', [SearchController::class, 'searchEpisodes']);