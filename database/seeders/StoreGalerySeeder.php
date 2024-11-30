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
    public function run(\Hidehalo\Nanoid\Client $random): void
    {
        $store = Store::get()->random();
        StoreGalery::create([
            'store_id' => $store->id,
            'name' => 'market.png',
            'path' => 'gs://toko/oihroaihoisandksna.png'
        ]);
        StoreGalery::create([
            'store_id' => $store->id,
            'name' => 'toko.png',
            'path' => 'gs://toko/' . $random->generateId(20) . '.png'
        ]);
    }
}
