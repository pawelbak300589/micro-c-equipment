<?php
/**
 * EllisBrigham Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * EllisBrigham Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class EllisBrigham extends PaginatedWebsiteScraperAbstract
{

    public function __construct()
    {
        $this->withJS = true;
        $this->collections = config('collections.websites.EllisBrigham');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $products = $crawler->filter('div.products ol.products.list li')->each(function ($field)
                {
                    $productsData['name'] = $field->filter('div.product-item-details strong a')->text();
                    $productsData['url'] = $field->filter('div.product-item-details strong a')->attr('href');

                    if ($field->filter('div.price-box span.special-price span.price-wrapper span.price')->count())
                    {
                        $productsData['prices'][] = $field->filter('div.price-box span.special-price span.price-final_price span.price-wrapper span.price')->text();
                        $productsData['prices'][] = $field->filter('div.price-box span.special-price span.old-price span.price-wrapper span.price')->text();
                    }
                    else
                    {
                        $productsData['prices'][] = $field->filter('div.price-box span.price-final_price span.price-wrapper span.price')->text();
                    }
                    $isSale = $field->filter('div.special-offer-label-product')->count() !== 0;
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

        return $data ?? [];
    }

    public function updatePagesNumber()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            $paginator = $this->crawlers[$collectionIndex][1]->filter('div.pages ul.items li');
            $this->pages[$collectionIndex] = $paginator->count() ? ($paginator->count() - 2) : 1;
        }
    }

    /**
     * TODO: maybe we can use some cache here to speed up scraping process (https://laravel.com/docs/6.x/cache) - set crawlers to cache so doesnt need to set it up every time you run scrape:gears - set cache for a week, because website can change after a week.
     */
    public function setCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            for ($pageNum = 1; $pageNum <= $this->pages[$collectionIndex]; $pageNum++)
            {
                $this->crawlers[$collectionIndex][$pageNum] = $this->client->request('GET', $collectionUrl . '?esp_pg=' . $pageNum);
            }
        }
    }
}
