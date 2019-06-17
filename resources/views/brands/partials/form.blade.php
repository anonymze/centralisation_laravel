<div class="d-flex justify-content-center">
    <div class="card-box text-center" style="width : 35%;">
        <h5 class="mb-2 {{ (Request::is('brand/create') ? 'text-primary' : 'text-warning') }}">{{ (Request::is('brand/create') ? 'AJOUT D\'UN FABRICANT' : 'MODIFICATION D\'UN FABRICANT') }}</h5>
        @if(!empty($brand->image))
            <img class="img-thumbnail mb-3" width="100px" src="{{ $brand->image }}" alt="current_brand">
        @endif

        <fieldset class="form-group mb-3">
            <label class="label-form"  for="image">Ajouter l'image du fabricant :</label>
            <br>
            <input type="file" name="image">
        </fieldset>

        <fieldset class="form-group">
            <label class="label-form" for="name">
                Nom fabricant :
            </label>
            <span class="text-danger">*</span>
            <input type="text" class="form-control" name="name" value="{{ $brand->name }}"
                   placeholder="Nom du fabricant"
                   required>
        </fieldset>

        <div class="mt-3">
            <button name="save" class="btn {{ (Request::is('brand/create') ? 'btn-primary' : 'btn-warning') }} btn-sm"
                    type="submit">Enregistrer
            </button>
            @if (Request::is('brand/create'))
                <button name="save_another" class="btn btn-success btn-sm" type="submit">Enregistrer et créer</button>
            @endif
            <a class="btn btn-secondary btn-sm" href="{{ route('brand.index') }}">Annuler</a>
        </div>
    </div>
</div>

@section('css')
    @parent
    <link href="{{ url('plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
    <link href="{{ url('plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('footer.js')
    @parent
    <script src="{{ url('plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{ url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ url('plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ url('plugins/jquery-quicksearch/jquery.quicksearch.js')}}"></script>
    <script src="{{url('plugins/autocomplete/jquery.mockjax.js')}}"></script>
    <script src="{{url('plugins/autocomplete/jquery.autocomplete.min.js')}}"></script>
    <script src="{{url('plugins/autocomplete/countries.js')}}"></script>
    <script src="{{url('pages/jquery.autocomplete.init.js')}}"></script>
@endsection