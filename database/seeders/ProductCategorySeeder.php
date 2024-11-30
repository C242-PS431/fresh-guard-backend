<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['fruit', 'vegetable'])
            ->each(function ($value) {
                ProductCategory::create([
                    'category' => $value
                ]);
            });
    }
}
