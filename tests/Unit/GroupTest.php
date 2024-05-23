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

use Illuminate\Foundation\Testing\TestCase;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use PannonPuma\LaravelCrawler\Facades\Crawler;


class GroupTest extends \Orchestra\Testbench\TestCase
{
    public function testParse()
    {
        $crawler = Crawler::fetch('https://packagist.org/feeds/packages.rss');

        // 单个元素 filter + parse
        $channel1 = $crawler->filter('channel')->parse([
            'title' => ['title', 'text'],
            'link' => ['link', 'text'],
            'description' => ['description', 'text'],
            'lastBuildDate' => ['pubDate', 'text'],
        ]);

        // 单个元素 group + parse
        $channel2 = $crawler->group('channel')->parse([
            'title' => ['title', 'text'],
            'link' => ['link', 'text'],
            'description' => ['description', 'text'],
            'lastBuildDate' => ['pubDate', 'text'],
        ]);

        $this->assertIsArray($channel1);
        $this->assertInstanceOf(Collection::class, $channel2);
        $this->assertEquals($channel1, $channel2->first());
        $this->assertArrayHasKey('title', $channel1);
    }

    public function testGroupParse()
    {
        $crawler = Crawler::fetch('https://packagist.org/feeds/packages.rss');

        $items = $crawler->group('channel item')->parse([
            'category' => ['category', 'text'],
            'title' => ['title', 'text'],
            'description' => ['description', 'text'],
            'link' => ['link', 'text'],
            'guid' => ['guid', 'text'],
            'pubDate' => ['pubDate', 'text'],
        ]);

        $this->assertInstanceOf(Collection::class, $items);
        $this->assertIsArray($items->all());
        $this->assertTrue(Arr::isList($items->all()));
    }
}
