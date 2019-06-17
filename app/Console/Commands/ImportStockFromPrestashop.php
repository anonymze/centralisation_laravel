<?php

namespace App\Console\Commands;

use App\Entities\Derive;
use App\Entities\Log;
use App\Jobs\API\UpdateStockPrestashop;
use App\Vendor\PrestaShopWebservice;
use Illuminate\Console\Command;

class ImportStockFromPrestashop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:import {prestashop}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all stocks from prestashop';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shop_name = $this->argument('prestashop');
        $shops_keys = config('app.shops_config');
        if (in_array($shop_name, $shops_keys)) {
            $debug = false;
            $ps_shop_path = env('URL_SHOP_' . $shop_name);
            $ps_ws_auth_key = env('KEY_SHOP_' . $shop_name);
            $webservice = new PrestaShopWebservice($ps_shop_path, $ps_ws_auth_key, $debug);

            foreach (Derive::all() as $derive) {
                $data_from_prestashop = new UpdateStockPrestashop($derive->id, $derive->stock, $shop_name);
                $attributes_update = $data_from_prestashop->getDataFromPrestashop($webservice);
                $derive->update(['stock' => $attributes_update['stock_prestashop']]);
            }
            $this->info('Les stocks gestions ont été mis à jour');
        } else {
            $this->error('Le shop n\'existe pas');
        }
    }
}
