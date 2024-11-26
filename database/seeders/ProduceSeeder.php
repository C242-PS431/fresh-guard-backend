<?php

namespace Database\Seeders;

use App\Models\Produce;
use Illuminate\Database\Seeder;

class ProduceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {;
        // name, calories, protein, carbohydrates, fiber
        // mg
        $datas = collect([
            ['cabbage', 375, 30, 75, 45],
            ['apple', 95000, 500, 25000, 4400],
            ['banana', 105000, 1300, 27000, 3100],
            ['capsicum', 30000, 1000, 7000, 3000],
            ['tomato', 22000, 11000, 4800, 1500]
        ]);

        $datas->each(function ($value) {
            Produce::create([
                'name' => $value[0],
                'calories' => $value[1],
                'protein' => $value[2],
                'carbohydrates' => $value[3],
                'fiber' => $value[4]
            ]);
        });
    }
}
