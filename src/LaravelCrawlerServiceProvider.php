<?php

namespace PannonPuma\LaravelCrawler;

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
            ->hasCommand(LaravelCrawlerCommand::class);
    }
}
