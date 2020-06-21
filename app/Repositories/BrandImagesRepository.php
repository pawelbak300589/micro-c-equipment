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

    public function count(): int
    {
        return BrandImages::where('brand_id', '=', $this->brand->id)->count();
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
            $imageAlt = $this->brand->name . ' logo ' . ($this->count() + 1);
            return $this->model->create([
                'brand_id' => $this->brand->id,
                'src' => $imageSrc,
                'alt' => $imageAlt,
                'main' => !$this->hasImages() ? 1 : 0,
            ]);
        }
        return false;
    }

    public function setAsMainImage($imageId)
    {
        $images = $this->model->where('brand_id', $this->brand->id)->get();
        $mainImage = [];

        foreach ($images as $image)
        {
            if ($image->id == $imageId)
            {
                $image->update(['main' => 1]);
                $mainImage = $image;
            }
            else
            {
                $image->update(['main' => 0]);
            }
        }

        return $mainImage;
    }
}
