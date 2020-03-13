<?php

namespace App\Repositories;

use App\Brand;
use App\BrandNameMapping;

class BrandRepository
{
    protected $model;
    protected $modelNameMapRepo;

    public function __construct(Brand $model)
    {
        $this->model = $model;
        $this->modelNameMapRepo = new BrandNameMappingRepository(new BrandNameMapping());
    }

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first());
    }

    public function create(array $data)
    {
        if (!$this->existByName($data['name']) && !$this->mappingExist($data['name']))
        {
            $brand = $this->model->create($data);
            if ($brand)
            {
                $this->modelNameMapRepo->createNameMapping($brand);
                return $brand;
            }
        }
        return false;
    }

    private function mappingExist($name)
    {
        return $this->modelNameMapRepo->existByName($name);
    }
}
