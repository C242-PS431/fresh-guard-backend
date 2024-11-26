<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasNanoid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = [
        'name',
        'description',
        'address',
        'operation_time',
        'phone',
        'gmap_url',
    ];

    public function storeGaleries(): HasMany
    {
        return $this->hasMany(StoreGalery::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_stores', 'store_id', 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
