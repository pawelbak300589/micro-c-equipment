<?php

namespace App\Repositories;

use App\Gear;
use App\GearUrls;

class GearUrlsRepository
{
    protected $gear;
    protected $model;

    public function __construct(Gear $gear)
    {
        $this->gear = $gear;
        $this->model = new GearUrls;
    }

    public static function exist(int $urlId): bool
    {
        return !empty(GearUrls::findOrFail($urlId));
    }

    public function existByUrl(string $src)
    {
        return !empty($this->model->where('gear_id', $this->gear->id)->where('url', $src)->first());
    }

    public function hasUrls()
    {
        return !empty($this->model->where('gear_id', $this->gear->id)->first());
    }

    public function create($websiteId, $url)
    {
        if (!$this->existByUrl($url))
        {
            return $this->model->create([
                'website_id' => $websiteId,
                'gear_id' => $this->gear->id,
                'url' => $url,
                'main' => !$this->hasUrls() ? 1 : 0,
            ]);
        }
        return false;
    }

    public function setAsMainUrl($urlId)
    {
        $urls = $this->model->where('gear_id', $this->gear->id)->get();
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
