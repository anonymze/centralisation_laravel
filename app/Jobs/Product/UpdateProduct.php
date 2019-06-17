<?php

namespace App\Jobs\Product;


use App\Entities\Derive;
use App\Entities\Product;
use App\Helpers\ImageHelper;
use App\Jobs\Derive\UpdateDerive;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;


Class UpdateProduct
{
    use DispatchesJobs;
    private $product;
    private $attributes_update;

    function __construct(Product $product, array $attributes_update)
    {
        $this->product = $product;
        $this->attributes_update = $attributes_update;
    }

    function handle()
    {
        if (!empty($this->attributes_update['image'])) {
            $this->attributes_update['image'] = ImageHelper::formatImage($this->attributes_update['image']);
        }

        $this->product->update(Arr::except($this->attributes_update, ['derive','product']));

        $this->product->categories()->detach();
        $this->product->categories()->sync([]);
        if (key_exists('product', $this->attributes_update) && !empty($this->attributes_update['product']['categories'])) {
            $this->product->categories()->attach(Arr::get($this->attributes_update['product'], 'categories'));
        }

        if (key_exists('derive', $this->attributes_update)) {
            $derives = Derive::query()->where('product_id', '=', $this->product->id)->get();
            $i_used = array();
            foreach ($derives as $derive) {
                for ($i = 0; $i < count($this->attributes_update['derive']); $i++) {
                    $new_i = $i;
                    if (!in_array($new_i, $i_used)) {
                        $this->dispatchNow(new UpdateDerive($this->attributes_update['derive'][$new_i], $derive));
                        $i_used[] = $new_i;
                        $i += 999;
                    }
                }
            }
        }
    }
}