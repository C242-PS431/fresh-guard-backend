<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\StoreGalery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreGalerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = Store::get()->random();
        StoreGalery::create([
            'store_id' => $store->id,
            'name' => 'pisang.png',
            'path' => 'gs://buah/'
        ]);
        StoreGalery::create([
            'store_id' => $store->id,
            'name' => 'apple.png',
            'path' => 'gs://buah/'
        ]);
    }
}
