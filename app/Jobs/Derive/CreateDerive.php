<?php

namespace App\Jobs\Derive;

use App\Entities\Derive;
use App\Entities\Product;
use Illuminate\Support\Arr;

Class CreateDerive
{

    private $product;
    private $attributes;

    function __construct(Product $product, array $attributes)
    {
        $this->product = $product;
        $this->attributes = $attributes;
    }

    function handle()
    {
        $attributes_derives_filters = Arr::except($this->attributes['derive'], '%id%');
        if (!empty($this->product->id)) {
            $this->attributes['product_id'] = $this->product->id;
        }
        foreach ($attributes_derives_filters as $attribute_derive_filters) {
            $attribute_derive = Arr::except($attribute_derive_filters, 'filters');
            $derive = Derive::create(array_merge([
                'product_id' => $this->attributes['product_id']
            ], $attribute_derive));
            if (key_exists('filters', $attribute_derive_filters)) {
                $derive->filters()->attach(Arr::get($attribute_derive_filters, 'filters'));
            }
        }
    }
}
