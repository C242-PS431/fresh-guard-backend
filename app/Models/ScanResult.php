<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;

/**
 * @property User $user
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
        'freshness_score'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
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

    public function trackedByUser(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, ScanResultTrack::class);
    }
}
