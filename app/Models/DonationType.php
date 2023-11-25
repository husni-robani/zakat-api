<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DonationType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'donation_types_id');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'donation_types_id');
    }

}
