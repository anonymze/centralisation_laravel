<?php

namespace App\Jobs\API;

use App\Entities\Derive;
use App\Entities\Log;
use App\Entities\Sale;
use App\Jobs\Derive\UpdateStockDerive;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CreateSale
{
    use DispatchesJobs;
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function handle()
    {

        // CHECK IF STOCK IS GOOD FOR ALL PRODUCTS BEFORE CREATING THE SALE
        $data_stock = array();
        foreach ($this->attributes as $order_name => $tab_attributes_all_order) {
            foreach ($tab_attributes_all_order as $tab_attributes_order) {
                if (Derive::query()->find($tab_attributes_order['derive_id'])) {
                    $current_stock_gestion = Derive::query()->find($tab_attributes_order['derive_id'])->stock;
                    // TODO à ne pas commenter si ne voulez pas d'erreur de stock en mode test
                    $current_stock_gestion = 999;
                    $check_stock = new CheckStock($tab_attributes_order['derive_id'], $current_stock_gestion, $tab_attributes_order['shop_name']);
                    $validation_stock[] = $check_stock->compareStockBeforeSales($tab_attributes_order['quantity'], $data_stock);
                } else {
                    Log::Create([
                        'error' => true,
                        'shop_name' => $tab_attributes_order['shop_name'],
                        'derive_id' => $tab_attributes_order['derive_id'],
                        'stock_change_prestashop' => (int)-$tab_attributes_order['quantity'],
                        'message' => 'La déclinaison ID n\'a pas été trouvé sur la gestion centralisée'
                    ]);
                }
                if (isset($validation_stock) && !$this->validateMultiArrays($validation_stock)) {
                    Log::Create([
                        'error' => true,
                        'shop_name' => $tab_attributes_order['shop_name'],
                        'derive_id' => $tab_attributes_order['derive_id'],
                        'message' => 'Une commande a été refusée car un produit était en rupture de stock (commmande simultanée)'
                    ]);
                }
            }
        }

        // CREATE SALE + UPDATE
        if (!empty($validation_stock)) {
            if ($this->validateMultiArrays($validation_stock)) {
                $sale_attributes = array();
                foreach ($this->attributes as $order_name => $tab_attributes_all_order) {
                    $sale_attributes['order_name'] = $order_name;
                    foreach ($tab_attributes_all_order as $tab_attributes_order) {
                        $tab_attributes_order['product_id'] = Derive::query()->find($tab_attributes_order['derive_id'])->product_id;
                        foreach ($tab_attributes_order as $name_attributes => $attributes_order) {
                            $sale_attributes[$name_attributes] = $attributes_order;
                        }
                        Sale::create($sale_attributes);
                        // TODO à commenter si vous ne voulez pas de communication avec l'API
                        //$this->dispatch(new UpdateStockDerive($tab_attributes_order));
                    }
                }
            } else {
                $return['status'] = 'error';
                $return['message'] = 'Erreur de stock sur la commande';
                $return['data'] = $validation_stock;
                return $return;
            }
        } else {
            $return['status'] = 'error';
            $return['message'] = 'ID déclinaison non trouvée sur la gestion';
            return $return;
        }
    }

    private function validateMultiArrays($validation_stock)
    {
        foreach ($validation_stock as $item) {
            if (in_array(false, $item)) {
                return false;
            }
        }

        return true;
    }
}