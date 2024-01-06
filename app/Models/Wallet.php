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

    public function donationType(): BelongsTo
    {
        return $this->belongsTo(DonationType::class, 'donation_types_id');
    }

    public function goodType(): BelongsTo{
        return $this->belongsTo(GoodType::class, 'good_types_id');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'wallets_id');
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class, 'wallet_id');
    }

    public function addAmount($amount){
        $this->update([
            'amount' => $this->amount + $amount
        ]);

        return $this;
    }

    public function reduceAmount($amount){
        $this->update([
            'amount' => $this->amount - $amount
        ]);
        return $this;
    }
}
