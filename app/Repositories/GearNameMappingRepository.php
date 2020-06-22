<?php

namespace App\Repositories;

use App\Gear;
use App\GearNameMapping;
use Illuminate\Support\Str;

class GearNameMappingRepository
{
    protected $gear;
    protected $model;

    public function __construct(Gear $gear)
    {
        $this->gear = $gear;
        $this->model = new GearNameMapping;
    }

    public static function existByName(string $name): bool
    {
        return !empty(GearNameMapping::where('name', $name)->first()); // TODO: cache it
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
        foreach ($this->generateNameMapping($this->gear->name) as $mappedName)
        {
            $this->create(['gear_id' => $this->gear->id, 'name' => $mappedName]); // TODO: after creating new create cache (or add value to cache key "Retrieve & Store" in docs) https://laravel.com/docs/6.x/cache
        }
    }

    public function refreshNameMapping()
    {
        $this->removeAllNameMapping();
        $this->createNameMapping();
    }

    public function removeAllNameMapping()
    {
        $gearMappings = $this->model->where('gear_id', '=', $this->gear->id)->get();
        foreach ($gearMappings as $mapping)
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
        ];
    }
}
