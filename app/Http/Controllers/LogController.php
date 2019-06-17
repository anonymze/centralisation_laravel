<?php

namespace App\Http\Controllers;

use App\Entities\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function update(Request $request, Log $log)
    {
    $log->update(['state' => $request->state]);
    }



}





