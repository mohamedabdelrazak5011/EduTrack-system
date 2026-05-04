<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Center;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $centers = [
            'سنتر الضوي',
            'سنتر الفيروز',
            'سنتر البيطاش',
            'سنتر العامرية',
        ];

        foreach ($centers as $center) {
            Center::create([
                'name' => $center
            ]);
        }
    }
}