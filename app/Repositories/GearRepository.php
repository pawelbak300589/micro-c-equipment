<?php

namespace App\Repositories;

use App\BrandNameMapping;
use App\Gear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GearRepository
{
    protected $model;

    public function __construct(Gear $model)
    {
        $this->model = $model;
    }

    public static function existByName(string $name)
    {
        return !empty(Gear::where('name', $name)->first()); // TODO: cache it
    }

    public function create(array $data)
    {
        if (!self::existByName($data['name']) && !GearNameMappingRepository::existByName($data['name']))
        {
            $gear = $this->model->create($data); // TODO: after creating new - create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
            if ($gear)
            {
                if (array_key_exists('img', $data)) // Add brand img only if $data has 'img' key
                {
                    $brandImagesRepo = new GearImagesRepository($gear);
                    $brandImagesRepo->create($data['img']);
                }

                $gearNameMapRepo = new GearNameMappingRepository($gear);
                $gearNameMapRepo->createNameMapping();
                return $gear;
            }
        }
        return $this->model->where('name', $data['name'])->first();
    }

    /**
     * @param array $data
     * @return array
     */
    public function transformName(array $data): array
    {
        if (Cache::has('brand_name_mapping'))
        {
            $brandsMap = Cache::get('brand_name_mapping');
        }
        else
        {
            $brandsMap = BrandNameMapping::select(['brand_id', 'name'])->get()->toArray();
            Cache::add('brand_name_mapping', $brandsMap, Carbon::now()->addWeeks(1));
        }

        foreach ($brandsMap as $brandMap)
        {
            if (array_key_exists('brand', $data) && $brandMap['name'] === $data['brand'])
            {
                return [
                    $brandMap['brand_id'],
                    trim($data['name'])
                ];
            }

            if (strpos($data['name'], $brandMap['name'] . ' ') !== false)
            {
                return [
                    $brandMap['brand_id'],
                    trim(Str::replaceFirst($brandMap['name'], '', $data['name']))
                ];
            }
        }

        return [1, $data['name']];
    }

}
