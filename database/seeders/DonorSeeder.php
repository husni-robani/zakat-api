<?php

namespace Database\Seeders;

use App\Models\Donor;
use App\Models\Guest;
use App\Models\Resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donor = new Donor();
        $donor->name = 'Test Donor from resident';
        $donor->phone_number = '029128212221';
        $donor->email = 'test.donor1@example.com';
        Resident::first()->donor()->save($donor);

        $donor = new Donor();
        $donor->name = 'Test Donor from guest';
        $donor->phone_number = '01239123123';
        $donor->email = 'test.donor2@example.com';
        Guest::create([
            'description' => 'Pak president memberikan sumbangan sebesar 1 juta'
        ])->donor()->save($donor);
    }
}
