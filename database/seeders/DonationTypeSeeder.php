<?php

namespace Database\Seeders;

use App\Models\DonationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DonationType::insert(
            [
                [
                    'name' => 'FITRAH',
                    'id' => 1
                ],
                [
                    'name' => 'MAL',
                    'id' => '2'
                ],
                [
                    'name' => 'FIDYAH',
                    'id' => 3
                ],
                [
                    'name' => 'SEDEKAH',
                    'id' => 4
                ]
            ]
        );

    }
}
