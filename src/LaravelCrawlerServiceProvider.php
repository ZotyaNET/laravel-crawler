<?php

namespace PannonPuma\LaravelCrawler;

use PannonPuma\LaravelCrawler\Console\Commands\CrawlerRecord;
use PannonPuma\LaravelCrawler\Console\Commands\CrawlerServer;
use PannonPuma\LaravelCrawler\Console\Commands\CrawlerTask;
use PannonPuma\LaravelCrawler\Console\Commands\LaravelCrawlerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCrawlerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-crawler')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-crawler_table')
            ->hasCommand(LaravelCrawlerCommand::class)
            ->hasCommand(CrawlerTask::class)
            ->hasCommand(CrawlerRecord::class)
            ->hasCommand(CrawlerServer::class);
    }
}
