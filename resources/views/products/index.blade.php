@extends('layouts.horizontal.main')

@section('css')
    @parent
    <link href="{{ url('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content.main')
    @include('products/show')
@endsection

@section('footer.js')
    @parent
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
@endsection



