<?php

namespace App\Jobs\Derive;

use App\Entities\Derive;
use App\Entities\Movement;
use App\Jobs\API\UpdateStockPrestashop;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;

class UpdateDerive
{
    private $attributes_update;
    private $current_derive;
    use DispatchesJobs;

    public function __construct(array $attributes_update, Derive $current_derive)
    {
        $this->attributes_update = $attributes_update;
        $this->current_derive = $current_derive;
    }

    public function handle()
    {
        if (!key_exists('pk', $this->attributes_update)) {
            // formatage des données
            if (key_exists('derive', $this->attributes_update)) {
                $attributes_update_derive = $this->attributes_update['derive'];
            } else {
                $i = 0;
                foreach($this->attributes_update as $key => $attributes_update){
                    $attributes_update_derive[$i][$key] = $attributes_update;
                    $i++;
                }
            }
            //
            foreach ($attributes_update_derive as $key => $attributes_derive) {
                if (key_exists('price', $attributes_derive)) {
                    if (empty($attributes_derive['price']) || $attributes_derive['price'] == 0) {
                        $attributes_update_derive[$key]['price'] = (float)0.000;
                    }
                } else if (key_exists('stock', $attributes_derive)) {
                    if (empty($attributes_derive['stock'])) {
                        $attributes_update_derive[$key]['stock'] = (int)0;
                    }
                } else if (key_exists('buffer', $attributes_derive)) {
                    if (empty($attributes_derive['buffer']) || $attributes_derive['buffer'] == 0) {
                        $attributes_update_derive[$key]['buffer'] = (int)10;
                    }
                }
            }

            $no_filters_attributes_update_derive = Arr::except($attributes_update_derive, [0]);
            $clean_attributes_derive = ['price' => $no_filters_attributes_update_derive[1]['price'], 'stock' => $no_filters_attributes_update_derive[2]['stock'], 'buffer' => $no_filters_attributes_update_derive[3]['buffer']];

            if ($this->current_derive->stock != $clean_attributes_derive['stock']) {
                Movement::create([
                    'product_id' => $this->current_derive->product->id,
                    'derive_id' => $this->current_derive->id,
                    'quantity' => ((int)$clean_attributes_derive['stock']) - ((int)$this->current_derive->stock),
                ]);
            }

            $this->current_derive->update($clean_attributes_derive);

            //$ids = $this->current_derive->filters()->allRelatedIds();
            $this->current_derive->filters()->detach();
            $this->current_derive->filters()->sync([]);
            if (key_exists('filters', $attributes_update_derive[0])) {
                $this->current_derive->filters()->attach(Arr::get($attributes_update_derive[0], 'filters'));
            }

        } else if (key_exists('pk', $this->attributes_update)) {
            if ($this->current_derive->stock != $this->attributes_update['value']) {
                Movement::create([
                    'product_id' => $this->current_derive->product->id,
                    'derive_id' => $this->current_derive->id,
                    'quantity' => ((int)$this->attributes_update['value']) - ((int)$this->current_derive->stock),
                ]);
            }
            $this->current_derive->update([$this->attributes_update['name'] => $this->attributes_update['value']]);
        }

        // TODO à commenter si vous ne voulez pas de communication avec l'API
        // Update tous les prestas
        /* foreach (config('app.shops_config') as $shop_name) {
           $this->dispatchNow(new UpdateStockPrestashop($this->current_derive->id, $clean_attributes_derive['stock'] ?? $this->attributes_update['value'], $shop_name));
       } */
    }
}


