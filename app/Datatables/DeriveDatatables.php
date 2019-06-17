<?php

namespace App\Datatables;

use App\Entities\Brand;
use App\Entities\Derive;
use App\Entities\Filter;
use App\Entities\Product;

class DeriveDatatables extends Datatables
{
    public function getColumns()
    {
        return [
            [
                'id' => 'state',
                'name' => 'État',
                //'sortable' => false
            ],
            [
                'id' => 'id',
                'name' => 'Id déclinaison',
            ],
            [
                'id' => 'product.brand.name',
                'name' => 'Nom fabricant',
            ],
            [
                'id' => 'product.name',
                'name' => 'Nom produit',
            ],
            [
                'id' => 'stock',
                'name' => 'Stock',
            ],
            [
                'id' => 'buffer',
                'name' => 'Tampon',
            ],
            [
                'id' => 'actions',
                'name' => 'Actions',
                //'sortable' => false
            ]
        ];
    }

    public function getSearches()
    {
        $brand_name = array();
        foreach (Brand::query()->has('products')->orderBy('name', 'asc')->get() as $brand) {
            $brand_name[$brand->name] = $brand->name;
        }
        $product_name = array();
        foreach (Product::query()->has('derives')->orderBy('name', 'asc')->get() as $product) {
            $product_name[$product->name] = $product->name;
        }

        foreach (Filter::query()->where('category', '=', "RATE_CBD")->get() as $filters) {
            $needle = 'mg';
            $filters_rate[] = array_filter((array)$filters->name, function ($var) use ($needle) {
                return strpos($var, $needle) !== false;
            });
        }

        $rates = array();
        if (!empty($filters_rate)) {
            foreach ($filters_rate as $filter) {
                if (!empty($filter)) {
                    foreach ($filter as $rate) {
                        $rates[$rate] = $rate;
                    }
                }
            }
        }

        $arranged_rates = array();
        foreach ($rates as $key => $rate) {
            preg_match_all('!\d+!', $rate, $number_rate);
            $arranged_rates[$number_rate[0][0]] = $key;
        }
        ksort($arranged_rates);

        $clean_rates = array();
        foreach ($arranged_rates as $arranged_rate) {
           $clean_rates[$arranged_rate] = $arranged_rate;
        }

        return [
            [
                'id' => 'brand_name',
                'name' => 'Fabricants',
                'field' => $brand_name,
                'extra' => [
                    'select2' => true,
                    'multiple' => true
                ]
            ],
            [
                'id' => 'product_name',
                'name' => 'Produits',
                'field' => $product_name,
                'extra' => [
                    'select2' => true,
                    'multiple' => true
                ]
            ],
            [
                'id' => 'filter_rate',
                'name' => 'Dosages',
                'field' => $clean_rates,
                'extra' => [
                    'select2' => true,
                    'multiple' => true
                ]
            ],
            [
                'id' => 'buffer',
                'name' => 'Tampons',
                'field' => ['danger' => 'Faibles stocks',
                    'warning' => 'Moyens stocks',
                    'success' => 'Bons stocks'
                ],
                'extra' => [
                    'select2' => true,
                    'multiple' => true
                ]
            ]
        ];
    }
}