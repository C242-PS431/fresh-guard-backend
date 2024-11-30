<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name' => 'Toko '. rand(),
            'description' => "Ini adalah toko buah",
            'address' => 'Jl. A. Yani No.98, Melayu, Kec. Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan',
            'operation_time' => '05.00 - 15.00',
            'phone' => "08123456" . random_int(100, 999),
            'gmap_url' => 'https://maps.app.goo.gl/p5z1XkJVjYQau2JG6'
        ]);
    }
}
