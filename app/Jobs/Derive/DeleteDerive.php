<?php

namespace App\Jobs\Derive;
use App\Entities\Derive;

Class DeleteDerive
{
    private $derive;

    public function __construct(Derive $derive)
    {
        $this->derive = $derive;
    }

    public function handle(){
            $this->derive->delete();
    }
}