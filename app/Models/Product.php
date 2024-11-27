<?php

namespace App\Models;

use App\Traits\HasNanoid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasNanoid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category', 'product_id', 'category_id');
    }
}
