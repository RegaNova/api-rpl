<?php

namespace App\Interfaces;

interface StudentInterface extends BaseInterface
{
    public function getAllStudent();
    public function getWithFilters(array $filters, int $perPage);
}
