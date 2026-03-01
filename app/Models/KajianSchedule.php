<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KajianSchedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_recurring' => 'boolean',
        'is_active' => 'boolean',
        'event_date' => 'date',
    ];
}
