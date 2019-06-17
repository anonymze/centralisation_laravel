<div class="d-flex justify-content-center">
    <div class="card-box text-center w-50">
        <h5 class="text-primary mb-2">AJOUTER DES DÉCLINAISONS</h5>
        <fieldset class="form-group">
            <label class="label-form" for="name">
                Nom du produit :
            </label>
            <input type="text" class="form-control" value=""
                   placeholder="{{ $product->where('id',$product_id)->value('name') }}" disabled>
        </fieldset>

        <input type="text" class="d-none" name="product_id"
               value="{{ $product_id }}">

        <div id="default-derive-line" style="display:none">
            <div class="row" data-id="%id%">
                <div class="col-4">
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
                                @foreach($filters as $filter)
                                    @if($filter->category == "RATE_CBD")
                                        <option value="{{ $filter->id }}">
                                            {{ $filter->name }}
                                        </option>
                                         @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Capacité" data-max-options="1">
                                @foreach($filters as $filter)
                                    @if($filter->category == "CAPACITY")
                                        <option value="{{ $filter->id }}">
                                            {{ $filter->name }}
                                        </option>
                                         @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Couleur" data-max-options="1">
                                @foreach($filters as $filter)
                                    @if($filter->category == "COLOR")
                                        <option value="{{ $filter->id }}">
                                            {{ $filter->name }}
                                        </option>
                                         @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Résistance" data-max-options="1">
                                @foreach($filters as $filter)
                                    @if($filter->category == "RESISTANCE")
                                        <option value="{{ $filter->id }}">
                                            {{ $filter->name }}
                                        </option>
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
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input class="form-control" type="number"
                                   value="price"
                                   min="0"
                                   step="any"
                                   aria-describedby="basic-addon1"
                                   name="derive[%id%][price]"/>
                        </div>
                    </fieldset>
                </div>
                <div class="col-2">
                    <fieldset class="form-group">
                        <label class="label-form font-weight-normal" for="stock">
                            Stock
                        </label>
                        <input class="form-control" type="number"
                               min="0"
                               value="stock"
                               name="derive[%id%][stock]"/>
                    </fieldset>
                </div>
                <div class="col-2">
                    <fieldset class="form-group">
                        <label class="label-form font-weight-normal" for="buffer">
                            Tampon
                        </label>
                        <input class="form-control" type="number"
                               min="0"
                               value="buffer"
                               name="derive[%id%][buffer]"/>
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
            <button type="button" class="btn btn-success btn-sm add_row_inputs" style="padding-top:0.4em"><i
                        class="zmdi zmdi-plus-circle-o"></i></button>
        </div>
        <button class="btn btn-primary btn-sm mt-3" name="save" type="submit">Enregistrer</button>
        <a class="btn btn-secondary btn-sm mt-3" href="{{ route('product.index') }}">Annuler</a>
    </div>
</div>

@section('css')
    @parent
    <link href="{{ url('plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
    <link href="{{ url('plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/x-editable/css/bootstrap-editable.css')}}" type="text/css" rel="stylesheet">
    <link href="{{ url('plugins/bootstrap-select/css/bootstrap-select.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('footer.js')
    @parent
    <script src="{{ url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ url('plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ url('plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{url('plugins/x-editable/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{url('pages/jquery.xeditable.js')}}"></script>
    <script src="{{url('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <script>
            var $wrapper = $('.field-wrapper'); //Input field wrapper
            var lastChild = $wrapper.find('[data-id]').last();
            var id = 0;
            if(lastChild.length > 0) {
                id = lastChild.data('id') + 1;
            }
            //console.log($(wrapper).find('[data-id]:last-child').data('id'));
            var content = $('#default-derive-line').html().replace(/(%id%)/g, id);
            $content = $(content);
            $content.appendTo($wrapper);
            $content.find('.select_picker').selectpicker();
    </script>
@endsection





