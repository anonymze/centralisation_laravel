<?php

namespace App\Jobs\Brand;
use App\Entities\Brand;
use App\Entities\Product;

Class DeleteBrand
{
    private $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function handle(){
        $product_brand_ids = Product::query()->where('brand_id',$this->brand->id)->get();
        if ($product_brand_ids) {
            foreach($product_brand_ids as $product_brand_id) {
                $product_brand_id->update(['brand_id' => null]);
            }
        }
        $this->brand->delete();
    }
}