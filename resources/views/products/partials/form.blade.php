<div class="d-flex justify-content-center">
    <div class="card-box text-center" style="width : 60%;">
        @if (Request::is('product/create'))
            <h5 class="mb-2 text-primary">AJOUTER UN PRODUIT</h5>
        @elseif (Request::is('product/*/edit'))
            <h5 class="mb-2 text-warning">MODIFIER UN PRODUIT</h5>
        @elseif (Request::is('derive/*/edit'))
            <h5 class="mb-2 text-warning">MODIFIER UNE DÉCLINAISON</h5>
        @endif

        @if (!empty($product->image))
            <img class="img-thumbnail" width="100px" src="{{ $product->image }}" alt="current_product">
        @endif

        @if (Request::is('product/create'))
            <fieldset class="form-group mb-3">
                <label class="label-form" for="image">Ajouter l'image du produit : </label>
                <br>
                <input type="file" name="image">
            </fieldset>
        @endif

        <fieldset class="form-group">
            <label class="label-form" for="name">
                Nom fabricant :
            </label>
            @if (Request::is('derive/*/edit'))
                <input type="text" class="form-control" name=""
                       value="@if (!empty($brand->name)) {{ $brand->name }} @endif"
                       placeholder="Nom du fabricant"
                       disabled>
            @else
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
            @endif
        </fieldset>

        <fieldset class="form-group">
            <label class="label-form" for="name">
                Nom produit :
            </label>
            @if (Request::is('derive/*/edit'))
                <input type="text" class="form-control" name="" value="{{ $product->name }}"
                       placeholder="Nom du produit"
                       disabled>
            @else
                <span class="text-danger">*</span>
                <input type="text" class="form-control" name="name" value="{{ $product->name }}"
                       placeholder="Nom du produit"
                       required>
            @endif
        </fieldset>

        @if(Request::is('product/create') || Request::is('product/*/edit'))
            <fieldset class="form-group">
                <label class="label-form" for="name">
                    Nom catégorie :
                </label>
                <select class="form-control selectpicker"
                        multiple
                        data-live-search="true"
                        data-size="10"
                        data-max-options="1"
                        data-dropup-auto="false"
                        name="product[categories]">
                    <option value="">-</option>
                    <optgroup label="Huile"
                              data-max-options="1">
                        @foreach($order_categories as $category => $category_id)
                            <option {{ ($product->categories->implode('id', '') == $category_id) ? 'selected' : '' }} value="{{ $category_id }}">{{ $category }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="E-liquide"
                              data-max-options="1">
                        @foreach($categories as $category)
                            @if($category->category == "E-LIQUID")
                                <option {{ ($product->categories->implode('id', '') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </optgroup>
                    <optgroup label="Hardware"
                              data-max-options="1">
                        @foreach($categories as $category)
                            @if($category->category == "HARDWARE")
                                <option {{ ($product->categories->implode('id', '') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </optgroup>
                    <optgroup label="Autre"
                              data-max-options="1">
                        @foreach($categories as $category)
                            @if($category->category == "OTHER")
                                <option {{ ($product->categories->implode('id', '') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name}}</option>
                            @endif
                        @endforeach
                    </optgroup>
                </select>
            </fieldset>
        @endif

        @if(Request::is('product/*/edit'))
            <?php $derives = App\entities\Derive::query()->where('product_id', '=', $product->id)->get(); ?>
            @if(!empty($derives))
                <?php $i = 0; ?>
                @foreach($derives as $derive)
                    <div class="field_wrapper_product_update">
                        <div class="row">
                            <div class='col-4'>
                                <fieldset class="form-group">
                                    <label class="label-form" for="filter">
                                        Déclinaisons <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control selectpicker"
                                            multiple
                                            data-live-search="true"
                                            data-size="10"
                                            name="derive[{{ $i }}][filters][]">
                                        <optgroup label="Taux CBD"
                                                  data-max-options="1">
                                            @foreach((array)$clean_filters as $key => $filter)
                                                @if ($key == 'RATE_CBD')
                                                    @foreach((array)$filter as $single_filter => $filter_id)
                                                        <option
                                                                @if (!empty($derive->filters))
                                                                @foreach($derive->filters as $filter_derive)
                                                                @if (!empty($filter_derive->name) && $filter_derive->name ==  $single_filter)
                                                                selected
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                                value="{{ $filter_id }}">{{ $single_filter }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Capacité"
                                                  data-max-options="1">
                                            @foreach((array)$clean_filters as $key => $filter)
                                                @if ($key == 'CAPACITY')
                                                    @foreach((array)$filter as $single_filter => $filter_id)

                                                        <option
                                                                @if (!empty($derive->filters))
                                                                @foreach($derive->filters as $filter_derive)
                                                                @if (!empty($filter_derive->name) && $filter_derive->name ==  $single_filter)
                                                                selected
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                                value="{{ $filter_id }}">{{ $single_filter }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Couleur"
                                                  data-max-options="1">
                                            @foreach($filters as $filter)
                                                @if($filter->category == "COLOR")
                                                    <option
                                                            @if (!empty($derive->filters))
                                                            @foreach($derive->filters as $filter_derive)
                                                            @if ($filter_derive->name ==  $filter->name)
                                                            selected
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                            value="{{ $filter->id }}">{{ $filter->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Résistance"
                                                  data-max-options="1">
                                            @foreach((array)$clean_filters as $key => $filter)
                                                @if ($key == 'RESISTANCE')
                                                    @foreach((array)$filter as $single_filter => $filter_id)
                                                        <option
                                                                @if (!empty($derive->filters))
                                                                @foreach($derive->filters as $filter_derive)
                                                                @if (!empty($filter_derive->name) && $filter_derive->name ==  $single_filter)
                                                                selected
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                                value="{{ $filter_id }}">{{ $single_filter }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <fieldset class="form-group">
                                    <label class="label-form" for="stock">
                                        Prix
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon1">€</span>
                                        </div>
                                        <input class="form-control" type="number"
                                               value="{{ $derive->price ?? '' }}"
                                               min="0"
                                               step="any"
                                               aria-describedby="basic-addon1"
                                               name="derive[{{ $i }}][price]"/>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-2">
                                <fieldset class="form-group">
                                    <label class="label-form" for="price">
                                        Stock
                                    </label>
                                    <input class="form-control"
                                           type="number"
                                           value="{{ $derive->stock ?? '' }}"
                                           name="derive[{{ $i }}][stock]"/>
                                </fieldset>
                            </div>
                            <div class="col-3">
                                <fieldset class="form-group">
                                    <label class="label-form" for="buffer">
                                        Tampon
                                    </label>
                                    <input class="form-control"
                                           type="number"
                                           value="{{ $derive->buffer ?? '' }}"
                                           name="derive[{{ $i }}][buffer]"/>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                @endforeach
            @endif
        @endif

        @if(!Request::is('product/*/edit'))
            <div id="default-derive-line"
                 style="{{ (Request::is('derive/*/edit')) ? '' : 'display : none;' }}">
                <div class="row" data-id="%id%">
                    <div class="{{ Request::is('derive/*/edit') ? 'col-5' : 'col-4' }}">
                        <fieldset class="form-group">
                            <label class="label-form" for="filter">
                                Déclinaisons <span class="text-danger">*</span>
                            </label>
                            <select class="form-control {{ (Request::is('derive/*/edit')) ? 'selectpicker' : 'select_picker' }}"
                                    multiple
                                    data-live-search="true"
                                    data-size="10"
                                    name="{{ (Request::is('derive/*/edit')) ? 'derive[0][filters][]' : 'derive[%id%][filters][]'}}">
                                <optgroup label="Taux CBD"
                                          data-max-options="1">
                                    @foreach((array)$clean_filters as $key => $filter)
                                        @if ($key == 'RATE_CBD')
                                            @foreach((array)$filter as $single_filter => $filter_id)
                                                @if(Request::is('derive/*/edit'))
                                                    <option
                                                            @if (!empty($derive->filters))
                                                            @foreach($derive->filters as $filter_derive)
                                                            @if (!empty($filter_derive->name) && $filter_derive->name ==  $single_filter)
                                                            selected
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                            value="{{ $filter_id }}">{{ $single_filter }}
                                                    </option>
                                                @else
                                                    <option value="{{ $filter_id }}">{{ $single_filter }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </optgroup>
                                <optgroup label="Capacité"
                                          data-max-options="1">
                                    @foreach((array)$clean_filters as $key => $filter)
                                        @if ($key == 'CAPACITY')
                                            @foreach((array)$filter as $single_filter => $filter_id)
                                                @if(Request::is('derive/*/edit'))
                                                    <option
                                                            @if (!empty($derive->filters))
                                                            @foreach($derive->filters as $filter_derive)
                                                            @if (!empty($filter_derive->name) && $filter_derive->name ==  $single_filter)
                                                            selected
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                            value="{{ $filter_id }}">{{ $single_filter }}
                                                    </option>
                                                @else
                                                    <option value="{{ $filter_id }}">{{ $single_filter }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </optgroup>
                                <optgroup label="Couleur"
                                          data-max-options="1">
                                    @foreach($filters as $filter)
                                        @if($filter->category == "COLOR")
                                            @if(Request::is('derive/*/edit'))
                                                <option
                                                        @if (!empty($derive->filters))
                                                        @foreach($derive->filters as $filter_derive)
                                                        @if ($filter_derive->name ==  $filter->name)
                                                        selected
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                        value="{{ $filter->id }}">{{ $filter->name }}
                                                </option>
                                            @else
                                                <option value="{{ $filter->id }}">{{ $filter->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </optgroup>
                                <optgroup label="Résistance"
                                          data-max-options="1">
                                    @foreach((array)$clean_filters as $key => $filter)
                                        @if ($key == 'RESISTANCE')
                                            @foreach((array)$filter as $single_filter => $filter_id)
                                                @if(Request::is('derive/*/edit'))
                                                    <option
                                                            @if (!empty($derive->filters))
                                                            @foreach($derive->filters as $filter_derive)
                                                            @if (!empty($filter_derive->name) && $filter_derive->name ==  $single_filter)
                                                            selected
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                            value="{{ $filter_id }}">{{ $single_filter }}
                                                    </option>
                                                @else
                                                    <option value="{{ $filter_id }}">{{ $single_filter }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </optgroup>
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-3">
                        <fieldset class="form-group">
                            <label class="label-form" for="stock">
                                Prix
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                </div>
                                <input class="form-control" type="number"
                                       value="{{ $derive->price ?? '' }}"
                                       min="0"
                                       step="any"
                                       aria-describedby="basic-addon1"
                                       name="{{ (Request::is('derive/*/edit')) ? 'derive[][price]' : 'derive[%id%][price]'}}"/>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-2">
                        <fieldset class="form-group">
                            <label class="label-form" for="price">
                                Stock
                            </label>
                            <input class="form-control"
                                   type="number"
                                   value="{{ $derive->stock ?? '' }}"
                                   name="{{ (Request::is('derive/*/edit')) ? 'derive[][stock]' : 'derive[%id%][stock]'}}"/>
                        </fieldset>
                    </div>
                    <div class="col-2">
                        <fieldset class="form-group">
                            <label class="label-form" for="buffer">
                                Tampon
                            </label>
                            <input class="form-control"
                                   type="number"
                                   value="{{ $derive->buffer ?? '' }}"
                                   name="{{ (Request::is('derive/*/edit')) ? 'derive[][buffer]' : 'derive[%id%][buffer]'}}"/>
                        </fieldset>
                    </div>
                    @if(!Request::is('derive/*/edit'))

                        <div class="col-1 mt-3">
                            <button type="button" class="btn btn-danger btn-sm mt-4 delete_row_inputs"
                                    style="padding-top:0.35em"><i
                                        class="zmdi zmdi-minus-circle-outline"></i></button>
                        </div>
                    @endif
                </div>
            </div>

            @if(!Request::is('derive/*/edit'))
                <div class="field-wrapper">

                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-success btn-sm mt-3 add_row_inputs"
                            style="padding-top:0.3em; padding-bottom: 0.2em">
                        <i class="zmdi zmdi-plus-circle-o"></i></button>
                </div>
            @endif
        @endif

        @if(Request::is('product/create'))
            <input class="btn btn-primary btn-sm mt-3" name="save" type="submit" value="Enregistrer">
            <input class="btn btn-success btn-sm mt-3" name="save_another" type="submit"
                   value="Enregistrer et créer">
            <a class="btn btn-secondary btn-sm mt-3"
               href="{{ (Request::is('product*') ? route('product.index') : route('derive.index')) }}">Annuler</a>
        @else
            <button class="btn btn-warning btn-sm mt-3" type="submit">Enregistrer</button>
            <a class="btn btn-secondary btn-sm mt-3"
               href="{{ (Request::is('product*') ? route('product.index') : route('derive.index')) }}">Annuler</a>
        @endif
    </div>
</div>

@section('css')
    @parent
    <link href="{{ url('plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
    <link href="{{ url('plugins/multiselect/css/multi-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/x-editable/css/bootstrap-editable.css')}}" type="text/css"
          rel="stylesheet">
    <link href="{{ url('plugins/bootstrap-select/css/bootstrap-select.css')}}" type="text/css"
          rel="stylesheet">
@endsection

@section('footer.js')
    @parent
    <script src="{{ url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ url('plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{url('plugins/x-editable/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{url('pages/jquery.xeditable.js')}}"></script>
    <script src="{{ url('plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{url('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <script>
        $(document).ready(function () {
            var lastChild = $wrapper.find('[data-id]').last();
            var id = 0;
            if (lastChild.length > 0) {
                id = lastChild.data('id') + 1;
            }
            //console.log($(wrapper).find('[data-id]:last-child').data('id'));
            $('.field_wrapper_product_update').html().replace(/(%id%)/g, id);
        });
    </script>
@endsection











