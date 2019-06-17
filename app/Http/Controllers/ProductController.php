<?php

namespace App\Http\Controllers;

use App\Entities\Brand;
use App\Entities\Category;
use App\Entities\Derive;
use App\Entities\Filter;
use App\Entities\Product;
use App\Jobs\Derive\CreateDerive;
use App\Jobs\Product\CreateProduct;
use App\Jobs\Product\DeleteProduct;
use App\Jobs\Product\UpdateProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return View::make('products.index')
            ->with(['products' => Product::with('brand')->get(), 'brands' => Brand::all(), "derives" => Derive::all()]);
    }

    public function create()
    {
        $clean_filters = FilterController::order_filters();
        $order_categories = CategoryController::order_categories();

        return View::make('products.create')
            ->withBrands(Brand::all())
            ->withFilters(Filter::all())
            ->with('clean_filters', $clean_filters)
            ->with('categories', Category::all())
            ->with('order_categories', $order_categories);
    }

    public function edit(Product $product, Derive $derive)
    {
        $clean_filters = FilterController::order_filters();
        $order_categories = CategoryController::order_categories();

        return View::make('products.edit')
            ->withProduct($product)
            ->withBrands(Brand::all())
            ->withDerive($derive)
            ->withFilters(Filter::all())
            ->with('clean_filters', $clean_filters)
            ->with('categories', Category::all())
            ->with('order_categories', $order_categories);
    }

    public function createMultiple()
    {
        $clean_filters = FilterController::order_filters();
        $order_categories = CategoryController::order_categories();

        return View::make('products.multiple_create')
            ->with('brands', Brand::all())
            ->withFilters(Filter::all())
            ->with('clean_filters', $clean_filters)
            ->with('categories', Category::all())
            ->with('order_categories', $order_categories);
    }

    public function store(Request $request)
    {
        $notification = array(
            'message' => 'Produit créé',
            'alert-type' => 'success'
        );

        if (empty($request->input('name', null))) {
            $notification['message'] = 'Ajouter un nom de produit';
            $notification['alert-type'] = 'error';
            return redirect()->route('product.create')->with($notification);
        }

        $new_product = $this->dispatchNow(new CreateProduct($request->except('_method', '_token', 'save', 'save_another', 'derive')));

        if ($request->has('derive') && count($request->derive) > 1) {
            $this->dispatchNow(new CreateDerive($new_product, $request->all()));
        }

        if ($request->has('save_another')) {
            return redirect()->back()->with($notification);
        } else {
            return redirect()->route('product.index')->with($notification);
        }
    }

    public function storeMultiple(Request $request)
    {
        $multiple_products = Arr::get($request->all(), 'multiple_products');
        $products = explode("\r\n", $multiple_products);

        if ($request->has('brand_id')) {
            $attributes_product['brand_id'] = $request->brand_id;
        }

        foreach ((array)$products as $product) {
            if (!empty($product)) {
                $attributes_product['name'] = $product;
                if ($request->has('product') && !empty($request['product']['categories'])) {
                    $attributes_product['product']['categories'] = $request['product']['categories'];
                }
                $new_product = $this->dispatchNow(new CreateProduct($attributes_product));
                if ($request->has('derive')) {
                    $this->dispatchNow(new CreateDerive($new_product, $request->all()));
                }
            }
        }

        $notification = array(
            'message' => 'Lot créé',
            'alert-type' => 'success'
        );

        if ($request->has('save_another')) {
            return redirect()->back()->with($notification);
        } else {
            return redirect()->route('product.index')->with($notification);
        }
    }

    public function update(Request $request, Product $product)
    {
        $this->dispatchNow(new UpdateProduct($product, $request->except("_token", "_method")));

        $notification = array(
            'message' => 'Produit modifié',
            'alert-type' => 'success'
        );

        return redirect()->route('product.index')->with($notification);
    }

    public function destroy(Product $product)
    {
        $this->dispatchNow(new DeleteProduct($product));

        $notification = array(
            'message' => 'Produit supprimé',
            'alert-type' => 'success'
        );
        return redirect()->route('product.index')->with($notification);
    }

    public function datatables(Datatables $datatables)
    {
        $query = Product::with(['derives', 'brand', 'categories']);

        $datatables = $datatables->eloquent($query->select('products.*'));

        $datatables->editColumn('brand.name', function (Product $product) {
            if ($product->brand) {
                $brand_name = '<img style="width : 50px" src="' . $product->brand->image . '"> ';
                $brand_name .= $product->brand->name;
                return $brand_name;
            } else {
                return '';
            }
        });

        $datatables->editColumn('name', function (Product $product) {
            $product_name = '<img style="width : 50px" src="' . $product->image . '">';
            $product_name .= '<strong> ' . $product->name . '</strong>';
            if (!empty($product_name)) {
                return $product_name;
            } else {
                return '';
            }
        });

        $datatables->editColumn('derives.stock', function (Product $product) {
            $products_derives = '';

            foreach ($product->derives as $key => $derive) {
                $products_derives .= '<span class="text-muted">' . $derive->filters->implode('name', ' | ') . '</span>';
                $products_derives .= ' - <strong>' . $derive->stock . '</strong>';
                $products_derives .= '<br>';
            }

            if (!empty($products_derives)) {
                return $products_derives;
            } else {
                return '';
            }
        });

        $datatables->editColumn('categories.name', function (Product $product) {
            if ($product->categories->implode('category', '') == "OIL") {
                $category = '<strong>Huile</strong>';
            } else if ($product->categories->implode('category', '') == "E-LIQUID") {
                $category = '<strong>E-liquide</strong>';
            } else if ($product->categories->implode('category', '') == "HARDWARE") {
                $category = '<strong>Hardware</strong>';
            } else if ($product->categories->implode('category', '') == "OTHER") {
                $category = '<strong>Autre</strong>';
            }
            if (!empty($category)) {
                $category .= ' ' . $product->categories->implode('name', '');
                return $category;
            } else {
                return '';
            }
        });

        $datatables->addColumn('state', function (Product $product) {
            foreach ($product->derives as $derive) {
                if ($product->id == $derive->product_id) {
                    if ($derive->stock <= ((int)(($derive->buffer / 2) - ($derive->buffer * 0.1)))) {
                        $badge_danger = true;
                    } elseif ($derive->stock <= $derive->buffer) {
                        $badge_warning = true;
                    }
                }
            }
            if (!empty($badge_danger) && $badge_danger) {
                $state = '<span class="badge badge-pill"
                                          style="background-color : darkred; padding-top : 5px;">Danger</span>';
                //$badge_danger = false;
                //$badge_warning = false;
            } elseif (!empty($badge_warning) && $badge_warning) {
                $state = '<span class="badge badge-pill"
                                          style="background-color : #FF8C00; padding-top : 5px;">Attention</span>';
                //$badge_warning = false;
                //$badge_danger = false;
            } else {
                $state = '<span class="badge badge-pill badge-success"
                                          style = "padding-top : 5px;" >Ok</span >';
            }
            if (!empty($state)) {
                return $state;
            } else {
                return '';
            }
        });

        $datatables->addColumn('actions', function (Product $product) {
            return '<a class="btn btn-primary btn-sm" href="' . route('derive.show', ['product_id' => $product->id]) . '">
        <i class="zmdi zmdi-collection-plus"></i></a>'
                . '<a class="btn btn-warning btn-sm"
                                       href="' . route('product.edit', ["product_id" => $product->id]) . '"><i
                                                class="zmdi zmdi-edit"></i></a>'
                . '<form class="d-inline"
                                      action="' . route('product.destroy', ['product_id' => $product->id]) . '"
                                      method="POST">' . csrf_field() . ' 
                                    <input name="_method" type="hidden" value="DELETE">                                                              
                                    <button class="btn btn-danger btn-sm ml-3">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </form>';
        });

        return $datatables->rawColumns(['brand.name', 'name', 'derives.stock', 'actions', 'categories.name', 'state'])->toJson();
    }
}

