<?php

namespace App\Interfaces;

interface DevisionInterface extends BaseInterface{
    public function getAllDevision();
    public function getWithFilters(array $filters, int $perPage);
}