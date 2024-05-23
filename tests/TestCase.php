<?php

namespace PannonPuma\LaravelCrawler\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use PannonPuma\LaravelCrawler\LaravelCrawlerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'PannonPuma\\LaravelCrawler\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelCrawlerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-crawler_table.php.stub';
        $migration->up();
        */
    }
}
