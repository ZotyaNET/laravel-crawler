<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Support\Traits;

use PannonPuma\LaravelCrawler\Models\CrawlRecord;
use PannonPuma\LaravelCrawler\Models\CrawlTask;

trait Consumable
{
    public function process(CrawlTask $task, CrawlRecord $record): bool
    {
        $method = $this->valid($task);

        $this->before();

        $result = $this->{$method}()($record, $task);

        $this->after();

        return $result;
    }

    public function valid(CrawlTask $task): string
    {
        $method = $task->pattern['consume'] ?? 'defaultCallback';

        if (!method_exists($this, $method) || !is_callable($this->{$method}())) {
            throw new \RuntimeException('consume config illegal');
        }

        return $method;
    }

    protected function before()
    {
    }

    protected function after()
    {
    }
}
