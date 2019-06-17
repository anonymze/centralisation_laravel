<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title d-inline-block">Liste des fabricants</h4>
                <a class="btn btn-primary btn-sm float-right" href="{{ route('brand.create') }}">Créer un
                    fabricant</a>
                <div class="clearfix mt-2"></div>
                <table class="table table-striped data_table_simple no-footer"
                       cellspacing="0">
                    <thead class="">
                    <tr class="">
                        <th class="font-weight-normal">Image fabricant</th>
                        <th class="font-weight-normal">Nom fabricant</th>
                        <th class="font-weight-normal">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="">
                    @foreach ($brands as $brand)
                        <tr>
                            <td class="align-middle p-1"><img width="50px" src="{{ asset($brand->image) }}"
                                                              alt="add_image_to_product">
                            </td>
                            <td class="align-middle font-weight-bold">{{ $brand->name }}</td>
                            <td class="align-middle">
                                <a class="btn btn-warning btn-sm"
                                   href="{{ route('brand.edit',["brand_id"=> $brand->id]) }}"><i
                                            class="zmdi zmdi-edit"></i></a>
                                <form class="d-inline"
                                      action="{{ route('brand.show', ["brand_id"=> $brand->id]) }}"
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





