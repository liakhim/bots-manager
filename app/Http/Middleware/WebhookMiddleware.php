<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebhookMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Пример: проверка подписи webhook
        // или специальная обработка для webhooks

        return $next($request);
    }
}
