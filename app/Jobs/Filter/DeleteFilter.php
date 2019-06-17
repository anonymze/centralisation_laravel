<?php

namespace App\Jobs\Filter;
use App\Entities\Filter;

Class DeleteFilter
{
    private $filter;

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    public function handle()
    {
        $this->filter->delete();
    }
}