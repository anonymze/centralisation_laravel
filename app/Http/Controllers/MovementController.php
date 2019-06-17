<?php

namespace App\Http\Controllers;
use App\Entities\Log;
use App\Entities\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MovementController extends Controller
{
    public function index()
    {
        return View::make('movements.index')
            ->withLogs(Log::all())
            ->withMovements(Movement::all());
    }

    public function update(Request $request, Movement $movement)
    {
        $movement->update(['state' => $request->state]);
    }
}
