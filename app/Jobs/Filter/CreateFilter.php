<?php

namespace App\Jobs\Filter;

use App\Entities\Filter;

Class CreateFilter
{
    private $attributes;

    function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    function handle()
    {
        foreach ($this->attributes['categories'] as $clean_filter) {
            if(!empty($clean_filter)) {
                Filter::create(['name' => $clean_filter, 'category' => $this->attributes['category']]);
            }
        }
    }

}





