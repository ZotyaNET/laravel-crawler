<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Contracts;

use PannonPuma\LaravelCrawler\Models\CrawlRecord;
use PannonPuma\LaravelCrawler\Models\CrawlTask;

interface ConsumeService
{
    public function process(CrawlTask $task, CrawlRecord $record): bool;

    public function valid(CrawlTask $task): string;
}
