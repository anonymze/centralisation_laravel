<?php

namespace App\Entities;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [
        '_token',
        '_method'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
