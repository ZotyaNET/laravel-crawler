<?php

namespace PannonPuma\LaravelCrawler;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use PannonPuma\LaravelCrawler\Commands\LaravelCrawlerCommand;

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
