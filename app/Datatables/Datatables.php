<?php

namespace App\Datatables;

abstract class Datatables
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Return the lower case of the class linked.
     *
     * @return string
     */
    public function getEntityLowerClass()
    {
        return strtolower(class_basename($this->entity));
    }

    /**
     * Return the javascript wrapper name for interacting with the search fields or listen events
     *
     * @return string
     */
    public function getJavascriptWrapperName()
    {
        return 'datatablesFilters' . ucfirst($this->getEntityLowerClass());
    }

    /**
     * Return the columns to be shown on a datatable.
     * @return array
     */
    public function getColumns()
    {
        return [
            [
                'id' => 'id',
                'name' => 'Id',
                'sortable' => true
            ]
        ];
    }

    /**
     * Return the searches performed on the datatable for filtering ajax datas.
     *
     * Availables fields :
     * - id: The object property name
     * - name: The displayed name of the filter
     * - field: The type of the input or a list of values for a select :
     *     - INPUT: Will show a free input type text for the filtering
     *     - BOOL: WIll show a select with 0 and 1 values
     *     - ['A' => 'Option A', 'B' => 'Option B']: Will show a select with keys
     *     as option value and values as option text
     * - value: The default value of the filter
     * - multiple: Multiples values allowed (only for array field)
     *
     * @return array
     */
    public function getSearches()
    {
        return [
            [
                'id' => 'id',
                'name' => 'Numéro',
                'field' => 'INPUT',
                'value' => '0'
            ]
        ];
    }
}