<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResoucre;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    public function allCategory()
    {
        $categories = Category::all();
        return response()->json([
            'Category' => $categories,
        ]);
    }
    public function show(Category $category)
    {
        $posts=Post::where('category_id',$category->id)->get();
        return PostResoucre::collection($posts);

    }
}
