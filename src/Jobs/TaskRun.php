<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Jobs;

use Cron\CronExpression;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PannonPuma\LaravelCrawler\Models\CrawlTask;
use PannonPuma\LaravelCrawler\Support\Facades\Crawler;

class TaskRun implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected readonly CrawlTask $task)
    {
        $this->afterCommit();
    }

    public function handle()
    {
        DB::transaction(function () {
            $result = [];

            try {
                $result = Crawler::pattern($this->task->pattern);
                $this->task->previous_run_date = Carbon::now();
                $this->task->next_run_date = Carbon::instance((new CronExpression($this->task->expression))->getNextRunDate());
                $this->task->status = 1;
                $this->task->exception = '';
            } catch (\Throwable $e) {
                $this->task->status = -1;
                $this->task->exception = $e;

                Log::channel('crawler')->debug('task', ['exception' => $e->getMessage()]);
            }

            $this->task->save();

            if (is_array($result)) {
                $result = collect($result);
            }

            $contents = $result->map(function ($item) {
                return ['content' => $item];
            });

            $this->task->records()->createMany($contents->all());
        });
    }
}
