<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Complaint extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => ComplaintStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $complaint) {
            if (! empty($complaint->ticket_code)) {
                return;
            }

            $year = now()->format('Y');

            do {
                $code = 'TRX-' . $year . '-' . Str::upper(Str::random(6));
            } while (static::where('ticket_code', $code)->exists());

            $complaint->ticket_code = $code;
        });
    }
}