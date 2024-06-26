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
use Illuminate\Support\Str;
use Jiannei\LaravelCrawler\Support\Facades\Crawler;

class FetchTest extends \Orchestra\Testbench\TestCase
{
    public function testFetch()
    {
        $crawler = Crawler::fetch('https://www.ithome.com/html/discovery/358585.htm');

        $title = $crawler->filter('h1')->text();
        $author = $crawler->filter('#author_baidu>strong')->text();
        $content = $crawler->filter('.post_content')->text();

        // 等价于
        $result = $crawler->parse([
            'title' => ['h1', 'text'],
            'author' => ['#author_baidu>strong', 'text'],
            'content' => ['.post_content', 'text'],
        ]);

        $this->assertEquals($title, $result['title']);
        $this->assertEquals($author, $result['author']);
        $this->assertEquals($content, $result['content']);
    }

    public function testList()
    {
        $crawler = Crawler::fetch('https://www.ithome.com/html/discovery/358585.htm');

        // 解析文章详情
        $article = [
            'title' => $crawler->filter('h1')->text(),
            'author' => $crawler->filter('#author_baidu>strong')->text(),
            'content' => $crawler->filter('.post_content')->html(),
        ];

        // 等价于
        $article2 = $crawler->parse([
            'title' => ['h1', 'text'],
            'author' => ['#author_baidu>strong', 'text'],
            'content' => ['.post_content', 'html'],
        ]);

        $this->assertEquals($article, $article2);
    }

    public function testListAdvanced()
    {
        $crawler = Crawler::fetch('https://it.ithome.com/ityejie');

        // 解析文章列表
        $articles = $crawler->filter('.bl li')->each(function ($node) {
            return [
                'title' => $node->filter('h2>a')->text(),
                'link' => $node->filter('h2>a')->attr('href'),
                'img' => $node->filter('a img')->attr('src'),
                'desc' => $node->filter('.m')->text(),
            ];
        });

        // 等价于
        $articles2 = $crawler->group('.bl li')->parse([
            'title' => ['h2>a', 'text'],
            'link' => ['h2>a', 'href'],
            'img' => ['a>img', 'src'],
            'desc' => ['.m', 'text'],
        ])->all();

        $this->assertEquals($articles, $articles2);
    }

    public function testTransformResult()
    {
        $crawler = Crawler::fetch('https://www.ithome.com/html/discovery/358585.htm');

        $title = $crawler->filter('h1')->text();
        $author = $crawler->filter('#author_baidu>strong')->text();
        $content = $crawler->filter('.post_content')->text();

        // 等价于
        $result = $crawler->parse([
            'title' => ['h1', 'text'],
            'author' => ['#author_baidu>strong', 'text'],
            'content' => ['.post_content', 'text', null, function (\Symfony\Component\DomCrawler\Crawler $crawler, \Illuminate\Support\Stringable $value) {
                return $value->limit(120);
            }],
        ]);

        $this->assertEquals(Str::limit($content, 120), $result['content']);
        $this->assertEquals($title, $result['title']);
        $this->assertEquals($author, $result['author']);
    }
}
