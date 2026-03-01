<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
