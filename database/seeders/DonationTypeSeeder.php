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
                ],
                [
                    'name' => 'MAL'
                ],
                [
                    'name' => 'FIDYAH'
                ],
                [
                    'name' => 'SEDEKAH'
                ]
            ]
        );

    }
}
