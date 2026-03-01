<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
        'event_date' => 'datetime',
        'published_at' => 'datetime',
    ];
}
