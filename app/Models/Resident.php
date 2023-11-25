<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = ['no_kk', 'house_number', 'total_muzaki'];

    public function donor() : MorphOne
    {
        return $this->morphOne(Donor::class, 'donorable');
    }
}
