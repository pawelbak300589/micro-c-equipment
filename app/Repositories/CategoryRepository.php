<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first());
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
