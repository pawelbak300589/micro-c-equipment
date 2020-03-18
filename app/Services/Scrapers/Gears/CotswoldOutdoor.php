<?php
/**
 * CotswoldOutdoor Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * CotswoldOutdoor Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class CotswoldOutdoor extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.CotswoldOutdoor');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $products = $crawler->filter('div.product-lister-react div.as-t-product-grid div.as-t-product-grid__item div.as-m-product-tile a')->each(function ($field)
                {
                    $productsData['url'] = $field->attr('href');
                    $productsData['brand'] = $field->filter('span.as-m-product-tile__brand')->text();
                    $productsData['name'] = $field->filter('span.as-m-product-tile__name')->text();

                    $productsData['prices'][] = str_replace(' ', '', $field->filter('div.as-a-price div.as-a-price__value')->text());
                    if ($field->filter('div.as-a-price div.as-a-price__value span.as-a-text del')->count())
                    {
                        $productsData['prices'][] = str_replace(' ', '', $field->filter('div.as-a-price div.as-a-price__value span.as-a-text del')->text());
                    }
                    $isSale = $field->filter('div.as-m-group div.as-a-tag.as-a-tag--tertiary')->count() !== 0;
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
