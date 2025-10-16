<?php

namespace App\Repositories;

use App\Models\Position;
use App\Helpers\QueryFilterHelper;
use App\Interfaces\PositionInterface;

class PositionRepository extends BaseRepository implements PositionInterface
{
    public function __construct(Position $model)
    {
        $this->model = $model;
    }

    public function getAllPosition()
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

    public function update(mixed $id, array $data): mixed
    {
        $position = $this->show($id);
        $position->update($data);

        return $position;
    }
}
