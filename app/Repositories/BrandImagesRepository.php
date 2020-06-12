<?php

namespace App\Repositories;

use App\BrandImages;

class BrandImagesRepository
{
    protected $model;

    public function __construct(BrandImages $model)
    {
        $this->model = $model;
    }

    public function existBySrc(string $src)
    {
        return !empty($this->model->where('src', $src)->first());
    }

    public function existByBrandId($brandId)
    {
        return !empty($this->model->where('brand_id', $brandId)->first());
    }

    public function create($brand, $imageSrc)
    {
        if (!$this->existBySrc($imageSrc))
        {
            return $this->model->create([
                'brand_id' => $brand->id,
                'src' => $imageSrc,
                'alt' => $brand->name,
                'main' => !$this->existByBrandId($brand->id) ? 1 : 0,
            ]);
        }
        return false;
    }
}
