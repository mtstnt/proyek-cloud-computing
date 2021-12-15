<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostStatus;
use Aws\AwsClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index() {
        return view('main.upload.index');
    }

    public function store(Request $request) {
        $request->validate([
            'caption' => 'required|max:255',
            'upload' => 'required|file|mimes:jpg,jpeg,png,mp4',
        ]);
        
        $filename = uniqid("raw_", true);

        
        DB::transaction(function() use($filename, $request) {
            $aws = new AwsClient([
                'aws_session_id' => env('AWS_SESSION_ID'),
                'aws_secret_session_key' => env('AWS_SECRET_SESSION_KEY'),
            ]);

            // Store to S3
            if (! Storage::disk('s3')->put($filename, file_get_contents($request->file('upload')))) {
                return redirect()->route('main.upload.index')->with('error', 'Failed to upload file!');
            }
            
            // Send SNS notification
        });


        return redirect()->route('main.upload.index');
    }

    public function getUploadStatus(Request $request) {
        $post_status = PostStatus::query()
            ->where([
                ['id', $request->id],
                ['id_user', Auth::user()->id]
            ])
            ->first();

        return response()->json($post_status);
    }
}
