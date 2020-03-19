<?php
/**
 * BananaFingers Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * BananaFingers Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class BananaFingers extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.BananaFingers');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $products = $crawler->filter('div#page-wrapper div.view-content article a')->each(function ($field)
                {
                    if ($field->filter('div.node-product-teaser-list-view__brand')->count())
                    {
                        $productsData['brand'] = $field->filter('div.node-product-teaser-list-view__brand')->text();
                    }
                    $productsData['name'] = $field->filter('div.node-product-teaser-list-view__name')->text();
                    $productsData['url'] = $field->attr('href');

                    $isSale = false;
                    if ($field->filter('div.node-product-teaser-list-view__oos')->count())
                    {
                        $productsData['prices'][] = 'Sold Out';
                    }
                    elseif ($field->filter('div.node-product-teaser-list-view__price__rrp')->count())
                    {
                        $productsData['prices'] = explode(' ', str_replace('From', 'from', $field->filter('div.node-product-teaser-list-view__price__sell-price')->text()));
                        $productsData['prices'][] = $field->filter('div.node-product-teaser-list-view__price__rrp')->text();
                        $isSale = true;
                    }
                    else
                    {
                        if($field->filter('div.node-product-teaser-list-view__price__sell-price')->count())
                        {
                            $productsData['prices'] = explode(' ', str_replace('From', 'from', $field->filter('div.node-product-teaser-list-view__price__sell-price')->text()));
                        }
                        else
                        {
                            $productsData['prices'][] = 'Sold Out';
                        }
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
