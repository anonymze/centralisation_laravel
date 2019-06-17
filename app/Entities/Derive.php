<?php

namespace App\Entities;

use App\Datatables\DeriveDatatables;
use Illuminate\Database\Eloquent\Model;

class Derive extends Model
{
    protected $guarded = [
        '_token',
        '_method'
    ];

    // a un produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class);
    }


    public function setStockAttribute($value)
    {
        $this->attributes['stock'] = $value ?? 0;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value ?? 0;
    }

    public function setBufferAttribute($value)
    {
        $this->attributes['buffer'] = $value ?? 10;
    }

    public function datatables()
    {
        return new DeriveDatatables($this);
    }

}
