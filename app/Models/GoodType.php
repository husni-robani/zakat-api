<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoodType extends Model
{
    use HasFactory;

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'good_types_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'good_types_id');
    }
}
