<?php

/*
 * This file is part of the pannonpuma/laravel-crawler.
 *
 * (c) Zoltan Karpat <karpat.zoltan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PannonPuma\LaravelCrawler\Listeners;

use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Support\Facades\Log;

class RequestSendingListener
{
    public function handle(RequestSending $event): void
    {
        $request = Message::toString($event->request->toPsrRequest());

        Log::channel('crawler')->info('http', ['hook' => 'RequestSending', 'request' => $request]);
    }
}
