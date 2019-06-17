<?php

namespace App\Datatables;

class ProductDatatables extends Datatables
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
                'id' => 'brand.name',
                'name' => 'Nom fabricant',
            ],
            [
                'id' => 'name',
                'name' => 'Nom produit',
            ],
            [
                'id' => 'categories.name',
                'name' => 'Catégorie',
            ],
            [
                'id' => 'derives.stock',
                'name' => 'Déclinaison - stock',
            ],
            [
                'id' => 'actions',
                'name' => 'Actions',
                //'sortable' => false
            ],
        ];
    }

    public function getSearches()
    {

    }
}