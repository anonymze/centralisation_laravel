<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Jobs\Category\CreateCategory;
use App\Jobs\Category\DeleteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        if (empty($request->multiple_categories)) {
            $notification = array(
                'message' => 'Ajouter des catégories',
                'alert-type' => 'error'
            );
            return redirect()->route('filter.index')->with($notification);
        }

        $attributes_category = $this->clean_categories($request->all());

       if(!$attributes_category){
           $notification = array(
               'message' => 'Catégorie déjà existante',
               'alert-type' => 'error'
           );
           return redirect()->back()->with($notification);
       }
        $this->dispatchNow(new CreateCategory($attributes_category));

        $notification = array(
            'message' => 'Catégorie ajoutée',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function show_all()
    {
        return View::make('filters/edit')->with('categories', Category::all());
    }

    public function destroy(Category $category)
    {
        $notification = array(
            'message' => 'Catégorie supprimé',
            'alert-type' => 'success'
        );
        $this->dispatchNow(new DeleteCategory($category));
        return redirect()->back()->with($notification);
    }

    public function clean_categories(array $request)
    {
        $categories = explode("\r\n", $request['multiple_categories']);

        if ($request['category'] == "OIL") {
            $categories = array_map(function ($category) {
                $category_replace = preg_replace('~[\\\\/:*?";<>|]~', '', $category);
                $category_replace = str_replace('%', '', $category_replace);
                $category_replace = preg_replace('/\s+/', '', $category_replace);
                $category_replace .= '%';
                return $category_replace;
            }, $categories);
        }

        $clean_categories = array_unique($categories);

        foreach ($clean_categories as $key => $clean_category) {
            if (Category::query()->where('name', '=', $clean_category)->first()) {
                unset($clean_categories[$key]);
            } else if (empty($clean_category)) {
                unset($clean_categories[$key]);
            } else if ($request['category'] == "OIL") {
                if (!preg_match('/[0-9]/', $clean_category)) {
                    unset($clean_categories[$key]);
                }
            }
        }

        if (empty($clean_categories)) {
            return false;
        }

        $format_categories = ['categories' => $clean_categories];
        return array_merge($format_categories, Arr::except($request, ['_token', 'multiple_categories']));
    }

    public static function order_categories()
    {
        $categories = array();
        foreach (Category::all() as $category) {
            if ($category->category == 'OIL') {
                $categories[] = $category->name;
            }
        }

        $categories = array_map(function ($category) {
            $category_replace = str_replace('%', '', $category);
            return $category_replace;
        }, $categories);

        asort($categories);
        $ordered_categories = array();
        foreach ($categories as $category) {
            $ordered_categories[] = $category . '%';
        }
        $categories_with_id = array();
        foreach($ordered_categories as $category){
            $category_id = Category::query()->where('name', '=', $category)->value('id');
            $categories_with_id[$category] = $category_id;
        }
        return $categories_with_id;
    }
}
