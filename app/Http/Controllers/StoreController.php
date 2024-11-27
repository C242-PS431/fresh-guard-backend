<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreCollection;
use App\Http\Resources\StoreGaleryCollection;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function getStores(Request $request): StoreCollection
    {
        $perPage = $request->integer('per_page', 5);
        $page = $request->integer('page', 1);
        $getFavorite = $request->boolean('favorite');

        if ($getFavorite) {
            $stores = $request->user()->favoritedStores()->paginate(perPage: $perPage, page: $page);
        } else {
            $stores = Store::paginate(perPage: $perPage, page: $page);
        }
        return new StoreCollection($stores);
    }

    public function addFavoriteStore($storeId, Request $request)
    {
        $this->validateStoreFound(Store::find($storeId));
        $this->validateStoreNotAlreadyFavorited($storeId);

        $request->user()->favoritedStores()->attach($storeId);

        return response()->json([
            'status' => 'favorite_added',
            'message' => 'Sukses menambahkan toko ke daftar favorite.',
            'data' => true
        ], 201);
    }

    public function removeFavoriteStore($storeId, Request $request): JsonResponse
    {
        $this->validateStoreFound(Store::find($storeId));
        $this->validateStoreAlreadyFavorited($storeId);

        $request->user()->favoritedStores()->detach($storeId);

        return response()->json([
            'status' => 'favorite_removed',
            'message' => 'Toko telah dihapus dari daftar favorite.',
            'data' => true
        ], 200);
    }

    public function findStore($storeId, Request $request): StoreResource
    {
        $store = Store::find($storeId);
        $this->validateStoreFound($store);
        return new StoreResource($store);
    }

    public function getStoreGaleries($storeId, Request $request)
    {
        $store = Store::find($storeId);
        $this->validateStoreFound($store);
        $galeries = $store->storeGaleries ?? collect();
        return new StoreGaleryCollection($galeries);
    }


    private function validateStoreFound($store)
    {
        $this->validateFound($store, 'Toko tidak dapat ditemukan.');
    }

    private function validateFound($data, $message)
    {
        if (is_null($data)) {
            throw new HttpResponseException(response()->json([
                'status' => 'fail',
                'message' => $message,
                'data' => false
            ], 404));
        }
    }

    public function validateStoreNotAlreadyFavorited(string $storeId)
    {
        if (Auth::user()->isFavoritedStore($storeId)) {
            throw new HttpResponseException(response()->json([
                'status' => 'already_favorited',
                'message' => 'Toko sudah ditambahkan ke favorite sebelumnya.',
                'data' => false
            ], 200));
        }
    }

    public function validateStoreAlreadyFavorited(string $storeId)
    {
        if (Auth::user()->isFavoritedStore($storeId)) {
            throw new HttpResponseException(response()->json([
                'status' => 'not_favorited',
                'message' => 'Toko belum ditambahkan ke favorite sebelumnya.',
                'data' => false 
            ], 200));
        }
    }
}
