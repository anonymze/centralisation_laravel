<?php

namespace App\Entities;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = array('product_id', 'derive_id', 'quantity','state');
}

