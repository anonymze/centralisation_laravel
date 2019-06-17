<?php

namespace App\Http\Controllers;

use App\Entities\Derive;
use App\Entities\Sale;
use Illuminate\Support\Facades\View;

class SaleController extends Controller
{
    public function index()
    {
        $orders = array();
        foreach (Sale::all() as $sale) {
            $derive = Derive::query()->where('id', '=', $sale->derive_id)->first();
            if (!empty($derive->filters)) {
                $key = $derive->product->brand->name ?? 'Pas de fabricant';

                if (!key_exists($sale->order_name, $orders)) {
                    $orders[$sale->order_name] = array();
                    $orders[$sale->order_name][$key] = array();
                    $orders[$sale->order_name][$key][$derive->product->name][] = $derive->filters->implode('name', ' | ');
                    $orders[$sale->order_name][$key][$derive->product->name][] = (int)$sale->quantity;
                    $orders[$sale->order_name][$key][$derive->product->name][] = (float)$derive->price;
                    $orders[$sale->order_name]['shop_name'] = $sale->shop_name;
                    $orders[$sale->order_name]['created_at'] = $sale->created_at;
                } else {
                    $orders[$sale->order_name][$key][$derive->product->name][] = $derive->filters->implode('name', ' | ');
                    $orders[$sale->order_name][$key][$derive->product->name][] = (int)$sale->quantity;
                    $orders[$sale->order_name][$key][$derive->product->name][] = (float)$derive->price;
                }
            }
        }
        return View::make('sales/index')
            ->withOrders($orders);
    }

}