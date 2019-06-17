<?php

namespace App\Jobs\Category;
use App\Entities\Category;

Class CreateCategory
{
    private $attributes;

    function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    function handle()
    {
        foreach ($this->attributes['categories'] as $clean_category) {
            if(!empty($clean_category)) {
                Category::create(['name' => $clean_category, 'category' => $this->attributes['category']]);
            }
        }
    }
}





