<?php

namespace App\Repositories;

use App\Gear;
use App\Price;
use App\Website;

class PriceRepository
{
    protected $model;

    public function __construct(Price $model)
    {
        $this->model = $model;
    }

    public function getAllByGearId(int $gearId)
    {
        return $this->model->where('gear_id', $gearId)->get();
    }

    public function getAllByGearName(string $gearName)
    {
        $gear = Gear::where('name', $gearName)->first();
        return $this->getAllByGearId($gear->id);
    }

    public function getAllByWebsiteId(int $websiteId)
    {
        return $this->model->where('website_id', $websiteId)->get();
    }

    public function getAllByWebsite(string $websiteName)
    {
        $website = Website::where('name', $websiteName)->first();
        return $this->getAllByWebsiteId($website->id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function isChanged(int $websiteId, int $gearId, string $newPrice)
    {
        $lastPrice = $this->model->where('website_id', $websiteId)->where('gear_id', $gearId)->last();
        return $newPrice !== $lastPrice;
    }

    public function convertPricesData(array $data)
    {
        $prices = $this->removeUnnecessaryElements($data['prices']);

        switch ($data['type'])
        {
            case 'normal':
                $price = $prices[0];
                $saleFrom = 0;
                break;
            case 'sale':
                list($price, $saleFrom) = $prices;
                break;
            case 'sold':
            default:
                $price = 0;
                $saleFrom = 0;
        }

        return [
            'website_id' => $data['website_id'] ?? 0,
            'gear_id' => $data['gear_id'] ?? 0,
            'price' => $price,
            'sale_from' => $saleFrom,
            'type' => $data['type']
        ];
    }

    private function removeUnnecessaryElements($prices)
    {
        $pos = array_search('fr1om', $prices, true);
        if ($pos !== false)
        {
            unset($prices[$pos]);
            $prices = array_values($prices);
        }
        foreach ($prices as $index => $price)
        {
            $prices[$index] = str_replace('£', '', $price);
        }
        return $prices;
    }
}
