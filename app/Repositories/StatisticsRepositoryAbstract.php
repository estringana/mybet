<?php

namespace App\Repositories;

use App\Models\Championship;

abstract class StatisticsRepositoryAbstract
{
    protected $championship;

    public function __construct(Championship $championship)
    {
        $this->championship = $championship;
    }

    protected function championship()
    {
        return $this->championship;
    }

    protected function numberOfCoupons()
    {
           return $this->championship->coupons()->count();
    }
}