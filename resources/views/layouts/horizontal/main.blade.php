<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app_name', 'Management stock global') }} - @yield('title', 'index')</title>

    @section('css')
        <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/style.css') }}" rel="stylesheet">
        <link href="{{ url('css/my_style.css') }}" rel="stylesheet">
        <link href="{{ url('plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('plugins/bootstrap-select/css/bootstrap-select.css')}}" type="text/css" rel="stylesheet">
        <link href="{{ url('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    @show

    @section('header.js')
        <script src="{{  url('js/modernizr.min.js')  }}"></script>
    @show
</head>
<body>
@section('navbar')
    @include('layouts.horizontal.partials.navbar')
@show

<div class="wrapper">
    <div class="container mt-3">
        @yield('content.main')
    </div>
</div>

@section('footer')
@show

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/jquery.serialize-object.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<div class="mb-2">
    @include('flash_messages/flash_message')
</div>

@section('footer.js')
    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.core.js') }}"></script>
    <script src="{{ asset('js/jquery.app.js') }}?v=1"></script>
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('plugins/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{ url('plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ url('plugins/datatables/jszip.min.js')}}"></script>
    <script src="{{ url('plugins/datatables/pdfmake.min.js')}}"></script>
    <script src="{{ url('plugins/datatables/vfs_fonts.js')}}"></script>
    <script src="{{ url('plugins/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{ url('plugins/datatables/buttons.print.min.js')}}"></script>
    <script src="{{ url('plugins/datatables/dataTables.keyTable.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.2/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        // On évite l'erreur 419 dans la requete ajax en précisant tout le temps le token qui vient du meta token en haut
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // on utilise datable pour avoir un jolie tableau
            $('.data_table_simple').DataTable({
                buttons: ['copy', 'excel'],
                dom: "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                pageLength:
                        @if(Request::is('sale'))
                            100,
                @else
                50,
                @endif
                        @if(Request::is('brand'))
                aoColumnDefs: [
                    {
                        "bSortable": false, "aTargets": [0, 2]
                    }
                ],
                @endif
            });

            var $wrapper = $('.field-wrapper'); //Input field wrapper

            //Once add button is clicked
            $('.add_row_inputs').click(function () {
                var lastChild = $wrapper.find('[data-id]').last();
                var id = 0;
                if (lastChild.length > 0) {
                    id = lastChild.data('id') + 1;
                }
                //console.log($(wrapper).find('[data-id]:last-child').data('id'));
                var content = $('#default-derive-line').html().replace(/(%id%)/g, id);
                $content = $(content);
                $content.appendTo($wrapper);
                $content.find('.select_picker').selectpicker();
                //$wrapper.append(content); //Add field html
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

            //Once remove button is clicked
            $wrapper.on('click', '.delete_row_inputs', function (e) {
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
            });
        });
    </script>
@show

</body>
</html>
