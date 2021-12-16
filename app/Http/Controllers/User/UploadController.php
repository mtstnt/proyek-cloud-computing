<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UploadStatus;
use Aws\S3\S3Client;
use Aws\Sns\SnsClient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class __UploadStatus {
    const UPLOADING = 0;
    const FINISHED = 1;
}
class UploadController extends Controller
{
    public function index()
    {
        return view('main.upload.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|max:255',
            'upload' => 'required|file|mimes:jpg,jpeg,png,mp4',
        ]);

        $filename = uniqid("", true);
        $uploadFile = $request->file('upload');
        $topicArn = "";

        if (in_array($uploadFile->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
            $topicArn = env("TOPIC_ARN_IMAGE_PROCESSING");
            $contentType = "image/" . $uploadFile->getClientOriginalExtension();
        }  else {
            $topicArn = env("TOPIC_ARN_VIDEO_PROCESSING");
            $contentType = "video/" . $uploadFile->getClientOriginalExtension();
        }

        $filename .= "." . $uploadFile->getClientOriginalExtension();

        DB::beginTransaction();

        try {

            $s3 = new S3Client([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key'    => env("AWS_ACCESS_KEY_ID"),
                    'secret' => env("AWS_SECRET_ACCESS_KEY"),
                    'token'  => env("AWS_SESSION_TOKEN")
                ]
            ]);

            // Store to S3
            // if (!Storage::disk('s3')->put($filename, file_get_contents($uploadFile))) {
            //     throw new Exception("Failed to upload file!");
            // }
            $result = $s3->putObject([
                'Bucket' => 'mtstnt-private',
                'Key'    => $filename,
                'Body'   => file_get_contents($uploadFile),
                'ContentType' => $contentType,
            ]);

            if (! $result->get("ObjectURL")) {
                throw new Exception("Failed to upload file!");
            }

            $post = UploadStatus::create([
                'id_user' => Auth::user()->id,
                'url' => null,
                'caption' => null,
                'status' => __UploadStatus::UPLOADING
            ]);

            $sns = new SnsClient([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key'    => env("AWS_ACCESS_KEY_ID"),
                    'secret' => env("AWS_SECRET_ACCESS_KEY"),
                    'token'  => env("AWS_SESSION_TOKEN")
                ]
            ]);

            // Send SNS notification for caption filter
            $sns->publish([
                'Message' => json_encode([
                    'Caption' => $request->caption,
                    'UploadStatusID' => $post->id,
                ]),
                'TopicArn' => env("TOPIC_ARN_CAPTION_FILTER")
            ]);

            // Send SNS notification for file
            // $sns->publish([
            //     'Message' => json_encode([
            //         'Filename' => $filename,
            //         'UploadStatusID' => $post->id,
            //     ]),
            //     'TopicArn' => $topicArn,
            // ]);

            DB::commit();
        } 
        catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('main.upload.index')->with('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->route('main.upload.index')->with('ok', "Upload is ongoing!");
    }

    public function getUploadStatus(Request $request)
    {
        $post_status = UploadStatus::query()
            ->where([
                ['id', $request->id],
                ['id_user', Auth::user()->id]
            ])
            ->first();

        return response()->json($post_status);
    }
}
