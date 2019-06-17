<?php

namespace App\Entities;

use App\Datatables\ProductDatatables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Product extends Model
{
    use SerializesModels;

    protected $guarded = [
        '_token',
        '_method'
    ];

    public function brand()
    {
        // appartient au parent brand
        return $this->belongsTo(Brand::class);
    }

    // a plusieurs derivés
    public function derives()
    {
        return $this->hasMany(Derive::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_category');
    }

    public function datatables()
    {
        return new ProductDatatables($this);
    }
}
