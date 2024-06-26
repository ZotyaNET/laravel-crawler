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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|CrawlTask active()
 */
class CrawlTask extends Model
{
    protected $fillable = [
        'name',
        'expression',
        'pattern',
        'active',
    ];

    protected $casts = [
        'pattern' => 'json',
    ];

    public function records()
    {
        return $this->hasMany(CrawlRecord::class, 'task_id');
    }

    /**
     * Scope a query to only include active tasks.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }
}
