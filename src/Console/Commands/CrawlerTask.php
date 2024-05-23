<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PannonPuma\LaravelCrawler\Jobs\TaskRun;
use PannonPuma\LaravelCrawler\Models\CrawlTask;
use PannonPuma\LaravelCrawler\Support\Facades\Crawler;

class CrawlerTask extends Command implements Isolatable
{
    protected $signature = 'crawler:task {name?} {--action=run}';

    protected $description = 'Manage crawler tasks.';

    public function handle()
    {
        $this->info("[{$this->description}]:starting ".now()->format('Y-m-d H:i:s'));

        match ($this->option('action')) {
            default => $this->runTask(),
            'export' => $this->export(),
            'import' => $this->import()
        };

        $this->info("[{$this->description}]:finished ".now()->format('Y-m-d H:i:s'));
    }

    protected function import()
    {
        $this->comment('importing...');

        Crawler::source('database', Crawler::source()->all());
    }

    protected function export()
    {
        $this->comment('exporting...');

        Crawler::source('file', Crawler::source('database')->all());
    }

    protected function runTask()
    {
        $tasks = CrawlTask::where('active', true)
            ->where(function (Builder $query) {
                $query->where('next_run_date', '<=', Carbon::now())
                    ->orWhereNull('next_run_date');
            })
            ->when($this->argument('name'), function (Builder $query, string $name) {
                $query->where('name', $name);
            })
            ->get();

        $tasks->each(function ($task) {
            $this->comment('running:'.$task->name);

            dispatch(new TaskRun($task));
        });
    }
}
