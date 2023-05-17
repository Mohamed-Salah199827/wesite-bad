<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResoucre;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiBadalyController extends Controller
{

    public function index()
    {
        $posts = Post::select('id', 'title', 'image', 'video', 'desc', 'location', 'condition', 'user_id')
            ->orderBy('id', 'DESC')->get();
        return PostResoucre::collection($posts);
    }

    public function show(Post $post)
    {
        if ($post->approved_at == 'true') {
            return new PostResoucre($post);
        } else {
            return 'false';
        }
    }

    public function approve(Post $post)
    {
        $data['approved_at'] = 'true';
        $post->update($data);
        return response()->json([
            'success' => 'Approved',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'image' => 'required|image|mimes:png,jpg,jpeg,jfif|max:3024',
            'video' => 'nullable|max:102400',
            'desc' => 'required|string',
            'location' => 'required|string',
            'condition' => 'required|string',
            'category_id' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);
        $fileImg = storage::putFile("public/posts/img", $data['image']);
        $requestVideo = $data['video'] ?? null;
        if ($requestVideo == null) {
            $fileVideo = null;
        } else {
            $fileVideo = storage::putFile("public/posts/video", $requestVideo);
        }
        $data['image'] = $fileImg;
        $data['video'] = $fileVideo;
        Post::create($data);
        return response()->json([
            'success' => 'Post Created',
        ]);

    }

    public function update(Post $post, Request $request)
    {
        $data = $request->validate([
            'title' => 'string|max:100',
            'image' => 'nullable|max:3024',
            'video' => 'nullable|max:102400',
            'desc' => 'string',
            'location' => 'required|string',
            'condition' => 'required|string',
            'category_id' => 'required|string',
        ]);
        if ($request->hasFile('image')) {
            Storage::delete($post->image);
            $fileImg = storage::putFile("public/posts/img", $data['image']);
            $data['image'] = $fileImg;
        }
        if ($request->hasFile('video')) {
            if ($post->vedio) {
                Storage::delete($post->video);
                $fileVideo = storage::putFile("public/posts/video", $data['video']);
                $data['video'] = $fileVideo;
            } else {
                $fileVideo = storage::putFile("public/posts/video", $data['video']);
                $data['video'] = $fileVideo;
            }
        }
        $post->update($data);
        return response()->json([
            'success' => 'Post Updated',
        ]);
    }

    public function destroy(post $post)
    {
        Storage::delete($post->image);
        $post->delete();
        return response()->json([
            'success' => 'Post Deleted',
        ]);
    }
}
