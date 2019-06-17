@extends('layouts.horizontal.main')

@section('content.main')
    <div class="container">
        <div class="row text-center">
            <div class="col-6">
                <form action="{{ route('filter.store') }}" method="POST">
                    @csrf
                    <div class="card-box text-center">
                        <h5 class="mb-2 text-primary">AJOUTER UN LOT DE <u>FILTRES</u> DÉCLINAISONS</h5>
                        <fieldset>
                            <label class="label-form" for="category">
                                Nom du filtre :
                            </label>
                            <select class="form-control" name="category">
                                <option value="RATE_CBD" selected>Taux CBD</option>
                                <option value="CAPACITY">Capacité</option>
                                <option value="COLOR">Couleur</option>
                                <option value="RESISTANCE">Résistance</option>
                            </select>
                        </fieldset>

                        <fieldset class="mt-2">
                            <label class="label-form" for="multiple_filters">
                                Nom(s) filtre(s) :
                                <br>
                                <span class="text-muted" style="font-size: 1em;">Aller à la ligne pour créer un autre filtre</span>
                            </label>
                            <textarea class="form-control" name="multiple_filters" rows="5" cols="46"></textarea>
                        </fieldset>

                        <button class="btn btn-primary btn-sm mt-3" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="card-box text-center">
                        <h5 class="mb-2 text-primary">AJOUTER UN LOT DE <u>CATÉGORIES</u> PRODUITS</h5>
                        <fieldset>
                            <label class="label-form" for="category">
                                Nom de la catégorie :
                            </label>
                            <select class="form-control" name="category">
                                <option value="OIL" selected>Huile</option>
                                <option value="E-LIQUID">E-liquide</option>
                                <option value="HARDWARE">Hardware</option>
                                <option value="OTHER">Autre</option>
                            </select>
                        </fieldset>

                        <fieldset class="mt-2">
                            <label class="label-form" for="multiple_categories">
                                Nom(s) categorie(s) :
                                <br>
                                <span class="text-muted" style="font-size: 1em;">Aller à la ligne pour créer une autre catégorie</span>
                            </label>
                            <textarea class="form-control" name="multiple_categories" rows="5" cols="46"></textarea>
                        </fieldset>
                        <button class="btn btn-primary btn-sm mt-3" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-6">
                <div class="card-box text-center">
                    <h5 class="mb-2 text-info">LISTE DES <u>FILTRES</u> DÉCLINAISONS</h5>
                    <select class="form-control">
                        <option value="" disabled selected>Filtres existants</option>
                        <optgroup label="Taux CBD">
                            @foreach((array)$clean_filters as $key => $filter)
                                @if ($key == 'RATE_CBD')
                                    @foreach($filter as $single_filter => $filter_id)
                                        <option value="">{{ $single_filter }}</option>
                                        <span class="btn btn-sm">test</span>
                                    @endforeach
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Capacité">
                            @foreach((array)$clean_filters as $key => $filter)
                                @if ($key == 'CAPACITY')
                                    @foreach($filter as $single_filter => $filter_id)
                                        <option value="">{{ $single_filter }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Couleur">
                            @foreach($filters as $filter)
                                @if ($filter->category == 'COLOR')
                                    <option value="">{{ $filter->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Résistance">
                            @foreach((array)$clean_filters as $key => $filter)
                                @if ($key == 'RESISTANCE')
                                    @foreach($filter as $single_filter => $filter_id)
                                        <option value="">{{ $single_filter }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                    <a class="btn btn-sm btn-warning text-light mt-2" href="{{ route('filter.show-all') }}">Modifier les filtres</a>
                </div>
            </div>
            <div class="col-6" >
                <div class="card-box text-center">
                    <h5 class="mb-2 text-info">LISTE DES <u>CATEGORIES</u> PRODUITS</h5>
                    <select class="form-control">
                        <option value="" disabled selected>Catégories existantes</option>
                        <optgroup label="Huile">
                            @foreach((array)$order_categories as $category => $category_id)
                                        <option value="{{ $category_id }}">{{ $category }}</option>
                                        <span class="btn btn-sm">test</span>
                            @endforeach
                        </optgroup>
                        <optgroup label="E-liquide">
                            @foreach($categories as $key => $single_category)
                                @if ($single_category->category == 'E-LIQUID')
                                        <option value="">{{ $single_category->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Hardware">
                            @foreach($categories as $key => $single_category)
                                @if ($single_category->category == 'HARDWARE')
                                    <option value="">{{ $single_category->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                        <optgroup label="Autre">
                            @foreach($categories as $key => $single_category)
                                @if ($single_category->category == 'OTHER')
                                    <option value="">{{ $single_category->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                    <a class="btn btn-sm btn-warning text-light mt-2" href="{{ route('category.show-all') }}">Modifier les catégories</a>
                </div>
            </div>
        </div>
    </div>
@endsection





