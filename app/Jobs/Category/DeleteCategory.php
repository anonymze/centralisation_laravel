<?php

namespace App\Jobs\Category;
use App\Entities\Category;

Class DeleteCategory
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function handle()
    {
        $this->category->delete();
    }
}