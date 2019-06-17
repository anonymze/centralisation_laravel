@extends('layouts.horizontal.main')

<div class="wrapper mt-3">
    <div class="container-fluid">
        <form action="{{ route('product.multiple.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="d-flex justify-content-center">
                <div class="card-box text-center" style="width : 30%">
                    <h5 class="mb-2 text-info">AJOUTER UN LOT DE CREATION</h5>

                    <fieldset class="form-group">
                        <label class="label-form" for="brand_id">
                            Nom fabricant :
                        </label>
                        <select name="brand_id" class="form-control select2">
                            @if ($brands)
                                <optgroup label="Fabricants">
                                    <option value="">-</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ (!empty($product->brand->id) && $product->brand->id == $brand->id) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </fieldset>

                    <fieldset>
                        <label class="label-form" for="multiple_products">
                            Nom(s) produit(s) :
                            <span class="text-danger">*</span>
                            <br>
                            <span class="text-muted" style="font-size: 1em;">Aller à la ligne pour créer un autre produit</span>
                        </label>
                        <textarea class="form-control" name="multiple_products" rows="5" cols="46" required></textarea>
                    </fieldset>

                    <fieldset class="form-group">
                        <label class="label-form" for="name">
                            Nom catégorie :
                        </label>
                        <select class="form-control selectpicker"
                                multiple
                                data-live-search="true"
                                data-size="10"
                                data-max-options="1"
                                name="product[categories]">
                            <option id="deselect_picker" value="">-</option>
                            <optgroup label="Huile"
                                      data-max-options="1">
                                @foreach($order_categories as $category => $category_id)
                                    <option value="{{ $category_id }}">{{ $category }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="E-liquide"
                                      data-max-options="1">
                                @foreach($categories as $category)
                                    @if($category->category == "E-LIQUID")
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Hardware"
                                      data-max-options="1">
                                @foreach($categories as $category)
                                    @if($category->category == "HARDWARE")
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Autre"
                                      data-max-options="1">
                                @foreach($categories as $category)
                                    @if($category->category == "OTHER")
                                        <option value="{{ $category->id }}">{{ $category->name}}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                    </fieldset>

                    <div id="default-derive-line" style="display: none;">
                        <div class="row" data-id="%id%">
                            <div class="col-8">
                                <fieldset class="form-group">
                                    <label class="label-form" for="filters">
                                        Déclinaisons <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select_picker"
                                            multiple
                                            data-live-search="true"
                                            data-size="10"
                                            name="derive[%id%][filters][]">
                                        <optgroup label="Taux CBD"
                                                  data-max-options="1">
                                            @foreach((array)$clean_filters as $key => $filter)
                                                @if ($key == 'RATE_CBD')
                                                    @foreach((array)$filter as $single_filter => $filter_id)
                                                        <option value="{{ $filter_id }}">{{ $single_filter }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Capacité" data-max-options="1">
                                            @foreach((array)$clean_filters as $key => $filter)
                                                @if ($key == 'CAPACITY')
                                                    @foreach((array)$filter as $single_filter => $filter_id)
                                                        <option value="{{ $filter_id }}">{{ $single_filter }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Couleur" data-max-options="1">
                                            @foreach($filters as $filter)
                                                @if($filter->category == "COLOR")
                                                    <option value="{{ $filter_id }}">{{ $filter->name }}</option>
                                                     @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Résistance" data-max-options="1">
                                            @foreach((array)$clean_filters as $key => $filter)
                                                @if ($key == 'RESISTANCE')
                                                    @foreach((array)$filter as $single_filter => $filter_id)
                                                        <option value="{{ $filter_id }}">{{ $single_filter }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <fieldset class="form-group">
                                    <label class="label-form font-weight-normal" for="price">
                                        Prix
                                    </label>
                                    <input class="form-control"
                                           type="number"
                                           value=""
                                           min="0"
                                           step="any"
                                           name="derive[%id%][price]"/>
                                </fieldset>

                            </div>
                            <div class="col-1 mt-3">
                                <button type="button" class="btn btn-danger btn-sm mt-4 delete_row_inputs"
                                        style="padding-top:0.35em"><i
                                            class="zmdi zmdi-minus-circle-outline"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="field-wrapper">

                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm mt-3 add_row_inputs"
                                style="padding-top:0.4em">
                            <i class="zmdi zmdi-plus-circle-o"></i></button>
                    </div>

                    <button class="btn btn-info btn-sm mt-3" name="save" type="submit">Enregistrer</button>
                    <button class="btn btn-success btn-sm mt-3" name="save_another" type="submit">Enregistrer et créer
                    </button>
                    <a class="btn btn-secondary btn-sm mt-3"
                       href="{{ (Request::is('product*') ? route('product.index') : route('derive.index')) }}">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>


@section('css')
    @parent
    <link href="{{ url('plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
    <link href="{{ url('plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/bootstrap-select/css/bootstrap-select.css')}}" type="text/css" rel="stylesheet">
@endsection


@section('footer.js')
    @parent
    <script src="{{ url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ url('plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ url('plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{url('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
@endsection


