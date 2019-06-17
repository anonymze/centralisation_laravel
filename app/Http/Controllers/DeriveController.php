<?php

namespace App\Http\Controllers;

use App\Entities\Derive;
use App\Entities\Filter;
use App\Entities\Product;
use App\Jobs\Derive\CreateDerive;
use App\Jobs\Derive\DeleteDerive;
use App\Jobs\Derive\UpdateDerive;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DeriveController extends Controller
{
    public function index()
    {
        return View::make('derives.index')
            ->with(['products' => Product::with('brand')->get()]);
    }

    public function show($product_id)
    {
        $clean_filters = FilterController::order_filters();
        return View::make('derives.create')
            ->with("product_id", $product_id)
            ->withProducts(Product::all())
            ->withDerives(Derive::all())
            ->withFilters(Filter::all())
            ->with('clean_filters', $clean_filters);
    }

    public function lowStock()
    {
        return View::make('derives.index')
            ->with(['products' => Product::with('brand')->get()]);
    }

    public function store(Request $request, Product $product)
    {
        $this->dispatchNow(new CreateDerive($product, $request->except("_token", "_method", 'save', 'save_another')));

        $notification = array(
            'message' => 'Déclinaison ajoutée',
            'alert-type' => 'success'
        );
        return redirect()->route('product.index')->with($notification);
    }

    // delete route
    public function destroy(Derive $derive)
    {
        $this->dispatchNow(new DeleteDerive($derive));

        $notification = array(
            'message' => 'Déclinaison supprimée',
            'alert-type' => 'success'
        );
        return redirect()->route('derive.index')->with($notification);
    }

    //update route
    public function edit(Derive $derive)
    {
        $product = $derive->product;
        $brand = $product->brand;
        $clean_filters = FilterController::order_filters();
        return View::make('products.edit')
            ->withProduct($product)
            ->withBrand($brand)
            ->withFilters(Filter::all())
            ->withDerive($derive)
            ->with('clean_filters', $clean_filters);
    }

    public function update(Request $request, Derive $derive)
    {

        $notification = array(
            'message' => 'Déclinaison modifiée',
            'alert-type' => 'success'
        );
        if ($request->ajax()) {
            $this->dispatchNow(new UpdateDerive($request->all(), $derive));
            return response()->json(['status' => 'ok']);
        } else {
            $this->dispatchNow(new UpdateDerive($request->except('_method', '_token'), $derive));
            return redirect()->route('derive.index')->with($notification);
        }
    }

    public function datatables(Datatables $datatables, Request $request)
    {
        $query = Derive::with(['product.brand', 'filters']);

        $this->handleDatatablesSearch($query, $request->get('filters', []));

        $datatables = $datatables->eloquent($query->select('derives.*'));

        $datatables->editColumn('id', function (Derive $derive) {
            return '<strong>' . $derive->id . '</strong>';
        });

        $datatables->editColumn('product.name', function (Derive $derive) {
            $products_derives = '<strong>' . $derive->product->name . '</strong>';
            if (!empty($derive->filters->implode('name', ' | '))) {
                $products_derives .= ' | ' . $derive->filters->implode('name', ' | ');
            }
            if (!empty($products_derives)) {
                return $products_derives;
            } else {
                return '';
            }
        });

        $datatables->editColumn('product.brand.name', function (Derive $derive) {
            if ($derive->product->brand) {
                return $derive->product->brand->name;
            } else {
                return '';
            }
        });

        $datatables->editColumn('stock', function (Derive $derive) {
            return '<a href="#" class="stock" data-name="stock" data-value="' . $derive->stock . '" data-pk="' . $derive->getKey() . '" data-url="' . route('derive.update', ['derive' => $derive]) . '">' . $derive->stock . '</a>';
        });

        $datatables->addColumn('actions', function (Derive $derive) {
            return '<a class="btn btn-sm btn-warning" href="' . route('derive.edit', ['derive_id' => $derive->id]) . '">
                    <i class="zmdi zmdi-edit"></i>
                    </a>' .
                '<form class="d-inline" action="' . route('derive.destroy', ['derive_id' => $derive->id]) . '" method="POST">' . csrf_field() . '
                                                    <input name="_method" type="hidden" value="DELETE">                
                                                    <button class="btn btn-danger btn-sm ml-3">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                </form>';
        });

        $datatables->addColumn('state', function (Derive $derive) {
            if ($derive->stock <= ((int)(($derive->buffer / 2) - ($derive->buffer * 0.1)))) {
                return '<div class="text-center"><span class="badge badge-pill" style="background-color : darkred; padding-top : 5px;">Danger</span></div>';
            } elseif ($derive->stock <= $derive->buffer) {
                return '<div class="text-center"><span class="badge badge-pill" style="background-color : #FF8C00; padding-top : 5px;" >Attention</span ></div>';
            } else {
                return '<div class="text-center"><span class="badge badge-pill badge-success text-center" style="padding-top : 5px;" >Ok</span ></div>';
            }
        });
        return $datatables->rawColumns(['id', 'product.brand.name', 'product.name', 'actions', 'stock', 'state'])->toJson();
    }

    private function handleDatatablesSearch(Builder $query, array $filters = [])
    {
        foreach ((array)$filters as $column => $value) {
            if (Str::is($column, 'filter_rate')) {
                $query->whereHas('filters', function (Builder $query) use ($value) {
                    $query->where(function (Builder $query) use ($value) {
                        foreach ((array)$value as $filter) {
                            $query->orWhere('name', '=', $filter);
                        }
                    });
                });
            }

            if (Str::is($column, 'product_name')) {
                $query->whereHas('product', function (Builder $query) use ($value) {
                    $query->where(function (Builder $query) use ($value) {
                        foreach ((array)$value as $product_name) {
                            $query->orWhere('name', '=', $product_name);
                        }
                    });
                });
            }

            if (Str::is($column, 'brand_name')) {
                $query->whereHas('product.brand', function (Builder $query) use ($value) {
                    $query->where(function (Builder $query) use ($value) {
                        foreach ((array)$value as $brand_name) {
                            $query->orWhere('name', '=', $brand_name);
                        }
                    });
                });
            }

            if (Str::is($column, 'buffer')) {
                $query->where(function () use ($value, $query) {
                    foreach ((array)$value as $buffer) {
                        if ($buffer == 'danger') {
                            $query->orWhereRaw('derives.stock <= ((buffer / 2)-(buffer * 0.1))');
                        } else if ($buffer == "warning") {
                            $query->orWhereRaw('derives.stock <= buffer and derives.stock > ((buffer / 2)-(buffer * 0.1))');
                        } else {
                            $query->orWhereRaw('derives.stock > buffer');
                        }
                    }
                });
            }
        }
        return $query;
    }
}
