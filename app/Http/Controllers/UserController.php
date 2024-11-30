<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = Auth::user();
        return (new  UserResource($user))
            ->additional([
                'status' => 'success',
                'message' => 'Sukses mengambil data user',
            ]);
    }

    public function getPfp(Request $request)
    {
        $user = $request->user();
        $pfpPath = $user->profile_picture_path;
        $pfpName = $user->profile_picture_name;
        if ($request->hasHeader('Content-Disposition')) {
            $disposition = explode(';', $request->header('Content-Disposition'), 1)[0];
        } else {
            $disposition = 'inline';
        }

        
        $this->validateFileExists($pfpPath);
        $bytes = Storage::disk('gcs')->get($pfpPath);

        // get file MIME TYPE
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $contentType = finfo_buffer($finfo, $bytes);

        return response($bytes)
            ->setStatusCode(200)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', [$disposition, "filename=$pfpName"]);
    }

    private function validateFileExists($path)
    {
        if (Storage::disk('gcs')->exists($path)) {
            abort(response()->json([
                'status' => 'fail',
                'message' => __('storage.file.notfound', ['storage' => 'Cloud Storage'])
            ])->setStatusCode(404));
        }
    }
}
