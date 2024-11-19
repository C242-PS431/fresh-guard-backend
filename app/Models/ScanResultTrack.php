<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanResultTrack extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scanResult(): BelongsTo
    {
        return $this->belongsTo(ScanResultTrack::class);
    }
}
