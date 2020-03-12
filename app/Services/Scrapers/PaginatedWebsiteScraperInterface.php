<?php

namespace App\Services\Scrapers;

interface PaginatedWebsiteScraperInterface
{
    public function getData();

    public function updatePagesNumber();
}
