<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\API\CreateRefund;


class RefundController extends Controller
{
    public function refund(Request $request)
    {
        $this->dispatch(new CreateRefund($request->all()));

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => []
        ]);
    }
}













