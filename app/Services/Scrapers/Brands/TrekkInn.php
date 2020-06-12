<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperAbstract;
use Illuminate\Support\Str;

class TrekkInn extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://www.trekkinn.com/outdoor-mountain/climbing-equipment/11243/f';
        parent::__construct();
    }

    public function getData()
    {
        return $this->crawler->filter('div#parallax div.listado_marcas_familias')->each(function ($node)
        {
            $data = [];
            $websiteNames = $node->filter('li p.listado_txt_marcas a')->each(function ($field)
            {
                return str_replace('Climbing equipment ', '', $field->text());
            });
            $websiteUrls = $node->filter('li p.listado_txt_marcas a')->each(function ($field)
            {
                return $field->attr('href');
            });

            foreach ($websiteNames as $index => $name)
            {
                $data[$index]['name'] = $websiteNames[$index];
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website_id'] = $this->websiteId;
            }

            return $data;
        });
    }

}
