<?php
/**
 *  CategoryScraper file
 */

namespace App\Services\Scrapers;

use App\Category;
use App\Repositories\CategoryRepository;

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

        ];
    }
}
