<?php

namespace App\Jobs\API;

use App\Entities\Log;
use App\Vendor\PrestaShopWebservice;


class UpdateStockPrestashop
{
    protected $debug = false;
    protected $derive_id;
    protected $stock_gestion;
    protected $shop_name;
    protected $ps_shop_path;
    protected $ps_ws_auth_key;

    public function __construct($derive_id, $stock_gestion, $shop_name)
    {

        $this->shop_name = $shop_name;
        $this->stock_gestion = $stock_gestion;
        $this->derive_id = $derive_id;

        // Config connexion PRESTASHOP
        $this->ps_shop_path = env('URL_SHOP_' . $shop_name);
        $this->ps_ws_auth_key = env('KEY_SHOP_' . $shop_name);

    }

    public function handle()
    {
        // setup webservice
        $webservice = new PrestaShopWebservice($this->ps_shop_path, $this->ps_ws_auth_key, $this->debug);

        // recup des données presta
        $data = $this->getDataFromPrestashop($webservice);

        // Appel de la fonction update pour les presta
        if ($data) {
            $this->updateStock($data);
        }
    }

    public function getDataFromPrestashop($webservice)
    {
        ############### RECUP DE L'ID ATTRIBUTE PRESTASHOP DEPUIS LE FICHIER XML WEBSERVICE ###############
        // on appel le fichier xml en question
        $xml_get_id_attribute_prestashop = $webservice->get(array('url' => $this->ps_shop_path . 'api/combinations?filter[id_product_derive]=' . $this->derive_id));

        if ($xml_get_id_attribute_prestashop->combinations->combination) {

            $resource_attribute_prestashop = $xml_get_id_attribute_prestashop->children()->children();

            // on stock l'id attribute dans une var
            $id_attribute_prestashop = (int)$resource_attribute_prestashop->combination['id'];
            ###################################################################################################

            ############### RECUP DE L'ID PRODUCT PRESTASHOP DEPUIS LE FICHIER XML WEBSERVICE #################
            $xml_get_id_product_prestashop = $webservice->get(array('url' => $this->ps_shop_path . 'api/combinations/' . $id_attribute_prestashop));
            $resource_product_prestashop = $xml_get_id_product_prestashop->children()->children();

            $id_product_prestashop = (int)$resource_product_prestashop->id_product;
            ###################################################################################################

            ############### RECUP DE L'ID STOCK AVAILABLE PRESTASHOP DEPUIS LE FICHIER XML WEBSERVICE #########
            $xml_get_id_stock = $webservice->get(array('url' => $this->ps_shop_path . 'api/stock_availables?filter[id_product_attribute]=' . $id_attribute_prestashop));
            $resource_id_stock = $xml_get_id_stock->children()->children();

            $id_stock_prestashop = (int)$resource_id_stock->stock_available['id'];
            ###################################################################################################

            ############### RECUP DU STOCK EN COURS PRESTASHOP DEPUIS LE FICHIER XML WEBSERVICE ###############
            $xml_get_stock_prestashop = $webservice->get(array('url' => $this->ps_shop_path . 'api/stock_availables/' . $id_stock_prestashop));
            $resource_stock_prestashop = $xml_get_stock_prestashop->children()->children();

            $stock_prestashop = (int)$resource_stock_prestashop->quantity;
            ###################################################################################################
            return array('webservice' => $webservice, 'id_stock_prestashop' => $id_stock_prestashop, 'id_product_prestashop' => $id_product_prestashop, 'id_product_attribute_prestashop' => $id_attribute_prestashop, 'stock_prestashop' => $stock_prestashop);
        } else {
            Log::Create([
                'error' => true,
                'shop_name' => $this->shop_name,
                'derive_id' => $this->derive_id,
                'message' => 'La déclinaison ID n\'a pas été trouvé sur le prestashop'
            ]);
            return false;
        }
    }

    protected function updateStock($data)
    {
        ############### ENVOIE DU STOCK MIS A JOUR A TOUS LES PRESTA ###############################
        // recup du xml à modifier
        $opt_stock = array('resource' => 'stock_availables', 'id' => $data['id_stock_prestashop']);
        $xml_stock = $data['webservice']->get($opt_stock);


        // modif valeur xml (j'ai pas réussi à unset les valeurs que je voulais pas toucher..)
        $xml_stock->children()->children()->id_product_attribute = $data['id_product_attribute_prestashop'];
        $xml_stock->children()->children()->id_product = $data['id_product_prestashop'];
        $xml_stock->children()->children()->quantity = $this->stock_gestion;
        $xml_stock->children()->children()->depends_on_stock = 0;
        $xml_stock->children()->children()->out_of_stock = 2;

        // format nécessaire pour l'envoie du xml en PUT
        $opt_stock['putXml'] = $xml_stock->asXML();

        // envoie des données en PUT pour le remplacement du stock
        $data['webservice']->edit($opt_stock);

        if (($this->stock_gestion - $data['stock_prestashop']) !== 0 ) {
            Log::Create([
                'success' => true,
                'shop_name' => $this->shop_name,
                'derive_id' => $this->derive_id,
                'stock' => $this->stock_gestion,
                'stock_prestashop' => $data['stock_prestashop'],
                'stock_change_prestashop' => $this->stock_gestion - $data['stock_prestashop'],
                'message' => 'Le stock pretashop a été mis à jour'
            ]);
        }

    }
}