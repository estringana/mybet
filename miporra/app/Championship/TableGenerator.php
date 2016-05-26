<?php

namespace App\Championship;

class TableGenerator
{
    private $championship;

    public function __construct(Championship $championship)
    {
        $this->championship = $championship;
    }

    protected function coupons()
    {
           return $this->championship->coupons();
    }

    


}