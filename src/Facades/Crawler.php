<?php

namespace PannonPuma\LaravelCrawler\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PannonPuma\LaravelCrawler\LaravelCrawler
 */
class Crawler extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \PannonPuma\LaravelCrawler\LaravelCrawler::class;
    }
}
