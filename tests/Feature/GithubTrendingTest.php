<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Tests\Feature;

use Orchestra\Testbench\TestCase;
use PannonPuma\LaravelCrawler\Facades\Crawler;


class GithubTrendingTest extends TestCase
{
    public function testTrendingRepos()
    {
        $url = 'https://github.com/trending';
        $crawler = Crawler::fetch($url, ['spoken_language_code' => 'zh', 'since' => 'daily']);

        $rules = [
            'repo' => ['h1 a', 'href'],
            'desc' => ['p', 'text'],
            'language' => ["span[itemprop='programmingLanguage']", 'text'],
            'stars' => ['div.f6.color-fg-muted.mt-2 > a:nth-of-type(1)', 'text'],
            'forks' => ['div.f6.color-fg-muted.mt-2 > a:nth-of-type(2)', 'text'],
            'added_stars' => ['div.f6.color-fg-muted.mt-2 > span.d-inline-block.float-sm-right', 'text'],
        ];

        $trending = $crawler->group('article')->parse($rules)->all();

        $this->assertIsArray($trending);
    }
}
