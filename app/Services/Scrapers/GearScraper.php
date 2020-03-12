<?php
/**
 *  GearScraper file
 */

namespace App\Services\Scrapers;

use App\Gear;
use App\Repositories\GearRepository;

/**
 * Class GearScraper
 * @package App\Services\Scrapers
 */
class GearScraper extends ScraperAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new GearRepository(new Gear());
        $this->websites = [
            Roc
        ];
    }
}
