<?php
$columns = (new \App\Entities\Product())->datatables()->getColumns();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title d-inline-block">Liste des produits</h4>
                <a class="btn btn-info btn-sm float-right ml-1" href="{{ route('product.multiple.create') }}">Création
                    par lot</a>
                <a class="btn btn-primary btn-sm float-right" href="{{ route('product.create') }}">Créer un
                    produit</a>
                <div class="clearfix mt-2"></div>
                <table id="products-datatable" class="table table-striped no-footer">
                    <thead class="">
                    <tr>
                        @foreach($columns as $column)
                            <th>{{ $column['name'] }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('footer.js')
    @parent
    <script type="text/javascript">
        //$(document).ready(function() {
             $product_table = $('#products-datatable').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: "{{ route('products.datatables') }}",
                },
                columns: [
                        @foreach($columns as $column)
                    {
                        data: '{{ $column['id'] }}',
                        name: '{{ $column['id'] }}',
                        {{-- sortable: '{{ $column['id'] ? true : false }}', --}}
                    },
                    @endforeach
                ],
                 aoColumnDefs: [
                     {
                         "bSortable": false, "aTargets": [0, 5]
                     }
                 ],
                order: [[2, 'asc']],
                dom: "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                pageLength: 50,
                buttons: [
                    {
                        extend: 'copy',
                        text: "Copier"
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

        $product_table.on('draw.dt', function () {
            $('.btn-danger').click(function (e) {
                e.preventDefault();
                var form = $(this).parents('form');
                swal.fire({
                    title: 'Voulez-vous vraiment supprimer le produit ?',
                    text: 'Le produit va être supprimé',
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    cancelButtonText: 'Annuler',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#696969'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
        //});
    </script>
@endsection









