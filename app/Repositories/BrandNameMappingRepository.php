<?php


namespace App\Repositories;


use App\BrandNameMapping;
use Illuminate\Support\Str;

class BrandNameMappingRepository
{
    protected $model;

    public function __construct(BrandNameMapping $model)
    {
        $this->model = $model;
    }

    public function existByName(string $name)
    {
        return !empty($this->model->where('name', $name)->first()); // TODO: cache it
    }

    public function create(array $data)
    {
        if (!$this->existByName($data['name']))
        {
            return $this->model->create($data); // TODO: after creating new create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
        }
        return false;
    }

    public function createNameMapping($brand)
    {
        foreach ($this->generateNameMapping($brand->name) as $mappedName)
        {
            $this->create(['brand_id' => $brand->id, 'name' => $mappedName]); // TODO: after creating new create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
        }
    }

    public function refreshNameMapping($brand)
    {
        $this->removeAllNameMapping($brand);
        $this->createNameMapping($brand);
    }

    public function removeAllNameMapping($brand)
    {
        $brandMappings = $this->model->findByBrandId($brand->id);
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
