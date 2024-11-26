<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produce extends Model
{
    
    use HasNanoid;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    public $fillable = [
        'name',
        'calories',
        'protein',
        'carbohydrates',
        'fiber'
    ];

    public function scanResults(): HasMany
    {
        return $this->hasMany(ScanResult::class);
    }
}
