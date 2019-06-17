<?php

namespace App\Http\Controllers;

use App\Entities\Brand;
use App\Jobs\Brand\CreateBrand;
use App\Jobs\Brand\UpdateBrand;
use App\Jobs\Brand\DeleteBrand;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    public function index()
    {
        return View::make('brands.index')->withBrands(Brand::get());
    }

    public function edit(Brand $brand)
    {
        return View::make('brands.edit')->withBrand($brand)->withBrands(Brand::all());
    }

    public function create()
    {
        return View::make('brands.create')->withBrands(Brand::all());
    }

    public function store(Request $request)
    {
        $notification = array(
            'message' => 'Fabricant créé',
            'alert-type' => 'success'
        );

        if (empty($request->input('name'))) {
            $notification['message'] = 'Entrer un nom de fabricant';
            $notification['alert-type'] = 'error';
            return redirect()->route('brand.index')->with($notification);
        }

        $this->dispatchNow(new CreateBrand($request->except('_token', '_method', 'save', 'save_another')));

        if ($request->has('save_another')) {
            return redirect()->back()->with($notification);
        }
        return redirect()->route('brand.index')->with($notification);
    }

    public function update(Request $request, Brand $brand)
    {
        $this->dispatchNow(new UpdateBrand($brand, $request->except("_token", "_method",'save')));

        $notification = array(
            'message' => 'Fabricant modifié',
            'alert-type' => 'success'
        );

        return redirect()->route('brand.index')->with($notification);
    }

    public function destroy(Brand $brand)
    {
        $this->dispatchNow(new DeleteBrand($brand));

        $notification = array(
            'message' => 'Fabricant supprimé',
            'alert-type' => 'success'
        );
        return redirect()->route('brand.index')->with($notification);
    }

}

