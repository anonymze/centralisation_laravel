<?php

namespace App\Entities;
use Illuminate\Database\Eloquent\Model;


class Filter extends Model
{
    protected $guarded = [
        '_token',
        '_method'
    ];

    public function derives()
    {
        return $this->belongsToMany(Derive::class);
    }


}
