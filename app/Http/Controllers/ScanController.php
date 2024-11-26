<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScanRequest;
use App\Models\Produce;
use App\Models\ScanResult;
use App\Util\Discord;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class ScanController extends Controller
{
    public function scanFreshness(ScanRequest $request): JsonResponse
    {
        $imageFile = $request->file('image');

        // mengirim gambar ke model Machine Learning
        $response = $this->sendImageToMl($imageFile);
        // validasi error
        $this->validateServerError($response);
        $this->validateClientError($response);
        $response = $response->json();

        // Menyimpan hasil ke database
        $produce = Produce::select(['id', 'name'])
            ->where('name', $response['prediction'])
            ->first();
        $scanResult = ScanResult::create([
            'user_id' => $request->user()->id,
            'produce_id' => $produce->id,
            'freshness_score' => $response['confidence']
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil scan tingkat kesegaran buah',
            'data' => [
                'scan_result' => [
                    'id' => $scanResult->id,
                    'freshness_score' => $scanResult->freshness_score,
                    'produce' => $produce->name,
                    'scanned_at' => $scanResult->created_at
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

    private function sendImageToMl($imageFile): Response
    {
        try {
            $response = Http::attach(
                'file',
                $imageFile->getContent(),
                $imageFile->getFilename()
            )->post(config('freshguard.model.baseurl') . '/predict');
            return $response;
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Server error'
            ], 500));
        }
    }

    private function validateServerError(Response $response)
    {
        if ($response->serverError()) {
            Discord::logResponse($response, 'Mechine Learning nya error weh');
            throw new HttpResponseException(response()->json([
                'status' => 'fail',
                'message' => 'Error saat proses scanning gambar.'
            ], 500));
        }
    }

    private function validateClientError(Response $response)
    {
        if ($response->clientError()) {
            Discord::logResponse($response, 'Salah di Backend');
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
}
