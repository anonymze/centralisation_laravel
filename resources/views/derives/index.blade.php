@extends('layouts.horizontal.main')

@section('css')
    @parent
    <link href="{{ url('plugins/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
    <link href="{{ url('plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content.main')
    <?php
    $columns = (new \App\Entities\Derive())->datatables()->getColumns();
    ?>
    @include('datatables.filters', ['entity' => \App\Entities\Derive::class, 'columnSize' => 3])

    <table id="datatable-filter" class="table table-striped table-bordered" style="width : 100%">
        <thead>
        <tr>
            @foreach($columns as $column)
                <th>{{ $column['name'] }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection

@section('footer.js')
    @parent
    <script src="{{ url('plugins/moment/moment.js') }}"></script>
    <script src="{{ url('plugins/x-editable/js/bootstrap-editable.js') }}"></script>
    <script src="{{ url('plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{ url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        function _blade(_) {
            return _;
        }

        $(document).ready(function () {
            var datatablesFilters = _blade({{{ (new \App\Entities\Derive())->datatables()->getJavascriptWrapperName() }}});
            datatablesFilters.on('changed', function () {
                table.draw();
            });

            table = $('#datatable-filter').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: "{!! route('derives.datatables') !!}",
                    data: function (d) {
                        var filters = {filters: datatablesFilters.get()};
                        filters.filters.search = d.search.value;
                        if (history.pushState) {
                            window.history.replaceState(filters, document.title, document.location.origin + document.location.pathname + "?" + $.param(filters));
                        }

                        return $.extend({}, d, filters);
                    }
                },
                "aoColumnDefs": [
                    {"bSortable": false, "aTargets": [0, 6]}
                ],
                "columns": [
                        @foreach($columns as $column)
                    {
                        data: '{{ $column['id'] }}',
                        name: '{{ $column['id'] }}',
                        {{-- sortable: '{{ $column['id'] ? true : false }}', --}}
                    },
                    @endforeach
                    /* {data: 'product.name'},
                    {data: 'stock'},
                    {data: 'buffer'},
                    {data: 'actions'}, */
                ],
                @if (Request::is('derive/low-stock'))
                order: [[4, 'asc']],
                @else
                order: [[3, 'asc']],
                @endif
                pageLength: 100,
                language: {
                    url: "{!! asset('plugins/datatables/languages/french.json') !!}"
                },
                dom: "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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

            $('.datatables-filters-derive').multiSelect(
                {
                    keepOrder: true,
                    selectableHeader: "<div class='custom-header bg-dark text-light text-center'>Paramètres</div>",
                    selectionHeader: "<div class='custom-header bg-success text-center text-light'>Recherche</div>",
                },
            );

            table.on('draw.dt', function (e) {
                var $target = $(e.target);

                $target.find('.stock').editable({
                    mode: 'inline',
                    type: 'number',
                    step: '1.00',
                    min: '0.00',
                    max: '9999',
                    pk: $(this).data('pk'),
                    url: $(this).data('url'),
                    name: $(this).data('name'),
                    ajaxOptions: {
                        type: 'put'
                    },
                });

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
        });
    </script>
@endsection