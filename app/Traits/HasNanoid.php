<?php

namespace App\Traits;
use Hidehalo\Nanoid\Client;
trait HasNanoid
{
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (new Client())->formatedId('0123456789', 12);
        });
    }
}
