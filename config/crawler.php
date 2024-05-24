<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

// $suffix = now()->format('Y-m-d');

return [
    'debug' => false, // http client debug

    'source' => [
        'default' => env('CRAWLER_SOURCE_CHANNEL', 'file'),

        'channels' => [
            'file' => resource_path('crawler.json'),
            'database' => \PannonPuma\LaravelCrawler\Models\CrawlTask::class,
        ],
    ],

    'consume' => [
        'service' => '', // PannonPuma\LaravelCrawler\Contracts\ConsumeService
    ],

    'log' => [
        'driver' => 'daily',
        'path' => storage_path('logs/crawler.log'),
        'level' => env('CRAWLER_LOG_LEVEL', 'debug'),
        'days' => 14,
    ],

    'guzzle' => [ // Guzzle http client
        // https://docs.guzzlephp.org/en/stable/request-options.html
        'options' => [
            'debug' => false, // fopen(storage_path("logs/crawler-guzzle-{$suffix}.log"), 'a+')
            'connect_timeout' => 10,
            'http_errors' => false,
            'timeout' => 30,

            'headers' => [
                'Accept-Encoding' => 'gzip',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36',
            ],
        ],
    ],

    'chrome' => [ // Chrome driver
        'server' => [
            'url' => 'http://chrome',
            'port' => 4444,
        ],
        'arguments' => ['--headless', '--disable-gpu'], // https://chromedriver.chromium.org/capabilities
        'wait' => [
            'timeout_in_second' => 30,
            'interval_in_millisecond' => 250,
        ],
        'log' => [
            'path' => storage_path('logs/crawler-server.log'),
            'level' => 'INFO', // set log level: ALL, DEBUG, INFO, WARNING, SEVERE, OFF
        ],
    ],
    'php' => [ // Php curl
        'path' => base_path('crawler/php/url.php'),
    ],
    'curl' => [ // Shell curl
        'path' => '/usr/bin/curl',
        'parallel' => 5,
    ],
    'stealth' => [ // Puppeteer stealth
        'path' => base_path('crawler/stealth/stealth.cjs'),
        'generic' => [
            'generic/url.cjs',
//            'generic/list.cjs',
//            'generic/item.cjs',
//            'generic/form.cjs',
        ],
        'website' => [
            'autoscout24' => [
                'search' => 'website/autoscout24-simple-search.cjs',
            ],

        ],
    ],
    'scrapy' => [ // Python scrapy
        'path' => base_path('crawler/scrapy/scrapy'),
        'spiders' => [
            'url.py',
            'adac.py',
            'hahu.py',
//            'as24.py',
//            'mobile.py',
//            'joautok.py',
//            'jofogas.py',
//            'kocsihu.py',
        ],
    ],
    'cli' => [ // Documentation
        'path' => base_path('crawler/cli'),
    ],
    'web' => [ // Php curl
        'https://hasznaltauto.info.hu/?url=',
        'https://winstonsmith.xyz?url=',
    ],
    'rss' => [
        [
            'alias' => 'channel',
            'selector' => 'channel',
            'rules' => [
                'title' => ['title', 'text'],
                'link' => ['link', 'text'],
                'description' => ['description', 'text'],
                'pubDate' => ['pubDate', 'text'],
            ],
        ],
        [
            'alias' => 'items',
            'selector' => 'channel item',
            'rules' => [
                'category' => ['category', 'text'],
                'title' => ['title', 'text'],
                'description' => ['description', 'text'],
                'link' => ['link', 'text'],
                'guid' => ['guid', 'text'],
                'pubDate' => ['pubDate', 'text'],
            ],
        ],
    ],
];
