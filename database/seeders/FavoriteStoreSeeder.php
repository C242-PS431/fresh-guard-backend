<?php

namespace Database\Seeders;

use App\Models\FavoriteStore;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find("409605036685");
        $store = Store::get()->random();
        $user->favoritedStores()->attach($store->id);
    }
}
