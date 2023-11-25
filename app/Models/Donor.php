<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number'];

    public function donorable() : MorphTo {
        return $this->morphTo();
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'donors_id');
    }
}
