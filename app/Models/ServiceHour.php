<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceHour extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'open', 'close', 'available'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'service_hours_id');
    }
}
