<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use PannonPuma\LaravelCrawler\Facades\Crawler;
use PannonPuma\LaravelCrawler\Tests\TestCase;

class RssTest extends \Orchestra\Testbench\TestCase
{
    public function testRss()
    {
        $result = Crawler::rss('https://packagist.org/feeds/packages.rss');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->has('channel'));
        $this->assertTrue($result->has('items'));
        $this->assertTrue(Arr::isList($result->get('items')));
    }
}
