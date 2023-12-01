<?php

namespace Database\Seeders;

use App\Models\DonationType;
use App\Models\GoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GoodType::all()->map(function ($goodType){
            DonationType::all()->map(function ($donationType) use ($goodType){
                $donationType->wallet()->create([
                    'name' => $donationType->name . ' (' . $goodType->name . ")",
                    'amount' => 0,
                    'good_types_id' => $goodType->id
                ]);
            });
        });
    }
}
