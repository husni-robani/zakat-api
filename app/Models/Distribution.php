<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Distribution extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['description', 'amount', 'wallet_id', 'title', 'link'];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this
                ->addMediaConversion('preview')
                ->fit(Manipulations::FIT_CROP, 300, 300)
                ->nonQueued();
        } catch (InvalidManipulation $e) {
        }
    }

}
