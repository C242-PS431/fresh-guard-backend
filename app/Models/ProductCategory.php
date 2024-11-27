<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasNanoid;
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category', 'product_id', 'category_id');
    }
}
