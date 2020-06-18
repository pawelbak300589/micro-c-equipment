<?php

namespace App\Repositories;

use App\Brand;
use App\BrandImages;

class BrandImagesRepository
{
    protected $brand;
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
        $this->model = new BrandImages;
    }

    public static function exist(int $imageId): bool
    {
        return !empty(BrandImages::findOrFail($imageId));
    }

    public function existBySrc(string $src)
    {
        return !empty($this->model->where('brand_id', $this->brand->id)->where('src', $src)->first());
    }

    public function hasImages()
    {
        return !empty($this->model->where('brand_id', $this->brand->id)->first());
    }

    public function create($imageSrc)
    {
        if (!$this->existBySrc($imageSrc))
        {
            return $this->model->create([
                'brand_id' => $this->brand->id,
                'src' => $imageSrc,
                'alt' => $this->brand->name,
                'main' => !$this->hasImages() ? 1 : 0,
            ]);
        }
        return false;
    }
}
