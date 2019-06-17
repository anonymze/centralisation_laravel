<?php

namespace App\Http\Controllers\API;

use App\Entities\Derive;
use App\Http\Controllers\Controller;
use App\Jobs\API\UpdateStockPrestashop;
use Illuminate\Http\Request;


class CheckIdExistsController extends Controller
{
    public function checkId(Request $request)
    {
        if (Derive::query()->find($request->all()['derive_id'])) {
            $stock_gestion = Derive::query()->where('id', $request->all()['derive_id'])->value('stock');
            $this->dispatch(new UpdateStockPrestashop($request->all()['derive_id'], $stock_gestion, $request->all()['shop_name']));
            $data_return = array('stock' => $stock_gestion, 'derive_id' => $request->all()['derive_id']);
        } else {
            Log::Create([
                'state' => true,
                'error' => true,
                'shop_name' => $request->all()['shop_name'],
                'derive_id' => $request->all()['derive_id'],
                'message' => 'Le derive ID n\'a pas été trouvé sur le gestion'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Retour du stock gestion pour mettre à jour le prestashop',
            'data' => (!empty($data_return) ? $data_return : [])
        ]);
    }
}
