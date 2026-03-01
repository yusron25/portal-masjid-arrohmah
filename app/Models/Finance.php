<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];
}
