<?php

namespace App\Repositories;

use App\Gear;
use App\GearImages;

class GearImagesRepository
{
    protected $gear;
    protected $model;

    public function __construct(Gear $gear)
    {
        $this->gear = $gear;
        $this->model = new GearImages;
    }

    public function count(): int
    {
        return GearImages::where('gear_id', '=', $this->gear->id)->count();
    }

    public static function exist(int $imageId): bool
    {
        return !empty(GearImages::findOrFail($imageId));
    }

    public function existBySrc(string $src)
    {
        return !empty($this->model->where('gear_id', $this->gear->id)->where('src', $src)->first());
    }

    public function hasImages()
    {
        return !empty($this->model->where('gear_id', $this->gear->id)->first());
    }

    public function create($imageSrc)
    {
        if (!$this->existBySrc($imageSrc))
        {
            $imageAlt = $this->gear->name . ' image ' . ($this->count() + 1);
            return $this->model->create([
                'gear_id' => $this->gear->id,
                'src' => $imageSrc,
                'alt' => $imageAlt,
                'main' => !$this->hasImages() ? 1 : 0,
            ]);
        }
        return false;
    }

    public function setAsMainImage($imageId)
    {
        $images = $this->model->where('gear_id', $this->gear->id)->get();
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
