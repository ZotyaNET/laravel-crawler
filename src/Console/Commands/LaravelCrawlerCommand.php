<?php

namespace PannonPuma\LaravelCrawler\Console\Commands;

use Illuminate\Console\Command;

class LaravelCrawlerCommand extends Command
{
    public $signature = 'crawler:sync {-crawler=chrome}';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
