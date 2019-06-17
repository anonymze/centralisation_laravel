<?php

namespace App\Jobs\Product;

use App\Entities\Product;
use App\Helpers\ImageHelper;
use App\Jobs\Derive\CreateDerive;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;


class CreateProduct
{
    use DispatchesJobs;

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
        // CREATION DU PRODUIT
        $new_product = Product::create(Arr::except($this->attributes, ['derive', 'derives','product']));

        if(key_exists('product', $this->attributes) && !empty($this->attributes['product']['categories'])) {
            $new_product->categories()->attach(Arr::get($this->attributes['product'], 'categories'));
        }
        return $new_product;
    }
}


