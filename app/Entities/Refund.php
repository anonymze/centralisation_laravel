<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = array('order_name','shop_name','product_id','derive_id','quantity');
}
