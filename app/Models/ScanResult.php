<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property User $user
 * @property Carbon $created_at
 */
class ScanResult extends Model
{
    use HasNanoid;
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = [
        'user_id',
        'produce_id',
        'freshness_score',
        'smell',
        'texture',
        'verified_store'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (new Client())->formatedId('0123456789', 12);
            $model->created_at = Carbon::now();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function produce(): BelongsTo
    {
        return $this->belongsTo(Produce::class);
    }
}
