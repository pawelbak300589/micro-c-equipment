<?php

namespace App\Repositories;

use App\Brand;
use App\Gear;
use App\Website;

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
        if (!$this->existByName($data['name']))
        {
            return $this->model->create($data);
        }
        return $this->model->where('name', $data['name'])->first();
    }

    public function transformName(array $data)
    {
        $brands = Brand::select(['id', 'name'])->where('website_id', $data['website_id'])->get()->toArray();

        foreach ($brands as $brand)
        {
            if (strpos($data['name'], $brand['name']) !== false)
            {
                return [
                    $brand['id'],
                    trim(str_replace($brand['name'], '', $data['name']))
                ];
            }
        }

        return [0, $data['name']];
    }

}
