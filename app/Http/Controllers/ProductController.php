<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getStoreProducts($storeId, Request $request)
    {
        $perPage = $request->integer('per_page', 5);
        $page = $request->integer('page', 1);
        $store = Store::find($storeId);
        $this->validateStoreFound($store);

        $products = $store->products()->paginate(perPage: $perPage, page: $page);

        return new ProductCollection($products);
    }

    public function getProductCategories($productId, Request $request)
    {
        $perPage = $request->integer('per_page', 5);
        $page = $request->integer('page', 1);

        $product = Product::find($productId);
        $categories = $product->categories()->paginate();

        return new ProductCategoryCollection($categories);
    }

    private function validateStoreFound($store)
    {
        $this->validateFound($store, 'Toko tidak dapat ditemukan');
    }

    private function validateFound($data, $message)
    {
        if (is_null($data)) {
            throw new HttpResponseException(response()->json([
                'status' => 'fail',
                'message' => $message,
                'data' => null
            ], 404));
        }
    }
}
