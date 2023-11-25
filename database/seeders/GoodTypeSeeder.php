<?php

namespace Database\Seeders;

use App\Models\GoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GoodType::insert([
            [
                'name' => 'BERAS'
            ],
            [
                'name' => 'UANG'
            ]
        ]);

    }
}
