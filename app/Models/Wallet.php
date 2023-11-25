<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'donation_types_id', 'good_types_id', 'name'];

    public function donation_type(): BelongsTo
    {
        return $this->belongsTo(DonationType::class);
    }

    public function good_type(): BelongsTo{
        return $this->belongsTo(GoodType::class);
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'wallets_id');
    }
}
