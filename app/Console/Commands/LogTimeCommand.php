<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class LogTimeCommand extends Command
{
    protected $signature = 'log:time';
    protected $description = 'Log current time to the Laravel log';

    public function handle()
    {
        $telegram = new TelegramService();
        $telegram->sendMessage(env('TELEGRAM_LOGS_CHAT_ID'), 'Current time: ' . now()->toDateTimeString());
        $this->info('Time logged successfully!');
    }
}
