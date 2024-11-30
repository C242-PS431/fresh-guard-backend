<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryCollection;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getListProductCategories(Request $request)
    {
        $perPage = $request->integer('per_page', 10);
        $page = $request->integer('page', 1);

        $products = ProductCategory::paginate(perPage: $perPage, page: $page);
        return new ProductCategoryCollection($products);
    }

}
