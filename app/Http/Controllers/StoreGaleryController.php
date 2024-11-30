<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreGaleryCollection;
use App\Models\Store;
use App\Models\StoreGalery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StoreGaleryController extends Controller
{
    public function getStoreImage($storeId, $storeGaleryId, Request $request)
    {
        if ($request->hasHeader('Content-Disposition')) {
            $disposition = explode(';', $request->header('Content-Disposition'), 1)[0];
        } else {
            $disposition = 'inline';
        }

        $galery = StoreGalery::select(['store_galeries.name', 'store_galeries.path'])
            ->join('stores', 'store_galeries.store_id', '=', 'stores.id')
            ->where('store_id', )
            ->first();

        $this->validateGaleryFound($galery);
        $this->validateFileExists($galery->path);

        $bytes = Storage::disk('gcs')->get($galery->path);

        // get file MIME TYPE
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $contentType = finfo_buffer($finfo, $bytes);

        return response($bytes)
            ->setStatusCode(200)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', [$disposition, "finame=$galery->name"]);
    }

    public function getStoreGaleries($storeId, Request $request)
    {
        $store = Store::find($storeId);
        $this->validateStoreFound($store);
        $galeries = $store->storeGaleries ?? collect();
        return new StoreGaleryCollection($galeries);
    }

    private function validateGaleryFound($galery)
    {
        if (is_null($galery)) {
            abort(response()->json([
                'status' => 'fail',
                'message' => 'Gambar tidak ditemukan.'
            ])->setStatusCode(404));
        }
    }

    private function validateFileExists($path)
    {
        if (Storage::disk('gcs')->exists($path)) {
            abort(response()->json([
                'status' => 'fail',
                'message' => 'File tidak ditemukan pada Cloud Storage.'
            ])->setStatusCode(404));
        }
    }

    private function validateStoreFound($store)
    {
        $this->validateFound($store, 'Toko tidak dapat ditemukan.');
    }

    private function validateStoreFoundById($storeId)
    {
        $this->validateStoreFound(
            Store::select(['id'])->find($storeId)
        );
    }

    private function validateFound($data, $message)
    {
        if (is_null($data)) {
            abort(response()->json([
                'status' => 'fail',
                'message' => $message,
                'data' => false
            ], 404));
        }
    }
}
