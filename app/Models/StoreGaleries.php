<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreGaleries extends Model
{
    use HasNanoid, SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
