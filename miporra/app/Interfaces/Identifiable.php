<?php

namespace App\Interfaces;

interface Identifiable{
    const NO_IDENTIFICATION = 0;

    public function getIdentification();
}
