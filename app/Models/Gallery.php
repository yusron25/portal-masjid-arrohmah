<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }
}