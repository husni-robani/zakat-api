<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DonationType;
use App\Models\GoodType;
use App\Models\ServiceHour;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@example.com',
            'name' => 'admin',
            'password' => 'password'
        ]);

        ServiceHour::create([
            'day' => 'Senin',
            'open' => '14:00:00',
            'close' => '18:00:00'
        ]);

        (new DonationTypeSeeder())->run();
        (new GoodTypeSeeder())->run();
        (new WalletSeeder())->run();
        (new ResidentSeeder())->run();
        (new DonorSeeder())->run();
        (new TransactionSeeder())->run();
//        (new DistributionSeeder())->run();
    }
}
