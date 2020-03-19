<?php
/**
 * GoOutdoors Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * GoOutdoors Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class GoOutdoors extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.GoOutdoors');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $products = $crawler->filter('div#wrapper div.content div.results div.productlist_grid article.product-item')->each(function ($field)
                {
                    $productsData['brand'] = $field->filter('div.product-info-holder h2 span.brand')->text();
                    $productsData['name'] = $field->filter('div.product-info-holder h2 span')->text();
                    $productsData['url'] = $field->filter('div.product-item-holder a')->attr('href');

                    $isSale = false;
                    if ($field->filter('div.product-info-holder div.price-tab div.price-was span.was-price')->count())
                    {
                        $productsData['prices'][] = $field->filter('div.product-info-holder div.price-tab div.price-now span.special')->text();
                        $productsData['prices'][] = $field->filter('div.product-info-holder div.price-tab div.price-was span.was-price')->text();
                        $isSale = true;
                    }
                    else
                    {
                        $productsData['prices'][] = $field->filter('div.product-info-holder div.price-tab div.price-now span.prd-price')->text();
                    }
                    $productsData['type'] = $this->setPriceType($productsData['prices'], $isSale);
                    $productsData['website_id'] = $this->websiteId;
                    return $productsData;
                });

                for ($i = 0, $iMax = count($products); $i < $iMax; $i++)
                {
                    $data[] = $products[$i];
                }
            }
        }

        return $data;
    }
}
