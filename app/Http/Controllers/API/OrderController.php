<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\API\CreateSale;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function order(Request $request)
    {
        $return = $this->dispatch(new CreateSale($request->all()));

        return response()->json([
            'status' => (!empty($return['status']) ? $return['status'] : 'success'),
            'message' => (!empty($return['message']) ? $return['message'] : ''),
            'data' => (!empty($return['data']) ? $return['data'] : [])
        ]);
    }
}