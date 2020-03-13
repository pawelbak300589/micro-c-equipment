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

    /**
     * Generates name mapping from given name.
     * (upper cases, lower cases, no spaces or with spaces etc.)
     *
     * @param string $name Given name
     * @return array List of names mapping
     */
    protected function generateNameMapping(string $name): array
    {
        return [
            $name,
            str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name),
            Str::lower($name),
            Str::lower(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::upper($name),
            Str::upper(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::ucfirst($name),
            Str::ucfirst(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::studly($name),
            Str::studly(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::ascii($name),
            Str::ascii(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::camel($name),
            Str::camel(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::snake($name),
            Str::snake(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
            Str::kebab($name),
            Str::kebab(str_replace([' ', '.', ',', '-', '_', '+', "'", '`'], '', $name)),
        ];
    }
}
