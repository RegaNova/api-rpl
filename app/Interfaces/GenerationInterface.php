<?php

namespace App\Interfaces;

use App\Interfaces\BaseInterface;

interface GenerationInterface extends BaseInterface{
    public function getAllGeneration();
    public function getWithFilters(array $filters,int $perPage);
}