<?php

namespace App\Repositories;

use App\Models\Generation;
use App\Helpers\QueryFilterHelper;
use App\Interfaces\GenerationInterface;

class GenerationRepository extends BaseRepository implements GenerationInterface
{
    public function __construct(Generation $model)
    {
        $this->model = $model;
    }

    public function getAllGeneration()
    {
        return $this->model->all();
    }

    public function getWithFilters(array $filters, int $perPage)
    {
        $query = $this->model->newQuery();
        $searchColumns = ['name'];
        QueryFilterHelper::applyFilters($query, $filters, $searchColumns);
        QueryFilterHelper::applySorting($query, $filters);

        return $query->paginate($perPage);
    }  
}
