<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScanRequest;
use App\Models\Produce;
use App\Models\ScanResult;
use App\Util\Discord;
use Exception;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ScanController extends Controller
{
    public function scanFreshness(ScanRequest $request): JsonResponse
    {
        $imageFile = $request->file('image');
        $texture = $request->input('texture');
        $smell = $request->string('smell');
        $verifiedStore = $request->boolean('verified_store', false);

        // validate input
        $smell = in_array($smell, ['fresh', 'neutral', 'rotten']) ? $smell : null;
        $texture = in_array($texture, ['hard', 'normal', 'soft']) ? $texture : null;

        // mengirim gambar ke model Machine Learning
        $response = $this->sendImageToMl($imageFile, $smell, $texture, $verifiedStore);
        // validasi error
        $this->validateServerError($response);
        $this->validateClientError($response);
        $this->logMlToDiscord($response);
        $response = $response->json();
        [$produceCondition, $produceName] = mb_split(' ', $response['prediction']) ?: [null, null];
        $freshnessScore = $response['confidence'];

        // Mendapatkan data komudutas dari database
        $produce = Produce::select(['id', 'name'])
            ->where('name', $produceName)
            ->first();

        // menyimpan komuditas baru jika belum ada di database
        if (is_null($produce)) {
            $produce = Produce::create([
                'name' => $produceName
            ]);
        }

        // Menyimpan hasil scan ke database
        /** @var ScanResult */
        $scanResult = ScanResult::create([
            'user_id' => $request->user()->id,
            'produce_id' => $produce->id,
            'freshness_score' => $freshnessScore,
            'smell' => $smell,
            'texture' => $texture,
            'verified_store' => $verifiedStore ?: false
        ]);


        $imageExtention = $imageFile->extension();
        $storageClient = new StorageClient();
        $bucket = $storageClient->bucket('freshguard-bucket');
        $bucket->upload(fopen($imageFile->path(), 'r'), [
            'name' => 'scan-images/' . uuid_create() .  ($imageExtention ? ".$imageExtention": "")
        ]);

        $scanResult->created_at->setTimezone(7);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil scan tingkat kesegaran buah',
            'data' => [
                'scan_result' => [
                    'id' => $scanResult->id,
                    'freshness_score' => $scanResult->freshness_score,
                    'produce' => $produce->name,
                    'scanned_at' => $scanResult->created_at->format('d-m-Y h:i:s')
                ]
            ]
        ], 200);
    }

    public function trackScan($scanResultId, Request $request)
    {
        $scanResult = ScanResult::where('user_id', $request->user()->id)
            ->find($scanResultId);
        $this->validateNotNull(data: $scanResult, message: "ID scan tidak ditemukan.", status: 404);
        $scanResult->is_tracked = true;
        $scanResult->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sukses track hasil scan.'
        ], 200);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $imageFile
     */
    private function sendImageToMl($imageFile, $smell, $texture, $verifiedStore): Response
    {
        try {
            $response = Http::asMultipart()->post(config('freshguard.model.baseurl') . '/predict', [
                [
                    'name' => 'validation',
                    'contents' => json_encode([
                        'smell' => $smell,
                        'texture' => $texture,
                        'verifiedShop' => $verifiedStore
                    ])
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($imageFile->getPathname(), 'r'),
                    'filename' => $imageFile->getClientOriginalName(),
                ],
            ]);
            return $response;
        } catch (Exception $e) {
            Discord::send($e->getMessage());
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Server error'
            ], 500));
        }
    }

    private function validateServerError(Response $response)
    {
        if ($response->serverError()) {
            $this->logMlToDiscord($response);
            throw new HttpResponseException(response()->json([
                'status' => 'fail',
                'message' => 'Error saat proses scanning gambar.'
            ], 500));
        }
    }

    /**
     * @param Response $response
     */
    private function validateClientError(Response $response)
    {
        if(!blank($response->json('error'))){
            abort(response()->json([
                'status' => 'fail',
                'message' => $response->json('error')
            ], 400));
        };
        if ($response->clientError()) {
            $this->logMlToDiscord($response);
            throw new HttpResponseException(response()->json([
                'status' => 'fail',
                'message' => 'Gagal scanning gambar.'
            ], 500));
        }
    }

    private function validateNotNull($data, $message, $status)
    {
        if (is_null($data)) {
            throw new HttpResponseException(response()->json([
                'status' => 'fail',
                'message' => $message
            ], $status));
        }
    }

    /**
     * @param Response $response
     */
    private function logMlToDiscord($response){
        $status = $response->status();
        $responseJson = json_encode($response->json(), JSON_PRETTY_PRINT);
        $user = auth()->user();
        $now = Date::now('Asia/Jakarta')->format('d-m-Y h:i:s');
        Discord::send(<<<CONTENT
        Name: $user->name
        Username: $user->username
        Time: $now
        Status: $status
        ======= result =======
        $responseJson
        ======================

        CONTENT);
    }
}
