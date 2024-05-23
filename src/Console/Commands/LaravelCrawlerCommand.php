<?php

namespace PannonPuma\LaravelCrawler\Console\Commands;

use Illuminate\Console\Command;

class LaravelCrawlerCommand extends Command
{
    public $signature = 'laravel-crawler';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
