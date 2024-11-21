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
            'address' => 'Planet nebula',
            'operation_time' => '05.00 - 15.00',
            'phone' => "12345678" . random_int(100, 999),
            'gmap_url' => 'kosong'
        ]);
    }
}
