<?php

namespace App\Services\Scrapers;

use App\Website;
use Goutte\Client as GoutteClient;
use Symfony\Component\Panther\Client as PantherClient;
use ReflectionClass;
use ReflectionException;

abstract class PaginatedWebsiteScraperAbstract implements WebsiteScraperInterface
{
    protected $websiteId;
    protected $client;
    protected $crawlers;
    protected $collections;
    protected $pages;
    protected $withJS = false;

    public function __construct()
    {
        if ($this->withJS)
        {
            $this->client = PantherClient::createChromeClient(); // https://www.thoughtfulcode.com/php-web-scraping/
        }
        else
        {
            $this->client = new GoutteClient();
        }
        $this->setPreCrawlers();
        $this->updatePagesNumber();
        $this->setCrawlers();
        $this->prepareWebsiteId();
    }

    public function updatePagesNumber()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            $this->pages[$collectionIndex] = 1;
        }
    }

    public function setCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            for ($pageNum = 1; $pageNum <= $this->pages[$collectionIndex]; $pageNum++)
            {
                $this->crawlers[$collectionIndex][$pageNum] = $this->client->request('GET', $collectionUrl);
            }
        }
    }

    public function getCollectionsNumber()
    {
        return count($this->collections);
    }

    /**
     * @param bool $isSale
     * @param array $prices
     * @return string
     */
    protected function setPriceType(array $prices, bool $isSale = false)
    {
        $priceType = 'normal';
        if ($isSale)
        {
            $priceType = 'sale';
            if (strtolower($prices[0]) === 'from' && count($prices) === 2)
            {
                $priceType = 'normal_from';
            }
            elseif (strtolower($prices[0]) === 'from' && count($prices) === 3)
            {
                $priceType = 'sale_from';
            }
        }
        if ($prices[0] === 'Sold Out')
        {
            $priceType = 'sold';
        }
        return $priceType;
    }

    private function setPreCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            $this->crawlers[$collectionIndex][1] = $this->client->request('GET', $collectionUrl);
        }
    }

    /**
     * Prepare website ID for website scraping data
     * (Website scraping name must be the same as website name in DB)
     *
     * @return void
     */
    private function prepareWebsiteId(): void
    {
        try
        {
            $this->websiteId = Website::where('name', (new ReflectionClass($this))->getShortName())->first()->id;
        } catch (ReflectionException $e)
        {
            dd($e->getMessage());
        }
    }
}
