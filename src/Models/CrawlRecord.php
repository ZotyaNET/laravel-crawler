<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Models;

use Illuminate\Database\Eloquent\Model;

class CrawlRecord extends Model
{
    protected $fillable = [
        'content',
    ];
    protected $casts = [
        'content' => 'json',
    ];

    public function task()
    {
        return $this->belongsTo(CrawlTask::class, 'task_id');
    }
}
