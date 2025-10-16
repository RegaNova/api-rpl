<?php

namespace App\Interfaces;

interface PositionInterface extends BaseInterface{
    public function getAllPosition();
    public function getWithFilters(array $filters, int $perPage);
}