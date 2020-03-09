<?php

namespace App\Repositories;

use App\Gear;

class GearRepository
{
    protected $model;

    public function __construct(Gear $model)
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
