<?php

namespace App\Http\Controllers;

use App\Entities\Derive;
use App\Entities\Log;
use App\Entities\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class StockController extends Controller
{
    public function index()
    {
        return View::make('stocks/index')->withLogs(Log::all());
    }

    public static function getInfosSales()
    {
        $date = new Carbon();
        $products_yesterday_sale = array();
        $products_today_sale = array();
        $today_global_sale = 0;
        $yesterday_global_sale = 0;
        foreach (Sale::all() as $sale) {

            if ($sale->updated_at->format('d-m-y') == $date->now()->format('d-m-y')) {
                $today_global_sale += $sale->quantity;
                $derive_ids = Derive::query()->where('id', '=', $sale->derive_id)->first();
                if (!empty($derive_ids)) {
                    if(!array_key_exists($derive_ids->product->name,$products_today_sale)) {
                        $products_today_sale[$derive_ids->product->name] = 0;
                    }
                    $products_today_sale[$derive_ids->product->name] += $sale->quantity;
                }
            }

            if ($sale->updated_at->format('d-m-y') == $date->now()->addDays(-1)->format('d-m-y')) {
                $yesterday_global_sale += $sale->quantity;
                $derive_ids = Derive::query()->where('id', '=', $sale->derive_id)->first();
                if (!empty($derive_ids)) {
                    if(!array_key_exists($derive_ids->product->name,$products_yesterday_sale)) {
                        $products_yesterday_sale[$derive_ids->product->name] = 0;
                    }
                    $products_yesterday_sale[$derive_ids->product->name] += $sale->quantity;
                }
            }
        }
        if (!empty($today_global_sale && !empty($yesterday_global_sale))) {
            $percentage_sale = (($today_global_sale / $yesterday_global_sale) * 100) - 100;
        } else {
            $percentage_sale = 0;
        }
        return $infos_sales = ["percentage_sale" => (int)$percentage_sale, "today_sale" => $products_today_sale];
    }

    public static function getInfosBuffers()
    {
        $derives = Derive::all();
        $infos_buffers = array();
        foreach ($derives as $key => $derive) {
            $product_name = $derive->product->name;
            if ($derive->stock <= ((int)(($derive->buffer / 2) - ($derive->buffer * 0.1)))) {
                $infos_buffers['danger'][] = [
                    'stock' => $derive->stock,
                    'product_name' => $product_name,
                ];
            } else if ($derive->stock <= $derive->buffer) {
                $infos_buffers['warning'][] = [
                    'stock' => $derive->stock,
                    'product_name' => $product_name,
                ];
            } else {
                $infos_buffers['success'][] = [
                    'stock' => $derive->stock,
                    'product_name' => $product_name,
                ];
            }
        }
        return $infos_buffers;
    }
}
