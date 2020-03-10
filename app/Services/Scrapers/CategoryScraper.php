<?php
/**
 *  CategoryScraper file
 */

namespace App\Services\Scrapers;

use App\Category;
use App\Repositories\CategoryRepository;
use App\Services\Scrapers\Categories\AlpinTrek;
use App\Services\Scrapers\Categories\RockRun;
use App\Services\Scrapers\Categories\TrekkInn;

/**
 * Class CategoryScraper
 * @package App\Services\Scrapers
 */
class CategoryScraper extends ScraperAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new CategoryRepository(new Category());
        $this->websites = [
            AlpinTrek::class,
            RockRun::class,
            TrekkInn::class,
        ];
    }
}
