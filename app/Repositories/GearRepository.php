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

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first());
    }

    public function create(array $data)
    {
        if (!$this->existByName($data['name']))
        {
            return $this->model->create($data);
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

        return [0, $data['name']];
    }

}
