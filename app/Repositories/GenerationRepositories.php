<?php

namespace App\Repositories;

use App\Models\Generation;

class GenerationRepositories extends BaseRepository implements GenerationInterface
{
    public function __construct(Generation $model)
    {
        $this->model = $model;
    }
}