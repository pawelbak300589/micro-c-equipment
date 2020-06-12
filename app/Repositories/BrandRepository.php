<?php

namespace App\Repositories;

use App\Brand;
use App\BrandImages;
use App\BrandNameMapping;

class BrandRepository
{
    protected $model;
    protected $modelNameMapRepo;
    protected $modelImagesRepo;

    public function __construct(Brand $model)
    {
        $this->model = $model;
        $this->modelNameMapRepo = new BrandNameMappingRepository(new BrandNameMapping());
        $this->modelImagesRepo = new BrandImagesRepository(new BrandImages());
    }

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first()); // TODO: cache it
    }

    public function create(array $data)
    {
        if (!$this->existByName($data['name']) && !$this->modelNameMapRepo->existByName($data['name']))
        {
            $brand = $this->model->create($data); // TODO: after creating new - create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
            if ($brand)
            {
                if(array_key_exists('img', $data)) // Add brand img only if $data has 'img' key
                {
                    $this->modelImagesRepo->create($brand, $data['img']);
                }

                $this->modelNameMapRepo->createNameMapping($brand);
                return $brand;
            }
        }
        return false;
    }

    public function update(Brand $brand, array $data)
    {
        if (!$this->existByName($data['name']))
        {
            $brand->update($data);
            if ($brand)
            {
//                $this->modelNameMapRepo->refreshNameMapping($brand);  // instead of refreshing (removing and creating new) mappings, lets create new (extend the list of mappings)
                $this->modelNameMapRepo->createNameMapping($brand);
                return $brand;
            }
        }
        return false;
    }

    public function brandImages($brandId, $image)
    {

    }
}
