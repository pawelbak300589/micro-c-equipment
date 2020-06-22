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

    public static function existByName(string $name): bool
    {
        return !empty(Brand::where('name', $name)->first()); // TODO: cache it
    }

    public function create(array $data)
    {
        if (!self::existByName($data['name']) && !BrandNameMappingRepository::existByName($data['name']))
        {
            $brand = $this->model->create($data); // TODO: after creating new - create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
            if ($brand)
            {
                if (array_key_exists('img', $data)) // Add brand img only if $data has 'img' key
                {
                    $brandImagesRepo = new BrandImagesRepository($brand);
                    $brandImagesRepo->create($data['img']);
                }

                $brandNameMapRepo = new BrandNameMappingRepository($brand);
                $brandNameMapRepo->createNameMapping();
                return $brand;
            }
        }
        return false;
    }

    public function update(Brand $brand, array $data)
    {
        if (!self::existByName($data['name']))
        {
            $brand->update($data);
            if ($brand)
            {
                $brandNameMapRepo = new BrandNameMappingRepository($brand);
//                $brandNameMapRepo->refreshNameMapping();  // instead of refreshing (removing and creating new) mappings, lets create new (extend the list of mappings)
                $brandNameMapRepo->createNameMapping();
                return $brand;
            }
        }
        return false;
    }
}
