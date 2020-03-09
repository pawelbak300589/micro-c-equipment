<?php

namespace App\Repositories;

use App\Brand;

class BrandRepository
{
    protected $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first());
    }

    public function existByWebsiteUrl(string $website)
    {
        return !empty($this->model->where('website', $website)->first());
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
