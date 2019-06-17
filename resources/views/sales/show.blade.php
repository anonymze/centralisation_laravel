<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title d-inline-block">Liste des ventes</h4>
                <div class="clearfix mt-2"></div>
                <div class="tab-pane fade show active" id="products" role="tabpanel"
                     aria-labelledby="products-tab">
                    <table class="table table-striped data_table_simple no-footer">
                        <thead>
                        <tr>
                            <th class="font-weight-normal align-middle">Date</th>
                            <th class="font-weight-normal align-middle">Shop - commande</th>
                            <th class="font-weight-normal align-middle">Nom fabricant</th>
                            <th class="font-weight-normal align-middle">Nom produit</th>
                            <th class="font-weight-normal align-middle">Nom déclinaison</th>
                            <th class="font-weight-normal align-middle">Quantité</th>
                            <th class="font-weight-normal align-middle">Prix d'achat HT</th>
                            <th class="font-weight-normal align-middle">Total vente HT</th>
                            <th class="font-weight-normal align-middle">Marge commande</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order_name => $order)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-muted">{{ $order['created_at'] }}</span>
                                </td>
                                <td class="align-middle">
                                    <b>{{ $order['shop_name'] }}</b> | <span class="text-muted">{{ $order_name }}</span>
                                </td>
                                <td class="align-middle">
                                    @foreach($order as $brand_name => $products)
                                        @if (is_array($products))
                                            <span class="text-muted">{{ $brand_name }}</span>
                                            <br>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach($order as $brand_name => $products)
                                        @if (is_array($products))
                                            @foreach($products as $product_name => $product)
                                                <b>{{ $product_name }}</b>
                                                <br>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach($order as $brand_name => $products)
                                        @if (is_array($products))
                                            @foreach($products as $product)
                                                @foreach($product as $derives)
                                                    @if(!is_int($derives) && !is_float($derives))
                                                        <span class="text-muted">{{ $derives }}</span>
                                                        <br>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach($order as $brand_name => $products)
                                        @if (is_array($products))
                                            @foreach($products as $product)
                                                @foreach($product as $derives)
                                                    @if(is_int($derives))
                                                        <span class="text-muted">{{ $derives }}</span>
                                                        <br>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle">
                                    @foreach($order as $brand_name => $products)
                                        @if (is_array($products))
                                            @foreach($products as $product)
                                                @foreach($product as $derives)
                                                    @if(is_float($derives))
                                                        <span class="text-danger">{{ $derives }} €</span>
                                                        <br>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                </td>
                                <td class="align-middle text-success">
                                    v2 en cours
                                </td>
                                <td class="align-middle text-info font-weight-bold">
                                    v2 en cours
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

