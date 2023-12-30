<?php

namespace Database\Seeders;

use App\Models\ServiceHour;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        (new TransactionSeeder())->run();

//        (new DonorSeeder())->run();
//        (new ResidentSeeder())->run();
//        (new GuestSeeder())->run();
//        (new DistributionSeeder())->run();
    }
}
