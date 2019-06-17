<?php

namespace App\Http\Controllers;

use App\Entities\Derive;
use App\Entities\Log;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $infos_buffers = StockController::getInfosBuffers();
        $infos_sales = StockController::getInfosSales();

        if (array_key_exists('danger', $infos_buffers)) {
            return View::make('dashboard/index')->with('color_stock', ['text' => 'light', 'bg' => 'danger'])->with('infos_buffers', $infos_buffers['danger'])->with('infos_sales', $infos_sales);
        } else if (array_key_exists('warning', $infos_buffers)) {
            return View::make('dashboard/index')->with('color_stock', ['text' => 'light', 'bg' => 'warning'])->with('infos_buffers', $infos_buffers['warning'])->with('infos_sales', $infos_sales);

        } else if (array_key_exists('success', $infos_buffers)) {
            return View::make('dashboard/index')->with('color_stock', ['text' => 'light', 'bg' => 'success'])->with('infos_sales', $infos_sales);
        } else {
            return View::make('dashboard/index')->with('color_stock', ['text' => 'dark', 'bg' => 'white']);
        }
    }
}