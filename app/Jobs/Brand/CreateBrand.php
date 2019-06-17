<?php

namespace App\Jobs\Brand;

use App\Entities\Brand;
use App\Helpers\ImageHelper;



class CreateBrand
{

    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function handle()
    {
        if (!empty($this->attributes['image'])) {
            $this->attributes['image'] = ImageHelper::formatImage($this->attributes['image']);
        } else {
            $this->attributes['image'] = asset('images/150x150.png');
        }
        Brand::create($this->attributes);
    }
}
