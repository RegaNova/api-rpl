<?php

namespace App\Repositories;

use App\Helpers\QueryFilterHelper;
use App\Interfaces\DevisionInterface;
use App\Models\Devision;

class DevisionRepository extends BaseRepository implements DevisionInterface
{
    public function __construct(Devision $model)
    {
        $this->model = $model;
    }

    public function getAllDevision()
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
        $devision = $this->show($id);
        $devision->update($data);

        return $devision;
    }
}
