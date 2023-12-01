<?php

namespace App\Services;

use App\Models\Donor;
use App\Models\Guest;
use App\Models\Resident;
use Illuminate\Http\Request;

class DonorService
{
    public function createResidentDonor(Request $request, Resident $resident) : Donor
    {
        return $resident->donor()->create([
            'name' => $request->get('name'),
            'phone_number' => $request->get('phone_number'),
            'email' => $request->get('email')
        ]);
    }

    public function createGuestDonor(Request $request, Guest $guest) : Donor
    {
        return $guest->donor()->create([
            'name' => $request->get('name'),
            'phone_number' => $request->get('phone_number'),
            'email' => $request->get('email')
        ]);
    }
}
