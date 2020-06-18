<?php


namespace App\Repositories;


use App\Brand;
use App\BrandNameMapping;
use Illuminate\Support\Str;

class BrandNameMappingRepository
{
    protected $brand;
    protected $model;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
        $this->model = new BrandNameMapping;
    }

    public static function existByName(string $name): bool
    {
        return !empty(BrandNameMapping::where('name', $name)->first());
    }

    public function create(array $data)
    {
        if (!self::existByName($data['name']))
        {
            return $this->model->create($data); // TODO: after creating new create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
        }
        return false;
    }

    public function createNameMapping()
    {
        foreach ($this->generateNameMapping($this->brand->name) as $mappedName)
        {
            $this->create(['brand_id' => $this->brand->id, 'name' => $mappedName]); // TODO: after creating new create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
        }
    }

    public function refreshNameMapping()
    {
        $this->removeAllNameMapping();
        $this->createNameMapping();
    }

    public function removeAllNameMapping()
    {
        $brandMappings = $this->model->where('brand_id', '=', $this->brand->id)->get();
        foreach ($brandMappings as $mapping)
        {
            $mapping->delete();
        }
    }

    /**
     * Generates name mapping from given name.
     * (upper cases, lower cases, no spaces or with spaces etc.)
     *
     * @param string $name Given name
     * @return array List of names mapping
     */
    protected function generateNameMapping(string $name): array
    {
        $specialSigns = [' ', '.', ',', '-', '_', '+', "'", '`'];
        return [
            $name,
            str_replace($specialSigns, '', $name),
            Str::lower($name),
            Str::lower(str_replace($specialSigns, '', $name)),
            Str::upper($name),
            Str::upper(str_replace($specialSigns, '', $name)),
            Str::ucfirst($name),
            Str::ucfirst(str_replace($specialSigns, '', $name)),
            Str::studly($name),
            Str::studly(str_replace($specialSigns, '', $name)),
            Str::ascii($name),
            Str::ascii(str_replace($specialSigns, '', $name)),
            Str::camel($name),
            Str::camel(str_replace($specialSigns, '', $name)),
            Str::snake($name),
            Str::snake(str_replace($specialSigns, '', $name)),
            Str::kebab($name),
            Str::kebab(str_replace($specialSigns, '', $name)),
        ];
    }
}
