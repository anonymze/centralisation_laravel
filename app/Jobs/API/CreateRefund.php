<?php

namespace App\Jobs\API;

use App\Entities\Derive;
use App\Entities\Refund;
use App\Jobs\Derive\UpdateStockDerive;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CreateRefund
{
    private $attributes;
    use DispatchesJobs;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function handle()
    {
        if (Derive::find($this->attributes['derive_id'])) {
            $this->attributes['product_id'] = Derive::find($this->attributes['derive_id'])->product_id;
            Refund::create($this->attributes);
            // on inverse le signe pour augmenter le stock
            $this->attributes['quantity'] = -((int)$this->attributes['quantity']);
            $this->dispatchNow(new UpdateStockDerive($this->attributes));
        }
    }
}

