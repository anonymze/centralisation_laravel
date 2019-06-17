<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [
        '_token',
        '_method'
    ];

    public function products()
    {
        // a plusieurs produits
        return $this->hasMany(Product::class);
    }
}
