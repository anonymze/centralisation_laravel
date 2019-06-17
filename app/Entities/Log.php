<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = array('state','error','success','shop_name','derive_id','message','stock','stock_prestashop','stock_change_prestashop');

    public function setSuccessAttribute($value){
        $this->attributes['success'] = $value ?? false;
    }

    public function setErrorAttribute($value){
        $this->attributes['error'] = $value ?? false;
    }

    public function setStateAttribute($value){
        $this->attributes['state'] = $value ?? false;
    }
}
