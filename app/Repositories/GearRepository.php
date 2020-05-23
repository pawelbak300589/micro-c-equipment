<?php

namespace App\Repositories;

use App\BrandNameMapping;
use App\Gear;
use App\GearNameMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GearRepository
{
    protected $model;
    protected $modelNameMapRepo;

    public function __construct(Gear $model)
    {
        $this->model = $model;
        $this->modelNameMapRepo = new GearNameMappingRepository(new GearNameMapping());
    }

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first()); // TODO: cache it
    }

    public function create(array $data)
    {
        if (!$this->existByName($data['name']) && !$this->modelNameMapRepo->existByName($data['name']))
        {
            $gear = $this->model->create($data); // TODO: after creating new - create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
            if ($gear)
            {
                $this->modelNameMapRepo->createNameMapping($gear);
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
