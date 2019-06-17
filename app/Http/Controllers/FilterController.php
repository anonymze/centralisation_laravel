<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\Filter;
use App\Jobs\Filter\CreateFilter;
use App\Jobs\Filter\DeleteFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;

class FilterController extends Controller
{
    public function index()
    {
        $clean_filters = $this->order_filters();
        $order_categories = CategoryController::order_categories();

        return View::make('filters.index')
            ->with('filters', Filter::all())
            ->with('clean_filters', $clean_filters)
            ->with('categories', Category::all())
            ->with('order_categories', $order_categories);
    }

    public function store(Request $request)
    {

        if (empty($request->multiple_filters)) {
            $notification = array(
                'message' => 'Ajouter des filtres',
                'alert-type' => 'error'
            );
            return redirect()->route('filter.index')->with($notification);
        }
        $attributes_filter = $this->clean_filters($request->all());

        if(!$attributes_filter){
            $notification = array(
                'message' => 'Filtre déjà existant',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

       $this->dispatchNow(new CreateFilter($attributes_filter));

        $notification = array(
            'message' => 'Filtre ajouté',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function show_all()
    {
        return View::make('filters/edit')->with('filters', Filter::all());
    }

    public function destroy(Filter $filter)
    {
        $notification = array(
            'message' => 'Filtre supprimé',
            'alert-type' => 'success'
        );
        $this->dispatchNow(new DeleteFilter($filter));
        return redirect()->back()->with($notification);
    }

    public static function order_filters()
    {
        $filters = array();
        foreach (Filter::all() as $filter) {
            if ($filter->category == 'RATE_CBD') {
                $filters['RATE_CBD'][] = $filter->name;
            } else if ($filter->category == 'CAPACITY') {
                $filters['CAPACITY'][] = $filter->name;
            } else if ($filter->category == 'RESISTANCE') {
                $filters['RESISTANCE'][] = $filter->name;
            }
        }

        foreach ((array)$filters as $key => $filter) {
            if ($key == 'RATE_CBD') {
                $arranged_filter = array();
                foreach ((array)$filter as $attributes_filter) {
                    $filter_replace = preg_replace("/[^0-9,.]/", "", $attributes_filter);
                    $arranged_filter[$filter_replace] = $filter_replace;
                }

                ksort($arranged_filter);

                $clean_filters = array();
                foreach ((array)$arranged_filter as $filter_cbd) {
                    $new_key = $filter_cbd . 'mg';
                    $clean_filters[$new_key] = Filter::query()->where('name', '=', $new_key)->value('id');
                }
                $filters['RATE_CBD'] = $clean_filters;
            } else if ($key == 'CAPACITY') {
                $arranged_filter = array();
                foreach ((array)$filter as $attributes_filter) {
                    $filter_replace = preg_replace("/[^0-9,.]/", "", $attributes_filter);
                    $arranged_filter[$filter_replace] = $filter_replace;
                }
                ksort($arranged_filter);
                $clean_filters = array();
                foreach ((array)$arranged_filter as $filter_cbd) {
                    $new_key = $filter_cbd . 'ml';
                    $clean_filters[$new_key] = Filter::query()->where('name', '=', $new_key)->value('id');
                }
                $filters['CAPACITY'] = $clean_filters;
            } else if ($key == 'RESISTANCE') {
                $arranged_filter = array();
                foreach ((array)$filter as $attributes_filter) {
                    $filter_replace = preg_replace("/[^0-9,.]/", "", $attributes_filter);
                    $arranged_filter[$filter_replace] = $filter_replace;
                }
                ksort($arranged_filter);
                $clean_filters = array();
                foreach ((array)$arranged_filter as $filter_cbd) {
                    $new_key = $filter_cbd . 'ohm';
                    $clean_filters[$new_key] = Filter::query()->where('name', '=', $new_key)->value('id');
                }
                $filters['RESISTANCE'] = $clean_filters;
            }
        }
        return $filters;
    }

    public function clean_filters(array $request)
    {
        $multiple_request = Arr::except($request, ['_token', 'category']);
        $filters = explode("\r\n", $multiple_request['multiple_filters']);

        if ($request['category'] == "RATE_CBD") {
            $filters = array_map(function ($filter) {
                $filter_replace = preg_replace('~[\\\\/:*?";<>%|]~', '', $filter);
                $filter_replace = str_replace('mg', '', $filter_replace);
                $filter_replace = preg_replace('/\s+/', '', $filter_replace);
                $filter_replace .= 'mg';
                return $filter_replace;
            }, $filters);
        } else if ($request['category'] == "CAPACITY"){
            $filters = array_map(function ($filter) {
                $filter_replace = preg_replace('~[\\\\/:*?";<>|]%~', '', $filter);
                $filter_replace = str_replace('ml', '', $filter_replace);
                $filter_replace = preg_replace('/\s+/', '', $filter_replace);
                $filter_replace .= 'ml';
                return $filter_replace;
            }, $filters);
        } else if ($request['category'] == "RESISTANCE"){
            $filters = array_map(function ($filter) {
                $filter_replace = preg_replace('~[\\\\/:*?";<>|%]~', '', $filter);
                $filter_replace = str_replace('ohm', '', $filter_replace);
                $filter_replace = preg_replace('/\s+/', '', $filter_replace);
                $filter_replace .= 'ohm';
                return $filter_replace;
            }, $filters);
        }

        $clean_filters = array_unique($filters);

        foreach ($clean_filters as $key => $clean_filter) {
            if (Filter::query()->where('name', '=', $clean_filter)->first()) {
                unset($clean_filters[$key]);
            } else if (empty($clean_filter)) {
                unset($clean_filters[$key]);
            } else if ($request['category'] == "RATE_CBD") {
                if (!preg_match('/[0-9]/', $clean_filter)) {
                    unset($clean_filters[$key]);
                }
            } else if($request['category'] == "CAPACITY"){
                if (!preg_match('/[0-9]/', $clean_filter)) {
                    unset($clean_filters[$key]);
                }
            } else if($request['category'] == "RESISTANCE"){
                if (!preg_match('/[0-9]/', $clean_filter)) {
                    unset($clean_filters[$key]);
                }
            }
        }

        if (empty($clean_filters)) {
            return false;
        }

        $format_filters = ['categories' => $clean_filters];
        return array_merge($format_filters, Arr::except($request, ['_token', 'multiple_filters']));
    }
}
