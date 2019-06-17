@extends('layouts.horizontal.main')

@section('content.main')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title d-inline-block">{{ (Request::is('filter/show-all') ? 'Liste des filtres' : 'Liste des catégories') }}</h4>
                    <div class="clearfix mt-2"></div>
                    <table class="table table-striped data_table_simple no-footer">
                        <thead>
                        <tr>
                            <th class="font-weight-normal">{{ (Request::is('filter/show-all') ? 'Filtre' : 'Catégorie') }}</th>
                            <th class="font-weight-normal">{{ (Request::is('filter/show-all') ? 'Nom filtre' : 'Nom catégorie') }}</th>
                            <th class="font-weight-normal">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(Request::is('filter/show-all'))
                            @foreach($filters as $key => $filter)
                                <tr>
                                    <td>
                                        @if($filter->category == "RATE_CBD")
                                            Taux CBD
                                        @elseif($filter->category == "CAPACITY")
                                            Capacité
                                        @elseif($filter->category == "COLOR")
                                            Couleur
                                        @elseif($filter->category == "RESISTANCE")
                                            Résistance
                                        @endif
                                    </td>
                                    <td>{{ $filter->name }}</td>
                                    <td>
                                        <form class="d-inline"
                                              action="{{ route('filter.destroy', ["filter_id"=> $filter->id]) }}"
                                              method="POST">
                                            <input name="_method" type="hidden" value="DELETE">
                                            @csrf
                                            <button class="btn btn-danger btn-sm ml-3">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>
                                        @if($category->category == "OIL")
                                            Huile
                                        @elseif($category->category == "E-LIQUID")
                                            E-liquide
                                        @elseif($category->category == "HARDWARE")
                                            Hardware
                                        @elseif($category->category == "OTHER")
                                            AUtre
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <form class="d-inline"
                                              action="{{ route('category.destroy', ["category_id"=> $category->id]) }}"
                                              method="POST">
                                            <input name="_method" type="hidden" value="DELETE">
                                            @csrf
                                            <button class="btn btn-danger btn-sm ml-3">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection



