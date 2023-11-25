<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public function donationType(): BelongsTo
    {
        return $this->belongsTo(DonationType::class);
    }

    public function donor() : BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function wallet() : BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function goodType(): BelongsTo
    {
        return $this->belongsTo(GoodType::class);
    }
}
