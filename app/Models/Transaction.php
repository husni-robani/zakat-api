<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['completed', 'amount', 'description', 'good_types_id', 'donation_types_id', 'wallets_id'];
    public function donationType(): BelongsTo
    {
        return $this->belongsTo(DonationType::class, 'donation_types_id', 'id');
    }

    public function donor() : BelongsTo
    {
        return $this->belongsTo(Donor::class, 'donors_id', 'id');
    }

    public function wallet() : BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallets_id', 'id');
    }

    public function goodType(): BelongsTo
    {
        return $this->belongsTo(GoodType::class, 'good_types_id', 'id');
    }
}
