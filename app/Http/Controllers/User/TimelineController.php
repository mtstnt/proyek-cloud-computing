<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\UploadStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->with('user')
            ->whereNotNull('url')
            ->whereNotNull('caption')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($posts as $p) {
            $p->date = Carbon::createFromTimestamp($p->date)->format('d M Y');
        }

        return response()->json($posts);
    }

    public function getUploadedStatus() {
        $uploading = UploadStatus::query()
            ->where('id_user', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $uploading) {
            return response()->json(null);
        }

        return response()->json($uploading);
    }
}
