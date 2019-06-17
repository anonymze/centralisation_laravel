<?php


namespace App\Jobs\Brand;

use App\Entities\Brand;
use App\Helpers\ImageHelper;

Class UpdateBrand
{

    private $brand;
    private $attributes_update;


    function __construct(Brand $brand, array $attributes_update)
    {
        $this->brand = $brand;
        $this->attributes_update = $attributes_update;
    }

    function handle()
    {
        if (!empty($this->attributes_update['image'])) {
            $this->attributes_update['image'] = ImageHelper::formatImage($this->attributes_update['image']);
        }

        $this->brand->update($this->attributes_update);
    }
}