<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public function donor() : MorphOne
    {
        return $this->morphOne(Donor::class, 'donorable');
    }
}
