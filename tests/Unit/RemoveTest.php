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

use PannonPuma\LaravelCrawler\Facades\Crawler;


class RemoveTest extends \Orchestra\Testbench\TestCase
{
    protected string $html = <<<STR
    <div id="content">

        <span class="tt">作者：xxx</span>

        这是正文内容段落1.....

        <span>这是正文内容段落2</span>

        <p>这是正文内容段落3......</p>

        <a href="http://querylist.cc">QueryList官网</a>

        <span>这是广告</span>
        <p>这是版权声明！</p>
    </div>
STR;

    public function testRemoveHtml()
    {
        $crawler = Crawler::new($this->html);

        $rules = [
            ['.tt', 'outerHtml'],
            ['span', 'outerHtml', 'last'],
            ['p', 'outerHtml', 'last'],
            ['a', 'outerHtml'],
        ];

        // ['.tt', 'span' => 'last', 'p' => 'last', 'a']
        $html = $crawler->filter('#content')->remove($rules);

        $expected = <<<STR
这是正文内容段落1.....

        <span>这是正文内容段落2</span>

        <p>这是正文内容段落3......</p>
STR;

        $this->assertEquals($expected, trim($html));
    }
}
