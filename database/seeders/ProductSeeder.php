<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::select(['id'])->limit(5)->get();
        $store = $stores->random();
        $product = Product::create([
            'store_id' => $store->id,
            'name' => collect(['Apple', 'Banana', 'Paprika'])->random() . random_int(1, 100),
            'description' => "Lorem ipsum dolor sit amet.",
            'price' => 1000 * random_int(10, 200),
            'stock' => random_int(1, 100)
        ]);

        $categories = ProductCategory::limit(2)->get();
        $categories->each(function ($category) use ($product) {
            $product->productCategories()->attach($category->id);
        });
    }
}