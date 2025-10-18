<?php

namespace App\Repositories;

use App\Models\Student;
use App\Helpers\QueryFilterHelper;
use App\Interfaces\StudentInterface;

class StudentRepository extends BaseRepository implements StudentInterface
{
    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getAllStudent()
    {
        return $this->model->with('generation')->get();
    }

    /**
     * Get paginated + filtered data
     */
    public function getWithFilters(array $filters, int $perPage)
    {
        $query = $this->model->with('generation');

        $searchColumns = ['name'];
        QueryFilterHelper::applyFilters($query, $filters, $searchColumns);
        QueryFilterHelper::applySorting($query, $filters);

        return $query->paginate($perPage);
    }

    /**
     * Show single student by id (include generation)
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->with('generation')
            ->findOrFail($id);
    }

    /**
     * Store new student (then load relation)
     */
    public function store(array $data): mixed
    {
        $student = $this->model->query()
            ->create($data);

        return $student->load('generation');
    }

}
