<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = array('order_name','product_id','derive_id','quantity','shop_name');

    // a plusieurs derivés
    public function derives()
    {
        return $this->hasMany(Derive::class);
    }
}