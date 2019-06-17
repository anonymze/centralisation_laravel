<?php

namespace App\Jobs\API;
use App\Vendor\PrestaShopWebservice;

class CheckStock extends UpdateStockPrestashop
{
    public function __construct($derive_id, $stock_gestion, $shop_name)
    {
        parent::__construct($derive_id, $stock_gestion, $shop_name);
    }

    public function handle()
    {
        //setup webservice
        $webservice = new PrestaShopWebservice($this->ps_shop_path, $this->ps_ws_auth_key, $this->debug);

        // recup données presta
        $data = array(parent::getDataFromPrestashop($webservice));

        ############### TEST SI LE STOCK PRESTA CORRESPOND AU STOCK GESTION ###############################
        if (isset($this->stock_gestion) && $this->stock_gestion != $data['stock_prestashop']) {
            // si stock pas bon on notifie voir on update les stocks
            Log::Create([
                'error' => true,
                'shop_name' => $this->shop_name,
                'derive_id' => $this->derive_id,
                'stock' => $this->stock_gestion,
                'stock_prestashop' => $data['stock_prestashop'],
                'message' => 'Les stocks ne correspondaient pas à la suite d\'un checkstock'
            ]);

            // MAJ STOCK OU PAS ?
            //parent::updateStock($data);

        } else {
            // si les stocks correspondent on notifie
            Log::Create([
                'success' => true,
                'shop_name' => $this->shop_name,
                'derive_id' => $this->derive_id,
                'stock' => $this->stock_gestion,
                'stock_prestashop' => $data['stock_prestashop'],
                'message' => 'Les stocks correspondaient à la suite d\'un checkstock'
            ]);
        }
        ################################################################################################## */
    }

    public function compareStockBeforeSales($stock_prestashop, $infos_data)
    {
        $infos_data['derive_id'] = $this->derive_id;
        $current_stock_prestashop = (int)$stock_prestashop;

        $infos_data['validate_stock'] = false;
        if (((int)$this->stock_gestion - (int)$current_stock_prestashop) >= 0) {
            $infos_data['validate_stock'] = true;
        }
        return $infos_data;
    }
}
