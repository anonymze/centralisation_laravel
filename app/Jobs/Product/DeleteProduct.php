<?php

namespace App\Jobs\Product;

use App\Entities\Product;
use App\Jobs\Derive\DeleteDerive;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Entities\Derive;


Class DeleteProduct
{
    use DispatchesJobs;
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        // CREATION DU DERIVE DU PRODUIT
        foreach(Derive::where('product_id','=',$this->product->id)->get() as $derive){
        $this->dispatchNow(new DeleteDerive($derive));
        }

        $this->product->delete();
    }
}