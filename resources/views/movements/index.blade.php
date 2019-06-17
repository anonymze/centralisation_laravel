@extends('layouts.horizontal.main')

@section('content.main')
    <div class="row">
        <div class="col-6">
            <h3 class="text-center text-success text-uppercase">Mouvements de stock</h3>
            <table class="table table-striped data_table_simple no-footer"
                   cellspacing="0">
                <thead>
                <tr class="">
                    <th class="font-weight-normal">Date</th>
                    <th class="font-weight-normal">Déclinaison ID</th>
                    <th class="font-weight-normal">Produit</th>
                    <th class="font-weight-normal">Mouvement API</th>
                </tr>
                <tbody>
                @foreach($movements as $movement)
                    <tr>
                        <td class="text-muted">{{ $movement->created_at ?? '' }}</td>
                        <td>{{ $movement->derive_id ?? '' }}</td>
                        <td class="font-weight-bold">{{ (new App\Entities\Product)::query()->where('id', '=', $movement->product_id)->value('name') }}</td>
                        <td class="font-weight-bold">{{ $movement->quantity ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h3 class="text-center text-warning text-uppercase">Infos générales</h3>
            <table class="table table-striped data_table_simple no-footer"
                   cellspacing="0">
                <thead>
                <tr>
                    <th class="font-weight-normal">Date</th>
                    <th class="font-weight-normal">Shop</th>
                    <th class="font-weight-normal">Déclinaison</th>
                    <th class="font-weight-normal">Message</th>
                    <th class="font-weight-normal">Stock API</th>
                    <th class="font-weight-normal">Mouvement Prestashop</th>
                    <th class="font-weight-normal">Stock Prestashop</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td class="text-muted">{{ $log->created_at }}</td>
                    <td class="font-weight-bold">{{ $log->shop_name }}</td>
                    <td>{{ $log->derive_id }}</td>
                    <td class="{{ ($log->error) ? 'text-danger' : 'text-success' }}">{{ $log->message }}</td>
                    <td>{{ $log->stock }}</td>
                    <td class="font-weight-bold">{{ $log->stock_change_prestashop }}</td>
                    <td>{{ $log->stock_prestashop }}</td>
                </tr>
                    @endforeach
                </tbody>
        </div>
    </div>
@endsection





