<?php
/**
 * Decathlon Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * Decathlon Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class Decathlon extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.Decathlon');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $products = $crawler->filter('div#list-page-wrapper div#products_list ul.thumbnails-list li a')->each(function ($field)
                {
                    $productsData['url'] = $field->attr('href');
                    $productsData['brand'] = $field->filter('div.content-container div.infos-container p.product-brand')->text();
                    $productsData['name'] = $field->filter('div.content-container div.infos-container h3.product-label')->text();

                    $productsData['prices'][] = $field->filter('div.header-container div.sticker-price-container div.price-container div.price')->text();
                    if ($field->filter('div.header-container div.sticker-price-container div.price-container span.old-price.crossed')->text() !== '')
                    {
                        $productsData['prices'][] = $field->filter('div.header-container div.sticker-price-container div.price-container span.old-price.crossed')->text();
                    }
                    $isSale = in_array(
                        'discounted',
                        explode(' ', trim($field->filter('div.header-container div.sticker-price-container div.price-container div.zone-price-selling-price')->attr('class'))),
                        true
                    );
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

//    public function updatePagesNumber()
//    {
//        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
//        {
//            $paginator = $this->crawlers[$collectionIndex][1]->filter('div.container--pagination div.paginate');
//            $this->pages[$collectionIndex] = $paginator->count() ? $this->crawlers[$collectionIndex][1]
//                ->filter('div.container--pagination div.paginate')
//                ->attr('data-paginate-pages') : 1;
//        }
//    }
}
