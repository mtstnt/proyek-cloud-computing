<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\UploadStatus;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        return view('main.timeline.index');
    }

    public function view($post_id)
    {
        $post = Post::query()
            ->where('post_id', $post_id)
            ->firstOrFail();

        return view('main.post.view', compact('post'));
    }

    public function getPosts()
    {
        $posts = UploadStatus::query()
            ->whereNotNull('url')
            ->whereNotNull('caption')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }
}
