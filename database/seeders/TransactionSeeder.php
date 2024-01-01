<?php

namespace Database\Seeders;

use App\Models\DonationType;
use App\Models\Donor;
use App\Models\GoodType;
use App\Models\Resident;
use App\Models\ServiceHour;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory()->count(100)->create();
    }
}
