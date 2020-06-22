<?php

namespace App\Repositories;

use App\Brand;
use App\BrandUrls;

class BrandUrlsRepository
{
    protected $brand;
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
        $this->model = new BrandUrls;
    }

    public static function exist(int $urlId): bool
    {
        return !empty(BrandUrls::findOrFail($urlId));
    }

    public function existByUrl(string $src)
    {
        return !empty($this->model->where('brand_id', $this->brand->id)->where('url', $src)->first());
    }

    public function hasUrls()
    {
        return !empty($this->model->where('brand_id', $this->brand->id)->first());
    }

    public function create($websiteId, $url)
    {
        if (!$this->existByUrl($url))
        {
            return $this->model->create([
                'website_id' => $websiteId,
                'brand_id' => $this->brand->id,
                'url' => $url,
                'main' => !$this->hasUrls() ? 1 : 0,
            ]);
        }
        return false;
    }

    public function setAsMainUrl($urlId)
    {
        $urls = $this->model->where('brand_id', $this->brand->id)->get();
        $mainUrl = [];

        foreach ($urls as $url)
        {
            if ($url->id == $urlId)
            {
                $url->update(['main' => 1]);
                $mainUrl = $url;
            }
            else
            {
                $url->update(['main' => 0]);
            }
        }

        return $mainUrl;
    }
}
