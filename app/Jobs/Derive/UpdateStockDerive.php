<?php

namespace App\Jobs\Derive;

use App\Entities\Derive;
use App\Jobs\API\UpdateStockPrestashop;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;

class UpdateStockDerive
{
    use DispatchesJobs;
    private $sale_attributes;

    public function __construct(array $sale_attributes)
    {
        $this->sale_attributes = $sale_attributes;
    }

    public function handle()
    {
        // On recup le champ de la table Derive avec le bon id, 2 solutions propre :
        //$current_derive = Derive::query()->where('id', $sale_attributes['id_product_derive'])->first();
        $current_derive = Derive::find($this->sale_attributes['derive_id']);
        $derive_update = array("stock" => ((int)$current_derive->stock) - ((int)$this->sale_attributes['quantity']));
        $current_derive->update($derive_update);

        // TODO à commenter si vous ne voulez pas de communication avec l'API
        // MAJ ALL PRESTA
         /* foreach (config('app.shops_config') as $shop_name) {
            $this->dispatch(new UpdateStockPrestashop(Arr::get($current_derive, 'id'), Arr::get($current_derive, 'stock'), $shop_name));
        } */
    }
}
