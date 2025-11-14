<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('podcasts')->get();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::with('podcasts')->find($id);
        
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($category);
    }
}


